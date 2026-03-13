<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeRecommendation extends Model
{
    use HasFactory;

    protected $table = 'resume_recommendations';

    protected $fillable = [
        'resume_id',
        'full_name',
        'title',
        'company',
        'email',
        'phone',
        'recommendation',
        'sort_order',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
