<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Resume;

class ResumeService
{
    /**
     * Retrieve the primary resume for the given user, with all relations loaded.
     */
    public function getPrimaryResume(int $userId): Resume
    {
        return Resume::with([
            'workExperiences',
            'educations',
            'skills',
            'projects',
            'certifications',
            'languages',
            'awards',
            'recommendations',
        ])
            ->where('user_id', $userId)
            ->where('is_primary', true)
            ->firstOrFail();
    }
}
