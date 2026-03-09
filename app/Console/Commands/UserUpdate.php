<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Role as RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update {--id=} {--email=} {--name=} {--new-email=} {--password=} {--role=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update an existing user by id or email.';

    public function handle(): int
    {
        $user = $this->resolveUser();

        if ($user === null) {
            return self::FAILURE;
        }

        $name = $this->option('name');
        $newEmail = $this->resolveNewEmailOption();
        $password = $this->option('password');
        $roleValue = $this->resolveRoleValue($this->option('role'));

        if ($this->option('role') !== null && $roleValue === null) {
            return self::FAILURE;
        }

        $hasUpdateOptions = $this->option('name') !== null
            || $this->option('new-email') !== null
            || $this->option('password') !== null
            || $this->option('role') !== null;

        if ($this->input->isInteractive() && !$hasUpdateOptions) {
            $name = $name ?? $this->ask('New name (leave blank to keep)');
            $name = $this->normalizeBlank($name);

            if ($newEmail === null) {
                $newEmail = $this->ask('New email (leave blank to keep)');
                $newEmail = $this->normalizeBlank($newEmail);
            }

            if ($password === null) {
                $password = $this->secret('New password (leave blank to keep)');
                $password = $this->normalizeBlank($password);
            }

            if ($roleValue === null) {
                $roleValue = $this->promptRoleOrKeep();
            }
        }

        $updates = [];

        if (!empty($name)) {
            $updates['name'] = $name;
        }

        if (!empty($newEmail)) {
            if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                $this->error('Email format is invalid.');

                return self::FAILURE;
            }

            $exists = User::query()
                ->where('email', $newEmail)
                ->where('id', '!=', $user->id)
                ->exists();

            if ($exists) {
                $this->error('A user with that email already exists.');

                return self::FAILURE;
            }

            $updates['email'] = $newEmail;
        }

        if (!empty($password)) {
            $updates['password'] = Hash::make($password);
        }

        if ($updates !== []) {
            $user->update($updates);
        }

        if (!empty($roleValue)) {
            $roleModel = Role::query()->firstOrCreate(['name' => $roleValue]);
            $user->roles()->sync([$roleModel->id]);
        }

        $this->info("User updated (id: {$user->id}).");

        return self::SUCCESS;
    }

    private function resolveUser(): ?User
    {
        $id = $this->option('id');
        $email = $this->option('email');

        if (empty($id) && empty($email)) {
            $this->error('User id or email is required.');

            return null;
        }

        if (!empty($id)) {
            $user = User::query()->find($id);
        } else {
            $user = User::query()->where('email', $email)->first();
        }

        if ($user === null) {
            $this->error('User not found.');
        }

        return $user;
    }

    private function resolveNewEmailOption(): ?string
    {
        $id = $this->option('id');
        $email = $this->option('email');
        $newEmail = $this->option('new-email');

        if (!empty($id) && empty($newEmail) && !empty($email)) {
            return $email;
        }

        return $newEmail;
    }

    private function resolveRoleValue(?string $role): ?string
    {
        if ($role === null || $role === '') {
            return null;
        }

        $cases = RoleEnum::cases();
        $normalized = $this->normalizeRole($role, $cases);

        if ($normalized !== null) {
            return $normalized;
        }

        $this->error('Role must be one of: '.implode(', ', $this->roleKeys($cases)).'.');

        return null;
    }

    private function promptRoleOrKeep(): ?string
    {
        $cases = RoleEnum::cases();
        $choices = array_merge(['Keep current'], $this->roleLabels($cases));
        $choice = $this->choice('Role', $choices, 0);

        if ($choice === 'Keep current') {
            return null;
        }

        return $this->labelToValue($choice, $cases);
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

    private function normalizeBlank(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }
}
