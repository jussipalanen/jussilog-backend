<?php

namespace App\Http\Controllers;

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
            ->select(['id', 'first_name', 'last_name', 'username', 'email'])
            ->get();

        return response()->json($users);
    }
}
