<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeProject extends Model
{
    use HasFactory;

    protected $table = 'resume_projects';

    protected $fillable = [
        'resume_id',
        'name',
        'description',
        'technologies',
        'live_url',
        'github_url',
        'sort_order',
    ];

    protected $casts = [
        'technologies' => 'array',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
