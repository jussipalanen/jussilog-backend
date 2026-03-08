<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Role as RoleEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database with roles.
     */
    public function run(): void
    {
        $roles = array_map(
            static fn (RoleEnum $role) => ['name' => $role->value],
            RoleEnum::cases()
        );

        Role::query()->upsert($roles, ['name']);
    }
}
