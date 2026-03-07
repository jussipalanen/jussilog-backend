<?php

namespace App\Http\Controllers;

use App\Enums\Role as RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * List users.
     *
     * @group Users
     */
    public function index(): JsonResponse
    {
        $users = User::query()
            ->with('roles')
            ->select(['id', 'first_name', 'last_name', 'username', 'name', 'email'])
            ->get()
            ->map(function (User $user) {
                return [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'username' => $user->username,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->roles->pluck('name'),
                ];
            });

        return response()->json($users);
    }

    /**
     * Get a single user.
     *
     * @group Users
     */
    public function show(string $id): JsonResponse
    {
        $user = User::query()
            ->with('roles')
            ->find($id);

        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name'),
        ]);
    }

    /**
     * Get all available roles.
     *
     * @group Users
     */
    public function roles(): JsonResponse
    {
        $roles = Role::query()
            ->orderBy('name')
            ->get()
            ->map(function (Role $role) {
                $roleEnum = RoleEnum::tryFrom($role->name);

                return [
                    'id' => $role->id,
                    'key' => $role->name,
                    'label' => $roleEnum?->label() ?? $role->name,
                ];
            });

        return response()->json($roles);
    }

    /**
     * Delete a user.
     *
     * @group Users
     * @urlParam id integer required User ID. Example: 1
     */
    public function destroy(string $id): JsonResponse
    {
        $user = User::find($id);

        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
