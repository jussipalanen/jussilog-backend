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
            $table->enum('category', [
                'programming_languages',
                'scripting_languages',
                'markup_languages',
                'query_languages',
                'frontend_technologies',
                'backend_technologies',
                'full_stack_development',
                'frameworks',
                'libraries',
                'ui_ux_design',
                'responsive_design',
                'mobile_development',
                'desktop_development',
                'game_development',
                'embedded_systems',
                'databases',
                'database_design',
                'database_administration',
                'orm_data_access',
                'api_development',
                'web_services',
                'graphql',
                'microservices',
                'event_driven_architecture',
                'devops',
                'cloud_platforms',
                'serverless',
                'containerization',
                'ci_cd',
                'infrastructure_as_code',
                'configuration_management',
                'version_control',
                'testing_qa',
                'test_automation',
                'security',
                'authentication_authorization',
                'networking',
                'performance_optimization',
                'architecture_design_patterns',
                'system_design',
                'distributed_systems',
                'data_engineering',
                'big_data',
                'machine_learning_ai',
                'monitoring_logging',
                'development_tools',
                'operating_systems',
                'project_management',
                'agile_methodologies',
                'soft_skills',
            ]);
            $table->string('name');
            $table->enum('proficiency', ['beginner', 'basic', 'intermediate', 'advanced', 'expert']);
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
