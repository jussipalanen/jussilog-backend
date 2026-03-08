<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users.';

    public function handle(): int
    {
        $users = User::query()
            ->with('roles')
            ->orderBy('id')
            ->get();

        if ($users->isEmpty()) {
            $this->info('No users found.');

            return self::SUCCESS;
        }

        $rows = $users->map(function (User $user): array {
            $roles = $user->roles
                ->pluck('name')
                ->sort()
                ->implode(', ');

            return [
                'id' => $user->id,
                'name' => $user->name ?? '-',
                'username' => $user->username ?? '-',
                'email' => $user->email ?? '-',
                'roles' => $roles === '' ? '-' : $roles,
            ];
        })->all();

        $this->table(['ID', 'Name', 'Username', 'Email', 'Roles'], $rows);

        return self::SUCCESS;
    }
}
