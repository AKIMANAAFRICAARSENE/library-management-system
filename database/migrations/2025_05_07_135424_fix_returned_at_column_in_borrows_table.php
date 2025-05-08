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
        // First, drop the column if it exists
        if (Schema::hasColumn('borrows', 'returned_at')) {
            Schema::table('borrows', function (Blueprint $table) {
                $table->dropColumn('returned_at');
            });
        }

        // Then recreate it properly
        Schema::table('borrows', function (Blueprint $table) {
            $table->timestamp('returned_at')->nullable()->after('deadline');
        });

        // Update existing records based on status and return_date
        DB::statement('UPDATE borrows SET returned_at = return_date WHERE status = "returned" AND return_date IS NOT NULL');
        DB::statement('UPDATE borrows SET returned_at = NOW() WHERE status = "returned" AND returned_at IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't want to reverse this fix
    }
};
