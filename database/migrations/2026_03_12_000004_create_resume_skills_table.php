<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resume_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained('resumes')->cascadeOnDelete();
            $table->string('category'); // e.g. Languages, Tools, Frameworks
            $table->string('name');
            $table->enum('proficiency', ['beginner', 'intermediate', 'expert']);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('resume_id');
            $table->index(['resume_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resume_skills');
    }
};
