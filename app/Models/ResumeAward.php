<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeAward extends Model
{
    use HasFactory;

    protected $table = 'resume_awards';

    protected $fillable = [
        'resume_id',
        'title',
        'issuer',
        'date',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
