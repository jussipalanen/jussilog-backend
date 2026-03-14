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
