<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * List all roles with their permissions.
     *
     * @group         Roles
     *
     * @authenticated
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Role::orderBy('name')->with('permissions')->get()
        );
    }

    /**
     * Create a role.
     *
     * @group         Roles
     *
     * @authenticated
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
        ]);

        $role = Role::create($data);

        return response()->json($role, 201);
    }

    /**
     * Update a role.
     *
     * @group         Roles
     *
     * @authenticated
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'admin') {
            return response()->json(['message' => 'The admin role cannot be renamed.'], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,'.$id,
        ]);

        $role->update($data);

        return response()->json($role);
    }

    /**
     * Delete a role.
     *
     * @group         Roles
     *
     * @authenticated
     */
    public function destroy(int $id): JsonResponse
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'admin') {
            return response()->json(['message' => 'The admin role cannot be deleted.'], 403);
        }

        $role->delete();

        return response()->json(null, 204);
    }
}
