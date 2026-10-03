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
        // SQLite (used by the test suite) creates this enum as a string and
        // does not support MySQL's ALTER TABLE ... MODIFY syntax.
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("
            ALTER TABLE events
            MODIFY status ENUM(
                'upcoming',
                'completed'

            ) DEFAULT 'upcoming'
        ");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("
            ALTER TABLE events
            MODIFY status ENUM(
                'upcoming',
                'completed',
            ) DEFAULT 'upcoming'
        ");
    }
};
