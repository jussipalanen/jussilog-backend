<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Enum representing the visibility state of a project.
 */
enum ProjectVisibility: string
{
    /** Project is publicly visible. */
    case SHOW = 'show';

    /** Project is hidden from public view. */
    case HIDE = 'hide';

    /**
     * Get the human-readable label for the visibility value.
     */
    public function label(): string
    {
        return match ($this) {
            self::SHOW => 'Show',
            self::HIDE => 'Hide',
        };
    }
}
