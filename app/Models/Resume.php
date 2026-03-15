<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'full_name',
        'email',
        'phone',
        'location',
        'linkedin_url',
        'portfolio_url',
        'github_url',
        'photo',
        'photo_sizes',
        'summary',
        'language',
        'template',
        'theme',
        'is_primary',
        'is_public',
        'code',
        'show_skill_levels',
        'show_language_levels',
    ];

    protected $hidden = [];

    protected $appends = ['has_code'];

    protected $casts = [
        'photo_sizes'          => 'array',
        'is_primary'           => 'boolean',
        'is_public'            => 'boolean',
        'show_skill_levels'    => 'boolean',
        'show_language_levels' => 'boolean',
    ];

    public function getHasCodeAttribute(): bool
    {
        return ! empty($this->attributes['code']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(ResumeWorkExperience::class)->orderBy('sort_order')->orderByDesc('start_date');
    }

    public function educations(): HasMany
    {
        return $this->hasMany(ResumeEducation::class)->orderBy('sort_order')->orderByDesc('graduation_year');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(ResumeSkill::class)->orderBy('category')->orderBy('sort_order');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(ResumeProject::class)->orderBy('sort_order');
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(ResumeCertification::class)->orderBy('sort_order')->orderByDesc('issue_date');
    }

    public function languages(): HasMany
    {
        return $this->hasMany(ResumeLanguage::class)->orderBy('sort_order');
    }

    public function awards(): HasMany
    {
        return $this->hasMany(ResumeAward::class)->orderBy('sort_order')->orderByDesc('date');
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(ResumeRecommendation::class)->orderBy('sort_order');
    }
}
