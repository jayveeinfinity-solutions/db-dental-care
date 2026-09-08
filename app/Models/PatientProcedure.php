<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientProcedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'transaction_id',
        'service_id',
        'procedure_date',
        'procedure_name',
        'tooth_number',
        'target_specifics',
        'amount',
        'medical_history',
    ];

    protected $casts = [
        'procedure_date' => 'date',
        'amount' => 'decimal:2',
    ];

    protected $appends = ['formatted_date'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    protected function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                isset($attributes['procedure_date'])
                    ? Carbon::parse($attributes['procedure_date'])->format('F j, Y')
                    : '',
        );
    }
}
