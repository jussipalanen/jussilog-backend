<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Convert existing plain-string values to JSON objects keyed by 'en'.
        // Must happen before changing column types so MySQL accepts the conversion.
        DB::statement("UPDATE blogs SET title = JSON_OBJECT('en', title)");
        DB::statement("UPDATE blogs SET slug  = JSON_OBJECT('en', slug)");
        DB::statement("UPDATE blogs SET excerpt = JSON_OBJECT('en', excerpt) WHERE excerpt IS NOT NULL");
        DB::statement("UPDATE blogs SET content = JSON_OBJECT('en', content)");

        Schema::table('blogs', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('slug')->change();
            $table->json('excerpt')->nullable()->change();
            $table->json('content')->change();
        });
    }

    public function down(): void
    {
        // Extract the 'en' locale value back to plain strings before reverting column types.
        DB::statement("UPDATE blogs SET title = JSON_UNQUOTE(JSON_EXTRACT(title, '$.en'))");
        DB::statement("UPDATE blogs SET slug  = JSON_UNQUOTE(JSON_EXTRACT(slug,  '$.en'))");
        DB::statement("UPDATE blogs SET excerpt = JSON_UNQUOTE(JSON_EXTRACT(excerpt, '$.en')) WHERE excerpt IS NOT NULL");
        DB::statement("UPDATE blogs SET content = JSON_UNQUOTE(JSON_EXTRACT(content, '$.en'))");

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('title')->change();
            $table->string('slug')->change();
            $table->text('excerpt')->nullable()->change();
            $table->longText('content')->change();
        });
    }
};
