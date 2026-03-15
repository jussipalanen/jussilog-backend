<?php

declare(strict_types=1);

namespace App\Services;

class OrderStatusConfig
{
    public static function get(string $status): array
    {
        return self::all()[$status] ?? self::all()['pending'];
    }

    public static function all(): array
    {
        return [
            'pending'    => [
                'accent'       => '#f59e0b',
                'accent_dim'   => '#d97706',
                'bg'           => '#1c1304',
                'border'       => '#78350f',
                'header_bg'    => 'linear-gradient(135deg, #1c1304 0%, #292107 50%, #3d2c08 100%)',
                'icon'         => '⏳',
                'badge_bg'     => 'rgba(245,158,11,0.15)',
                'badge_border' => 'rgba(245,158,11,0.3)',
            ],
            'processing' => [
                'accent'       => '#818cf8',
                'accent_dim'   => '#6366f1',
                'bg'           => '#1e1b4b',
                'border'       => '#3730a3',
                'header_bg'    => 'linear-gradient(135deg, #0f0c2e 0%, #1e1047 50%, #3b1264 100%)',
                'icon'         => '⚡',
                'badge_bg'     => 'rgba(129,140,248,0.15)',
                'badge_border' => 'rgba(129,140,248,0.3)',
            ],
            'completed'  => [
                'accent'       => '#34d399',
                'accent_dim'   => '#10b981',
                'bg'           => '#022c22',
                'border'       => '#065f46',
                'header_bg'    => 'linear-gradient(135deg, #022c22 0%, #064e3b 50%, #065f46 100%)',
                'icon'         => '✅',
                'badge_bg'     => 'rgba(52,211,153,0.15)',
                'badge_border' => 'rgba(52,211,153,0.3)',
            ],
            'cancelled'  => [
                'accent'       => '#f87171',
                'accent_dim'   => '#ef4444',
                'bg'           => '#1c0606',
                'border'       => '#7f1d1d',
                'header_bg'    => 'linear-gradient(135deg, #1c0606 0%, #2d0808 50%, #450a0a 100%)',
                'icon'         => '❌',
                'badge_bg'     => 'rgba(248,113,113,0.15)',
                'badge_border' => 'rgba(248,113,113,0.3)',
            ],
            'refunded'   => [
                'accent'       => '#fb923c',
                'accent_dim'   => '#f97316',
                'bg'           => '#1c0a04',
                'border'       => '#7c2d12',
                'header_bg'    => 'linear-gradient(135deg, #1c0a04 0%, #2c1005 50%, #431407 100%)',
                'icon'         => '💸',
                'badge_bg'     => 'rgba(251,146,60,0.15)',
                'badge_border' => 'rgba(251,146,60,0.3)',
            ],
        ];
    }
}
