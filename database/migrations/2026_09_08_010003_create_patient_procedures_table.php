<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->date('procedure_date');
            $table->string('procedure_name');
            $table->string('tooth_number')->nullable(); // e.g. "18", "14", "11-21" for Dental Chart
            $table->string('target_specifics'); // e.g. "Tooth #14 (Upper Left First Molar) - Occlusal"
            $table->decimal('amount', 12, 2)->default(0);
            $table->text('medical_history')->nullable(); // Clinical notes / procedure-specific medical history
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_procedures');
    }
};
