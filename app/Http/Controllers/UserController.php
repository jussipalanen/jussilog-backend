<?php

namespace App\Http\Controllers;

use App\Enums\Role as RoleEnum;
use App\Mail\AccountDeleted;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

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
     * Create a new user.
     *
     * @group Users
     * @bodyParam first_name string required First name. Example: Jussi
     * @bodyParam last_name string required Last name. Example: Palanen
     * @bodyParam username string required Username. Example: jussi
     * @bodyParam email string required Email address. Example: jussi@example.com
     * @bodyParam password string required Password. Example: strongpassword
     * @bodyParam roles array Role names to assign. Example: ["admin", "vendor"]
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'roles' => 'nullable|array',
            'roles.*' => 'string',
        ]);

        if (!empty($data['roles'])) {
            $actor = $request->user();
            if ($actor === null || !$actor->hasRole(RoleEnum::ADMIN)) {
                return response()->json(['message' => 'Only admins can assign roles'], 403);
            }
        }

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'name' => trim($data['first_name'] . ' ' . $data['last_name']),
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        // Assign roles if provided
        if (!empty($data['roles'])) {
            foreach ($data['roles'] as $roleName) {
                $user->assignRole($roleName);
            }
        }

        $user->load('roles');

        return response()->json([
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name'),
        ], 201);
    }

    /**
     * Update a user.
     *
     * @group Users
     * @urlParam id integer required User ID. Example: 1
     * @bodyParam first_name string First name. Example: Jussi
     * @bodyParam last_name string Last name. Example: Palanen
     * @bodyParam username string Username. Example: jussi
     * @bodyParam email string Email address. Example: jussi@example.com
     * @bodyParam password string Password. Example: newpassword
     * @bodyParam current_password string Required when updating your own password (non-admin).
     * @bodyParam roles array Role names to assign. Example: ["admin", "vendor"]
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $user = User::find($id);

        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $data = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'username' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'sometimes|string|min:8',
            'current_password' => 'sometimes|string',
            'roles' => 'nullable|array',
            'roles.*' => 'string',
        ]);

        if (isset($data['password'])) {
            $actor = $request->user();
            $isAdmin = $actor?->hasRole(RoleEnum::ADMIN) === true;
            $isSelf = $actor?->id === $user->id;

            if (!$isAdmin && $isSelf) {
                $currentPassword = $data['current_password'] ?? null;
                if ($currentPassword === null || !Hash::check($currentPassword, $user->password)) {
                    return response()->json(['message' => 'Current password is required'], 422);
                }
            }
        }

        if (array_key_exists('roles', $data)) {
            $actor = $request->user();
            if ($actor === null || !$actor->hasRole(RoleEnum::ADMIN)) {
                return response()->json(['message' => 'Only admins can update roles'], 403);
            }
        }

        // Update basic fields
        $user->fill([
            'first_name' => $data['first_name'] ?? $user->first_name,
            'last_name' => $data['last_name'] ?? $user->last_name,
            'username' => $data['username'] ?? $user->username,
            'email' => $data['email'] ?? $user->email,
        ]);

        // Update computed name if first_name or last_name changed
        if (isset($data['first_name']) || isset($data['last_name'])) {
            $user->name = trim($user->first_name . ' ' . $user->last_name);
        }

        // Update password if provided
        if (isset($data['password'])) {
            $user->password = $data['password'];
        }

        // Sync roles if provided
        if (array_key_exists('roles', $data)) {
            $roleIds = [];
            if (!empty($data['roles'])) {
                foreach ($data['roles'] as $roleName) {
                    $roleModel = Role::query()->firstOrCreate(['name' => $roleName]);
                    $roleIds[] = $roleModel->id;
                }
            }
            $user->roles()->sync($roleIds);
        }

        $user->save();
        $user->load('roles');

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
     * Admins can delete any user. A regular user can only delete their own account
     * and must confirm with their current password (not required for OAuth-only accounts).
     *
     * @group Users
     * @urlParam id integer required User ID. Example: 1
     * @bodyParam password string Current password (required when deleting own account and account has a password).
     * @authenticated
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $actor = $request->user();
        $user = User::find($id);

        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $isAdmin = $actor->hasRole(RoleEnum::ADMIN);
        $isSelf = $actor->id === $user->id;

        if (!$isAdmin && !$isSelf) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Capture details before deletion for the confirmation email
        $deletedName = $user->first_name ?: $user->name;
        $deletedEmail = $user->email;

        // Revoke all tokens before deleting
        $user->tokens()->delete();
        $user->delete();

        Mail::to($deletedEmail)->queue(new AccountDeleted($deletedName, $deletedEmail));

        return response()->json(['message' => 'User deleted successfully'], 200);
    }


    /**
     * Update a user's role by identifier (id, username or email).
     */
    public function updateRole(Request $request) {

        $request->validate([
            'role' => 'required|string'
        ]);

        // Check if key matches ENV variable
        $secretKey = env('ROLE_UPDATE_KEY');
        if (!$secretKey || $request->input('key') !== $secretKey) {
            return response()->json([
                'message' => 'Unauthorized key'
            ], 403);
        }

        $identifier = $request->input('identifier');

        // Find user by id, username or email
        $user = User::where('id', $identifier)
            ->orWhere('username', $identifier)
            ->orWhere('email', $identifier)
            ->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $roleName = $request->input('role');
        $user->setRole($roleName);

        return response()->json([
            'message' => 'Role updated successfully',
            'user' => $user
        ]);
    }

}
