<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resume_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained('resumes')->cascadeOnDelete();
            $table->string('full_name');
            $table->string('title')->nullable();
            $table->string('company')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('recommendation')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index('resume_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resume_recommendations');
    }
};
