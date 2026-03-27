<?php

namespace Database\Seeders;

use App\Enums\ProjectVisibility;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectTag;
use Illuminate\Database\Seeder;

/**
 * Seeds sample portfolio projects with categories and tags.
 */
class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categories
        $webCategory = ProjectCategory::firstOrCreate(
            ['slug' => 'web-development'],
            ['title' => 'Web Development']
        );

        $aiCategory = ProjectCategory::firstOrCreate(
            ['slug' => 'ai-ml'],
            ['title' => 'AI & Machine Learning']
        );

        // Tags
        $tags = [
            ['title' => 'React',                 'color' => '#61DAFB'],
            ['title' => 'PHP',                   'color' => '#777BB4'],
            ['title' => 'Laravel',               'color' => '#FF2D20'],
            ['title' => 'Node.js',               'color' => '#339933'],
            ['title' => 'JavaScript',            'color' => '#F7DF1E'],
            ['title' => 'TypeScript',            'color' => '#3178C6'],
            ['title' => 'Vue.js',                'color' => '#42B883'],
            ['title' => 'MySQL',                 'color' => '#4479A1'],
            ['title' => 'PostgreSQL',            'color' => '#4169E1'],
            ['title' => 'Docker',                'color' => '#2496ED'],
            ['title' => 'Google Cloud Platform', 'color' => '#4285F4'],
            ['title' => 'AWS',                   'color' => '#FF9900'],
            ['title' => 'Python',                'color' => '#3776AB'],
            ['title' => 'AI',                    'color' => '#A020F0'],
            ['title' => 'Terraform',             'color' => '#7B42BC'],
        ];

        $createdTags = [];
        foreach ($tags as $tagData) {
            $createdTags[$tagData['title']] = ProjectTag::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($tagData['title'])],
                ['title' => $tagData['title'], 'color' => $tagData['color']]
            );
        }

        // Sample project
        $project = Project::firstOrCreate(
            ['slug->en' => 'jussilog-portfolio'],
            [
                'title' => [
                    'en' => 'JussiLog Portfolio',
                    'fi' => 'JussiLog Portfolio',
                ],
                'short_description' => [
                    'en' => 'A personal portfolio and blog platform built with Laravel.',
                    'fi' => 'Henkilökohtainen portfolio ja blogialusta, joka on rakennettu Laravelilla.',
                ],
                'long_description' => [
                    'en' => '<p>JussiLog is a full-stack portfolio platform featuring a blog, resume builder, and project showcase. Built with Laravel 10 and deployed on Google Cloud Run.</p>',
                    'fi' => '<p>JussiLog on full-stack portfolio-alusta, joka sisältää blogin, ansioluettelon rakentajan ja projektiesittelyn. Rakennettu Laravel 10:llä ja otettu käyttöön Google Cloud Runissa.</p>',
                ],
                'visibility' => ProjectVisibility::SHOW,
                'live_url'   => 'https://jussilog.com',
                'github_url' => 'https://github.com/jussipalanen/jussilog-backend',
            ]
        );

        $project->categories()->sync([$webCategory->id, $aiCategory->id]);

        $project->tags()->sync([
            $createdTags['Laravel']->id,
            $createdTags['PHP']->id,
            $createdTags['MySQL']->id,
            $createdTags['Docker']->id,
            $createdTags['Google Cloud Platform']->id,
        ]);
    }
}
