<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resume_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained('resumes')->cascadeOnDelete();
            $table->string('language');
            $table->enum('proficiency', ['native', 'fluent', 'conversational', 'basic']);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('resume_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resume_languages');
    }
};
