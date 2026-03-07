<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Role as RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {--name=} {--email=} {--password=} {--role=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user.';

    public function handle(): int
    {
        $name = $this->option('name') ?? $this->ask('Name');
        $email = $this->option('email') ?? $this->ask('Email');
        $password = $this->option('password') ?? $this->secret('Password');
        $roleValue = $this->resolveRoleValue($this->option('role'));

        if (empty($name) || empty($email) || empty($password) || empty($roleValue)) {
            $this->error('Name, email, password, and role are required.');

            return self::FAILURE;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email format is invalid.');

            return self::FAILURE;
        }

        if (User::query()->where('email', $email)->exists()) {
            $this->error('A user with that email already exists.');

            return self::FAILURE;
        }

        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $roleModel = Role::query()->firstOrCreate(['name' => $roleValue]);
        $user->roles()->sync([$roleModel->id]);

        $this->info("User created (id: {$user->id}).");

        return self::SUCCESS;
    }

    private function resolveRoleValue(?string $role): ?string
    {
        $cases = RoleEnum::cases();

        if ($role !== null && $role !== '') {
            $normalized = $this->normalizeRole($role, $cases);

            if ($normalized !== null) {
                return $normalized;
            }

                if (!$this->input->isInteractive()) {
                $this->error('Role must be one of: '.implode(', ', $this->roleKeys($cases)).'.');

                return null;
            }

            $this->warn('Invalid role. Choose a valid role.');
        }

        $label = $this->choice('Role', $this->roleLabels($cases), 2);

        return $this->labelToValue($label, $cases);
    }

    /**
     * @param array<int, RoleEnum> $cases
     */
    private function normalizeRole(string $role, array $cases): ?string
    {
        foreach ($cases as $case) {
            if (strcasecmp($role, $case->value) === 0 || strcasecmp($role, $case->label()) === 0) {
                return $case->value;
            }
        }

        return null;
    }

    /**
     * @param array<int, RoleEnum> $cases
     * @return array<int, string>
     */
    private function roleLabels(array $cases): array
    {
        return array_map(static fn (RoleEnum $case) => $case->label(), $cases);
    }

    /**
     * @param array<int, RoleEnum> $cases
     * @return array<int, string>
     */
    private function roleKeys(array $cases): array
    {
        return array_map(static fn (RoleEnum $case) => $case->value, $cases);
    }

    /**
     * @param array<int, RoleEnum> $cases
     */
    private function labelToValue(string $label, array $cases): string
    {
        foreach ($cases as $case) {
            if ($case->label() === $label) {
                return $case->value;
            }
        }

        return $label;
    }
}
