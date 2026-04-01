<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            // SQLite stores JSON as TEXT, just need to update the values
            DB::statement("UPDATE blogs SET title = '{\"en\": \"' || title || '\"}'");
            DB::statement("UPDATE blogs SET slug  = '{\"en\": \"' || slug  || '\"}'");
            DB::statement("UPDATE blogs SET excerpt = '{\"en\": \"' || excerpt || '\"}' WHERE excerpt IS NOT NULL");
            DB::statement("UPDATE blogs SET content = '{\"en\": \"' || content || '\"}'");

            return;
        }

        // Convert existing plain-string values to JSON objects keyed by 'en'.
        // Must happen before changing column types so MySQL accepts the conversion.
        DB::statement("UPDATE blogs SET title = JSON_OBJECT('en', title)");
        DB::statement("UPDATE blogs SET slug  = JSON_OBJECT('en', slug)");
        DB::statement("UPDATE blogs SET excerpt = JSON_OBJECT('en', excerpt) WHERE excerpt IS NOT NULL");
        DB::statement("UPDATE blogs SET content = JSON_OBJECT('en', content)");

        // Drop the unique index on slug before converting to JSON (MySQL doesn't support indexing JSON columns directly)
        DB::statement('ALTER TABLE blogs DROP INDEX blogs_slug_unique');

        // Use raw SQL for JSON column changes as MySQL doesn't support change() to JSON type
        DB::statement('ALTER TABLE blogs MODIFY COLUMN title JSON NOT NULL');
        DB::statement('ALTER TABLE blogs MODIFY COLUMN slug JSON NOT NULL');
        DB::statement('ALTER TABLE blogs MODIFY COLUMN excerpt JSON NULL');
        DB::statement('ALTER TABLE blogs MODIFY COLUMN content JSON NOT NULL');
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            // Extract values from JSON for SQLite
            DB::statement("UPDATE blogs SET title = json_extract(title, '$.en')");
            DB::statement("UPDATE blogs SET slug  = json_extract(slug,  '$.en')");
            DB::statement("UPDATE blogs SET excerpt = json_extract(excerpt, '$.en') WHERE excerpt IS NOT NULL");
            DB::statement("UPDATE blogs SET content = json_extract(content, '$.en')");

            return;
        }

        // Extract the 'en' locale value back to plain strings before reverting column types.
        DB::statement("UPDATE blogs SET title = JSON_UNQUOTE(JSON_EXTRACT(title, '$.en'))");
        DB::statement("UPDATE blogs SET slug  = JSON_UNQUOTE(JSON_EXTRACT(slug,  '$.en'))");
        DB::statement("UPDATE blogs SET excerpt = JSON_UNQUOTE(JSON_EXTRACT(excerpt, '$.en')) WHERE excerpt IS NOT NULL");
        DB::statement("UPDATE blogs SET content = JSON_UNQUOTE(JSON_EXTRACT(content, '$.en'))");

        // Use raw SQL for column type changes back to original types
        DB::statement('ALTER TABLE blogs MODIFY COLUMN title VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE blogs MODIFY COLUMN slug VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE blogs MODIFY COLUMN excerpt TEXT NULL');
        DB::statement('ALTER TABLE blogs MODIFY COLUMN content LONGTEXT NOT NULL');
    }
};
