<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const NEW_LEVELS = ['beginner', 'basic', 'intermediate', 'advanced', 'expert'];
    private const OLD_LEVELS = ['beginner', 'intermediate', 'expert'];

    public function up(): void
    {
        Schema::table('resume_skills', function (Blueprint $table) {
            $table->enum('proficiency', self::NEW_LEVELS)->change();
        });
    }

    public function down(): void
    {
        Schema::table('resume_skills', function (Blueprint $table) {
            $table->enum('proficiency', self::OLD_LEVELS)->change();
        });
    }
};
