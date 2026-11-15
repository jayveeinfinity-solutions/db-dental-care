<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointment_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // Migrate any existing appointment services
        try {
            $existing = DB::table('appointments')->whereNotNull('service_id')->get();
            foreach ($existing as $app) {
                DB::table('appointment_services')->insert([
                    'appointment_id' => $app->id,
                    'service_id'     => $app->service_id,
                    'created_at'     => $app->created_at ?? now(),
                    'updated_at'     => $app->updated_at ?? now(),
                ]);
            }
        } catch (\Throwable $e) {
            // Ignore if appointments table is empty or error occurs
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_services');
    }
};
