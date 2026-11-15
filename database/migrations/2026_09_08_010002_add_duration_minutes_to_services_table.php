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
        Schema::table('services', function (Blueprint $table) {
            $table->integer('duration_minutes')->default(30)->after('price_max');
        });

        // Update default durations based on service types according to rev-1.md:
        // Consultation: 10 minutes
        DB::table('services')->where('name', 'like', '%Consultation%')->update(['duration_minutes' => 10]);
        DB::table('services')->where('name', 'like', '%Dental Certificate%')->update(['duration_minutes' => 15]);

        // Extractions (variable duration: 30 to 60 mins)
        DB::table('services')->where('name', 'Simple Extraction')->update(['duration_minutes' => 30]);
        DB::table('services')->where('name', 'Extraction (Child)')->update(['duration_minutes' => 30]);
        DB::table('services')->where('name', 'Complicated Extraction')->update(['duration_minutes' => 45]);
        DB::table('services')->where('name', 'like', '%Impaction%')->update(['duration_minutes' => 60]);
        DB::table('services')->where('name', 'Odontotomy')->update(['duration_minutes' => 60]);
        DB::table('services')->where('name', 'Apicoectomy')->update(['duration_minutes' => 60]);
        DB::table('services')->where('name', 'Frenectomy')->update(['duration_minutes' => 45]);

        // General / Restorative / Preventive (30m to 1 hour)
        DB::table('services')->where('name', 'like', '%Oral Prophylaxis%')->update(['duration_minutes' => 45]);
        DB::table('services')->where('name', 'like', '%Filling%')->update(['duration_minutes' => 45]);
        DB::table('services')->where('name', 'like', '%Endodontics%')->update(['duration_minutes' => 60]);
        DB::table('services')->where('name', 'like', '%Crown%')->update(['duration_minutes' => 60]);
        DB::table('services')->where('name', 'like', '%Implant%')->update(['duration_minutes' => 60]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('duration_minutes');
        });
    }
};
