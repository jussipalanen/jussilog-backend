<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'juzapala+superadmin@gmail.com')->first();

        if (! $user) {
            $this->command->warn('BlogSeeder: admin user not found, skipping.');

            return;
        }

        $category = BlogCategory::firstOrCreate(['name' => 'Default']);

        Blog::firstOrCreate(
            ['title' => ['en' => 'Welcome to the Blog']],
            [
                'user_id'          => $user->id,
                'blog_category_id' => $category->id,
                'title'            => ['en' => 'Welcome to the Blog', 'fi' => 'Tervetuloa blogiin'],
                'slug'             => ['en' => 'welcome-to-the-blog', 'fi' => 'tervetuloa-blogiin'],
                'excerpt'          => ['en' => 'This is the first blog post.', 'fi' => 'Tämä on ensimmäinen blogikirjoitus.'],
                'content'          => ['en' => '<p>Welcome! This is an example blog post created by the seeder.</p>', 'fi' => '<p>Tervetuloa! Tämä on esimerkki blogikirjoitus, jonka seeder on luonut.</p>'],
                'visibility'       => true,
            ]
        );
    }
}
