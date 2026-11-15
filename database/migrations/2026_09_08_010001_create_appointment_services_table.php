<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create appointment_services pivot table
        Schema::create('appointment_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // 2. Add duration_minutes and ensure service_id is nullable on appointments table
        Schema::table('appointments', function (Blueprint $table) {
            $table->integer('duration_minutes')->default(30)->after('scheduled_at');
            $table->unsignedBigInteger('service_id')->nullable()->change();
        });

        // 3. Migrate existing single service_id into appointment_services pivot table
        $appointments = DB::table('appointments')->whereNotNull('service_id')->get();
        foreach ($appointments as $appointment) {
            DB::table('appointment_services')->insertOrIgnore([
                'appointment_id' => $appointment->id,
                'service_id'     => $appointment->service_id,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('duration_minutes');
        });

        Schema::dropIfExists('appointment_services');
    }
};
