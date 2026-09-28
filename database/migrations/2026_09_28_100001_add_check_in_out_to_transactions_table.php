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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('status')->default('in_progress')->after('total_amount'); // in_progress, completed
            $table->timestamp('checked_in_at')->nullable()->after('status');
            $table->timestamp('checked_out_at')->nullable()->after('checked_in_at');
            $table->unsignedInteger('duration_seconds')->nullable()->after('checked_out_at');
            $table->text('notes')->nullable()->after('duration_seconds');
        });

        // Update existing transactions to completed
        try {
            DB::table('transactions')->update([
                'status' => 'completed',
                'checked_in_at' => DB::raw('created_at'),
                'checked_out_at' => DB::raw('updated_at'),
                'duration_seconds' => 0,
            ]);
        } catch (\Throwable $e) {
            // Ignore
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['status', 'checked_in_at', 'checked_out_at', 'duration_seconds', 'notes']);
        });
    }
};
