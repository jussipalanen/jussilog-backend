<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete {--id=} {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a user by id or email.';

    public function handle(): int
    {
        $user = $this->resolveUser();

        if ($user === null) {
            return self::FAILURE;
        }

        if (! $this->confirm("Delete user {$user->id} ({$user->email})?")) {
            $this->info('Aborted.');

            return self::SUCCESS;
        }

        $user->delete();

        $this->info('User deleted.');

        return self::SUCCESS;
    }

    private function resolveUser(): ?User
    {
        $id    = $this->option('id');
        $email = $this->option('email');

        if (empty($id) && empty($email)) {
            $identifier = $this->ask('User id or email');
            $identifier = $this->normalizeBlank($identifier);

            if ($identifier === null) {
                $this->error('User id or email is required.');

                return null;
            }

            if (ctype_digit($identifier)) {
                $id = $identifier;
            } else {
                $email = $identifier;
            }
        }

        if (! empty($id)) {
            $user = User::query()->find($id);
        } else {
            $user = User::query()->where('email', $email)->first();
        }

        if ($user === null) {
            $this->error('User not found.');
        }

        return $user;
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
