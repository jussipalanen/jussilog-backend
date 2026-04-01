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
                'title'            => ['en' => 'Welcome to the Blog'],
                'slug'             => ['en' => 'welcome-to-the-blog'],
                'excerpt'          => ['en' => 'This is the first blog post.'],
                'content'          => ['en' => '<p>Welcome! This is an example blog post created by the seeder.</p>'],
                'visibility'       => true,
            ]
        );
    }
}
