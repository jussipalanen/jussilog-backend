<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            // Stores generated thumbnail paths keyed by size name:
            // { "thumb": "resumes/1/thumb_…jpg", "small": "…", "medium": "…" }
            $table->json('photo_sizes')->nullable()->after('photo');
        });
    }

    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn('photo_sizes');
        });
    }
};
