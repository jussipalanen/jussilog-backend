<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationWelcome;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @group Auth
     * @bodyParam first_name string required First name. Example: Jussi
     * @bodyParam last_name string required Last name. Example: Palanen
     * @bodyParam username string required Username. Example: jussi
     * @bodyParam email string required Email address. Example: jussi@example.com
     * @bodyParam password string required Password. Example: strongpassword
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'name' => trim($data['first_name'] . ' ' . $data['last_name']),
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        Mail::to($user->email)->send(new RegistrationWelcome(
            $user->email,
            $data['password'],
            'Welcome to Jussimatic',
        ));

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    /**
     * Login.
     *
     * @group Auth
     * @bodyParam username string required Username or email. Example: jussi
     * @bodyParam password string required Password. Example: strongpassword
     */
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = filter_var($data['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($loginField, $data['username'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Logout the authenticated user.
     *
     * @group Auth
     * @authenticated
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->currentAccessToken();
        if ($token) {
            $token->delete();
        }

        return response()->json(['message' => 'Logged out']);
    }

    /**
     * Check authentication status.
     *
     * @group Auth
     * @authenticated
     */
    public function checkAuth(Request $request): JsonResponse
    {
        return response()->json([
            'authenticated' => true,
            'user' => $request->user(),
        ]);
    }
}
