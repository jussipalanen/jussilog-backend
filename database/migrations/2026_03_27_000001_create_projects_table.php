<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('slug');
            $table->json('short_description')->nullable();
            $table->json('long_description')->nullable();
            $table->string('feature_image')->nullable();
            $table->json('images')->nullable();
            $table->enum('visibility', ['show', 'hide'])->default('hide');
            $table->string('live_url')->nullable();
            $table->string('github_url')->nullable();
            $table->timestamps();

            $table->index(['visibility', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
