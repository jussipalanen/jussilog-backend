<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeEducation extends Model
{
    use HasFactory;

    protected $table = 'resume_educations';

    protected $fillable = [
        'resume_id',
        'degree',
        'field_of_study',
        'institution_name',
        'location',
        'graduation_year',
        'gpa',
        'sort_order',
    ];

    protected $casts = [
        'graduation_year' => 'integer',
        'gpa'             => 'decimal:2',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
