<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all patient codes from PAT-XXXXX to PX-XXXXX
        DB::statement("UPDATE patients SET code = REPLACE(code, 'PAT-', 'PX-') WHERE code LIKE 'PAT-%'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE patients SET code = REPLACE(code, 'PX-', 'PAT-') WHERE code LIKE 'PX-%'");
    }
};
