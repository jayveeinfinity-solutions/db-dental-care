<?php

use App\Models\User;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Category;
use App\Models\Appointment;
use App\Models\PatientProcedure;
use App\Events\AppointmentStatusChanged;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

beforeEach(function () {
    $this->category = Category::firstOrCreate(['name' => 'Preventive']);
    $this->consultation = Service::firstOrCreate(
        ['name' => 'Consultation'],
        ['category_id' => $this->category->id, 'price_min' => 500, 'price_max' => 500, 'duration_minutes' => 10]
    );
    $this->extraction = Service::firstOrCreate(
        ['name' => 'Simple Extraction'],
        ['category_id' => $this->category->id, 'price_min' => 1000, 'price_max' => 1500, 'duration_minutes' => 30]
    );
    $this->certificate = Service::firstOrCreate(
        ['name' => 'Dental Certificate'],
        ['category_id' => $this->category->id, 'price_min' => 500, 'price_max' => 500, 'duration_minutes' => 15]
    );

    $this->user = User::factory()->create();
    $this->patient = Patient::create([
        'user_id'        => $this->user->id,
        'code'           => 'PX-99999',
        'first_name'     => 'John',
        'last_name'      => 'Doe',
        'birthdate'      => '1995-01-01',
        'sex'            => 'male',
        'contact_number' => '09123456789',
        'address'        => 'Manila, Philippines',
    ]);
});

it('generates patient code with PX- prefix', function () {
    $patientService = app(\App\Services\PatientService::class);
    $newPatient = $patientService->create([
        'first_name'     => 'Jane',
        'last_name'      => 'Smith',
        'sex'            => 'female',
        'contact_number' => '09987654321',
        'address'        => 'Cavite, Philippines',
    ]);

    expect($newPatient->code)->toStartWith('PX-');
});

it('returns available slots and accurately computes duration for multiple services', function () {
    $appointmentService = app(\App\Services\AppointmentService::class);
    $duration = $appointmentService->calculateDuration([$this->consultation->id, $this->extraction->id]);

    expect($duration)->toBe(40); // 10 + 30 = 40 mins

    $tomorrow = Carbon::tomorrow()->toDateString();
    $slots = $appointmentService->getAvailableSlots($tomorrow, $duration);

    expect($slots)->toBeArray();
    expect(count($slots))->toBeGreaterThan(0);
});

it('allows booking an appointment with multiple services', function () {
    $this->actingAs($this->user);

    $tomorrow = Carbon::tomorrow()->toDateString();
    $response = $this->postJson('/api/v1/appointments', [
        'service_ids' => [$this->consultation->id, $this->extraction->id],
        'date'        => $tomorrow,
        'time'        => '09:00',
        'notes'       => 'Routine checkup and extraction',
    ]);

    $response->assertStatus(200);
    $response->assertJsonPath('appointment.status', 'pending');

    $appointmentId = $response->json('appointment.id');
    $appointment = Appointment::find($appointmentId);

    expect($appointment->services)->toHaveCount(2);
    expect($appointment->duration_minutes)->toBe(40);
});

it('strictly rejects past date and past time bookings', function () {
    $this->actingAs($this->user);

    $yesterday = Carbon::yesterday()->toDateString();
    $response = $this->postJson('/api/v1/appointments', [
        'service_ids' => [$this->consultation->id],
        'date'        => $yesterday,
        'time'        => '09:00',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['date']);
});

it('prevents double-booking and overlapping appointments', function () {
    $this->actingAs($this->user);
    $tomorrow = Carbon::tomorrow()->toDateString();

    // Create existing appointment from 10:00 to 11:00 (60 mins)
    $existing = Appointment::create([
        'user_id'          => $this->user->id,
        'patient_id'       => $this->patient->id,
        'service_id'       => $this->extraction->id,
        'scheduled_at'     => Carbon::parse("{$tomorrow} 10:00"),
        'duration_minutes' => 60,
        'status'           => 'approved',
    ]);
    $existing->services()->sync([$this->extraction->id]);

    // Attempt to book overlapping time 10:30
    $response = $this->postJson('/api/v1/appointments', [
        'service_ids' => [$this->consultation->id],
        'date'        => $tomorrow,
        'time'        => '10:30',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['time']);
});

it('dispatches AppointmentStatusChanged event on status update to approved or cancelled', function () {
    Event::fake([AppointmentStatusChanged::class]);
    $this->actingAs($this->user);

    $appointment = Appointment::create([
        'user_id'          => $this->user->id,
        'patient_id'       => $this->patient->id,
        'service_id'       => $this->consultation->id,
        'scheduled_at'     => Carbon::tomorrow(),
        'duration_minutes' => 30,
        'status'           => 'pending',
    ]);

    $response = $this->putJson("/api/v1/appointments/{$appointment->id}/status", [
        'status' => 'approved',
    ]);

    $response->assertStatus(200);

    Event::assertDispatched(AppointmentStatusChanged::class, function ($event) use ($appointment) {
        return $event->appointment->id === $appointment->id && $event->newStatus === 'approved';
    });
});

it('stores procedure history with date, tooth specifics, amount, and medical history', function () {
    $this->actingAs($this->user);

    $response = $this->postJson("/api/v1/patients/{$this->patient->id}/procedures", [
        'procedure_date'   => Carbon::today()->toDateString(),
        'procedure_name'   => 'Composite Filling',
        'tooth_number'     => '14',
        'target_specifics' => 'Tooth #14 (Upper Left First Molar) - Occlusal',
        'amount'           => 1200.00,
        'medical_history'  => 'Patient tolerated anesthesia well. No bleeding issues.',
    ]);

    $response->assertStatus(201);
    $response->assertJsonPath('procedure.tooth_number', '14');
    $response->assertJsonPath('procedure.amount', '1200.00');

    $this->assertDatabaseHas('patient_procedures', [
        'patient_id'   => $this->patient->id,
        'tooth_number' => '14',
    ]);
});

it('restricts PDF upload strictly to Dental Certificates on transactions', function () {
    Storage::fake('local');
    $this->actingAs($this->user);

    $file = UploadedFile::fake()->create('medical_cert.pdf', 100, 'application/pdf');

    // 1. Trying to attach PDF with general extraction (not Dental Certificate) -> REJECTED
    $rejectResponse = $this->postJson('/api/v1/transactions', [
        'patient_id' => $this->patient->id,
        'services'   => [
            ['id' => $this->extraction->id, 'amount' => 1500]
        ],
        'pdf_file'   => $file,
    ]);

    $rejectResponse->assertStatus(422);
    $rejectResponse->assertJsonValidationErrors(['pdf_file']);

    // 2. Attaching PDF with Dental Certificate -> ACCEPTED
    $acceptResponse = $this->postJson('/api/v1/transactions', [
        'patient_id' => $this->patient->id,
        'services'   => [
            ['id' => $this->certificate->id, 'amount' => 500]
        ],
        'pdf_file'   => $file,
    ]);

    $acceptResponse->assertStatus(200);
    $this->assertDatabaseHas('patient_histories', [
        'patient_id' => $this->patient->id,
    ]);
});
