<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const NEW_LEVELS = ['beginner', 'basic', 'intermediate', 'advanced', 'expert'];

    private const OLD_LEVELS = ['beginner', 'intermediate', 'expert'];

    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return; // SQLite stores ENUM as TEXT and doesn't enforce constraints
        }

        // Use raw SQL for enum change as Laravel's Schema doesn't support it properly with Doctrine
        $newEnum = "'".implode("','", self::NEW_LEVELS)."'";
        DB::statement("ALTER TABLE resume_skills MODIFY COLUMN proficiency ENUM({$newEnum}) NOT NULL");
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        // Revert to original enum values
        $oldEnum = "'".implode("','", self::OLD_LEVELS)."'";
        DB::statement("ALTER TABLE resume_skills MODIFY COLUMN proficiency ENUM({$oldEnum}) NOT NULL");
    }
};
