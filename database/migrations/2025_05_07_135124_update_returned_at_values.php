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
        // Update existing records: set returned_at to return_date for all returned books
        DB::statement('UPDATE borrows SET returned_at = return_date WHERE status = "returned" AND returned_at IS NULL AND return_date IS NOT NULL');

        // For any remaining records that are marked as returned but have no return_date or returned_at
        DB::statement('UPDATE borrows SET returned_at = NOW() WHERE status = "returned" AND returned_at IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to revert this data migration
    }
};
