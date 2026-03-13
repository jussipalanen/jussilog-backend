<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeCertification extends Model
{
    use HasFactory;

    protected $table = 'resume_certifications';

    protected $fillable = [
        'resume_id',
        'name',
        'issuing_organization',
        'issue_date',
        'sort_order',
    ];

    protected $casts = [
        'issue_date' => 'date',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
