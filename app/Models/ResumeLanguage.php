<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeLanguage extends Model
{
    use HasFactory;

    protected $table = 'resume_languages';

    protected $fillable = [
        'resume_id',
        'language',
        'proficiency',
        'sort_order',
    ];

    protected $appends = ['points'];

    /** Valid spoken-language proficiency levels, ordered from lowest to highest. */
    public const PROFICIENCY_LEVELS = [
        'elementary',           // Basic words and phrases
        'limited_working',      // Can handle routine communication
        'professional_working', // Effective in most work situations
        'full_professional',    // Precise in demanding contexts
        'native_bilingual',     // Native or bilingual fluency
    ];

    /** Maps each proficiency level to a numeric score (1–5) for sorting/display. */
    private const PROFICIENCY_POINTS = [
        'elementary'           => 1,
        'limited_working'      => 2,
        'professional_working' => 3,
        'full_professional'    => 4,
        'native_bilingual'     => 5,
    ];

    public function getPointsAttribute(): int
    {
        return self::PROFICIENCY_POINTS[$this->proficiency];
    }

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
