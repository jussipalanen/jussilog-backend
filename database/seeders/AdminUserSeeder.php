<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Role as RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'juzapala+superadmin@gmail.com'],
            [
                'name'              => 'superadmin',
                'username'          => 'superadmin',
                'first_name'        => 'Super',
                'last_name'         => 'Admin',
                'password'          => Str::password(16),
                'email_verified_at' => now(),
            ]
        );

        $user->setRole(RoleEnum::ADMIN);
    }
}
