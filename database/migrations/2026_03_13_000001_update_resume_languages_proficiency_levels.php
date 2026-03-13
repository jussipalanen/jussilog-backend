<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: widen enum to include both old and new values so existing rows stay valid
        DB::statement("ALTER TABLE resume_languages MODIFY proficiency ENUM('native','fluent','conversational','basic','native_bilingual','full_professional','professional_working','limited_working','elementary') NOT NULL");

        // Step 2: migrate existing data to new values
        DB::statement("UPDATE resume_languages SET proficiency = 'native_bilingual'      WHERE proficiency = 'native'");
        DB::statement("UPDATE resume_languages SET proficiency = 'full_professional'     WHERE proficiency = 'fluent'");
        DB::statement("UPDATE resume_languages SET proficiency = 'professional_working'  WHERE proficiency = 'conversational'");
        DB::statement("UPDATE resume_languages SET proficiency = 'limited_working'       WHERE proficiency = 'basic'");

        // Step 3: narrow enum to only the new values
        DB::statement("ALTER TABLE resume_languages MODIFY proficiency ENUM('native_bilingual','full_professional','professional_working','limited_working','elementary') NOT NULL");
    }

    public function down(): void
    {
        // Step 1: widen to include both
        DB::statement("ALTER TABLE resume_languages MODIFY proficiency ENUM('native_bilingual','full_professional','professional_working','limited_working','elementary','native','fluent','conversational','basic') NOT NULL");

        // Step 2: revert data back to old values
        DB::statement("UPDATE resume_languages SET proficiency = 'native'         WHERE proficiency = 'native_bilingual'");
        DB::statement("UPDATE resume_languages SET proficiency = 'fluent'         WHERE proficiency = 'full_professional'");
        DB::statement("UPDATE resume_languages SET proficiency = 'conversational' WHERE proficiency = 'professional_working'");
        DB::statement("UPDATE resume_languages SET proficiency = 'basic'          WHERE proficiency IN ('limited_working','elementary')");

        // Step 3: narrow back to old values
        DB::statement("ALTER TABLE resume_languages MODIFY proficiency ENUM('native','fluent','conversational','basic') NOT NULL");
    }
};
