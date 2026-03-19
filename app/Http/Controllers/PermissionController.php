<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * List all permissions, grouped by resource.
     *
     * @group         Permissions
     *
     * @authenticated
     */
    public function index(): JsonResponse
    {
        $permissions = Permission::orderBy('group')->orderBy('name')->get();

        return response()->json($permissions->groupBy('group'));
    }

    /**
     * List permissions assigned to a role.
     *
     * @group         Permissions
     *
     * @authenticated
     */
    public function rolePermissions(int $roleId): JsonResponse
    {
        $role = Role::with('permissions')->findOrFail($roleId);

        return response()->json([
            'role'        => $role->name,
            'permissions' => $role->permissions->groupBy('group'),
        ]);
    }

    /**
     * Assign permissions to a role.
     *
     * @group         Permissions
     *
     * @authenticated
     */
    public function assign(Request $request, int $roleId): JsonResponse
    {
        $role = Role::findOrFail($roleId);

        $data = $request->validate([
            'permissions'   => 'required|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        $role->permissions()->syncWithoutDetaching($data['permissions']);

        $role->load('permissions');

        return response()->json([
            'role'        => $role->name,
            'permissions' => $role->permissions->groupBy('group'),
        ]);
    }

    /**
     * Revoke permissions from a role.
     *
     * @group         Permissions
     *
     * @authenticated
     */
    public function revoke(Request $request, int $roleId): JsonResponse
    {
        $role = Role::findOrFail($roleId);

        $data = $request->validate([
            'permissions'   => 'required|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        $role->permissions()->detach($data['permissions']);

        $role->load('permissions');

        return response()->json([
            'role'        => $role->name,
            'permissions' => $role->permissions->groupBy('group'),
        ]);
    }

    /**
     * Sync all permissions for a role (replaces existing).
     *
     * @group         Permissions
     *
     * @authenticated
     */
    public function sync(Request $request, int $roleId): JsonResponse
    {
        $role = Role::findOrFail($roleId);

        $data = $request->validate([
            'permissions'   => 'required|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        $role->permissions()->sync($data['permissions']);

        $role->load('permissions');

        return response()->json([
            'role'        => $role->name,
            'permissions' => $role->permissions->groupBy('group'),
        ]);
    }
}
