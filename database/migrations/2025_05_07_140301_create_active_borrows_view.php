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
        // Create a trigger to update returned_at when status changes to 'returned'
        DB::unprepared('
            CREATE TRIGGER IF NOT EXISTS update_returned_at_trigger
            BEFORE UPDATE ON borrows
            FOR EACH ROW
            BEGIN
                IF NEW.status = "returned" AND (OLD.status = "borrowed" OR OLD.status = "delayed") THEN
                    SET NEW.returned_at = CURRENT_TIMESTAMP;
                END IF;
            END
        ');

        // Set returned_at for all existing returned books
        DB::statement('UPDATE borrows SET returned_at = return_date WHERE status = "returned" AND returned_at IS NULL AND return_date IS NOT NULL');
        DB::statement('UPDATE borrows SET returned_at = NOW() WHERE status = "returned" AND returned_at IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the trigger
        DB::unprepared('DROP TRIGGER IF EXISTS update_returned_at_trigger');
    }
};
