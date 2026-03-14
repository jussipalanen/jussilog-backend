<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->boolean('is_public')->default(false)->after('is_primary');
            $table->string('code')->nullable()->after('is_public');
            $table->dropColumn('password');
        });
    }

    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn(['is_public', 'code']);
            $table->string('password')->nullable()->after('is_primary');
        });
    }
};
