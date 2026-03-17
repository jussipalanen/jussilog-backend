<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeSkill extends Model
{
    use HasFactory;

    protected $table = 'resume_skills';

    protected $fillable = [
        'resume_id',
        'category',
        'name',
        'proficiency',
        'sort_order',
    ];

    protected $appends = ['points'];

    /** Valid skill category slugs used for validation and filtering. */
    public const CATEGORIES = [
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
        'other',
    ];

    /** Valid skill proficiency levels, ordered from lowest to highest. */
    public const PROFICIENCY_LEVELS = [
        'beginner',     // Just starting out
        'basic',        // Can handle simple tasks
        'intermediate', // Works independently on common tasks
        'advanced',     // Handles complex scenarios confidently
        'expert',       // Deep mastery
    ];

    /** Maps each proficiency level to a numeric score (1–5) for sorting/display. */
    private const PROFICIENCY_POINTS = [
        'beginner'     => 1,
        'basic'        => 2,
        'intermediate' => 3,
        'advanced'     => 4,
        'expert'       => 5,
    ];

    public function getPointsAttribute(): ?int
    {
        return self::PROFICIENCY_POINTS[$this->proficiency] ?? null;
    }

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
