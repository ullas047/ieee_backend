<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Bring legacy production schemas that use the misspelled "upcomming"
     * enum value in line with the application value, "upcoming".
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            // Allow both spellings before converting existing legacy records.
            DB::statement(
                "ALTER TABLE events MODIFY status ENUM('upcomming', 'upcoming', 'completed') DEFAULT 'upcoming'"
            );
        }

        DB::table('events')
            ->where('status', 'upcomming')
            ->update(['status' => 'upcoming']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                "ALTER TABLE events MODIFY status ENUM('upcoming', 'completed') DEFAULT 'upcoming'"
            );
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement(
            "ALTER TABLE events MODIFY status ENUM('upcomming', 'upcoming', 'completed') DEFAULT 'upcoming'"
        );
    }
};
