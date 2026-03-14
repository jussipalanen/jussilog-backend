<?php

namespace App\Http\Controllers;

use App\Enums\Role as RoleEnum;
use App\Mail\GoogleWelcome;
use App\Mail\RegistrationWelcome;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @group Auth
     *
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
            'last_name'  => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:users,username',
            'email'      => 'required|string|email|max:255|unique:users,email',
            'password'   => 'required|string|min:8',
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'username'   => $data['username'],
            'name'       => trim($data['first_name'].' '.$data['last_name']),
            'email'      => $data['email'],
            'password'   => $data['password'],
        ]);

        $user->assignRole(RoleEnum::CUSTOMER);
        $user->load('roles');

        $lang = in_array($request->query('lang'), ['en', 'fi']) ? $request->query('lang') : 'en';

        Mail::to($user->email)->send(new RegistrationWelcome($user->email, $lang));

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => [
                'id'         => $user->id,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'username'   => $user->username,
                'name'       => $user->name,
                'email'      => $user->email,
                'roles'      => $user->roles->pluck('name'),
            ],
        ], 201);
    }

    /**
     * Login.
     *
     * @group Auth
     *
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

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * Login or register using Google ID token.
     *
     * @group Auth
     *
     * @bodyParam id_token string required Google ID token from frontend Google Sign-In flow.
     */
    public function googleLogin(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id_token' => 'required|string',
        ]);

        $googleProfile = $this->verifyGoogleIdToken($data['id_token']);
        if (! $googleProfile) {
            return response()->json(['message' => 'Invalid Google token'], 401);
        }

        if (! ($googleProfile['email_verified'] ?? false)) {
            return response()->json(['message' => 'Google email is not verified'], 422);
        }

        $email = $googleProfile['email'] ?? null;
        if (! $email) {
            return response()->json(['message' => 'Google account email is required'], 422);
        }

        $googleId = $googleProfile['sub'];

        $user = User::where('google_id', $googleId)->first();

        if (! $user) {
            $user = User::where('email', $email)->first();
        }

        $isNewUser = false;
        if (! $user) {
            $isNewUser = true;
            $name      = trim((string) ($googleProfile['name'] ?? ''));
            $username  = $this->generateUniqueUsername($email, $name);

            $user = User::create([
                'first_name' => (string) ($googleProfile['given_name'] ?? $name ?: 'Google'),
                'last_name'  => (string) ($googleProfile['family_name'] ?? ''),
                'name'       => $name ?: $username,
                'username'   => $username,
                'email'      => $email,
                'google_id'  => $googleId,
                'avatar'     => (string) ($googleProfile['picture'] ?? ''),
                // Keep password flow intact by storing a random hash for OAuth-created accounts.
                'password'          => Str::random(40),
                'email_verified_at' => now(),
            ]);
        } else {
            $updates = [];

            if (! $user->google_id) {
                $updates['google_id'] = $googleId;
            }

            if (empty($user->avatar) && ! empty($googleProfile['picture'])) {
                $updates['avatar'] = (string) $googleProfile['picture'];
            }

            if (! $user->email_verified_at) {
                $updates['email_verified_at'] = now();
            }

            if (! empty($updates)) {
                $user->fill($updates);
                $user->save();
            }
        }

        if ($isNewUser) {
            $user->assignRole(RoleEnum::CUSTOMER);
            $lang = in_array(strtolower((string) $request->input('lang', 'en')), ['en', 'fi'], true)
                ? strtolower((string) $request->input('lang', 'en'))
                : 'en';

            Mail::to($user->email)->queue(new GoogleWelcome($user, $lang));
        }

        $user->load('roles');
        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => [
                'id'         => $user->id,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'username'   => $user->username,
                'name'       => $user->name,
                'email'      => $user->email,
                'avatar'     => $user->avatar,
                'roles'      => $user->roles->pluck('name'),
            ],
        ]);
    }

    /**
     * Logout the authenticated user.
     *
     * @group Auth
     *
     * @authenticated
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->currentAccessToken();
        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }

        return response()->json(['message' => 'Logged out']);
    }

    /**
     * Check authentication status.
     *
     * @group Auth
     *
     * @authenticated
     */
    public function checkAuth(Request $request): JsonResponse
    {
        return response()->json([
            'authenticated' => true,
            'user'          => $request->user(),
        ]);
    }

    /**
     * Send reset password email.
     *
     * @group Auth
     *
     * @bodyParam email string required Email address. Example: jussi@example.com
     */
    public function lostPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink($data);

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)]);
        }

        return response()->json(['message' => __($status)], 422);
    }

    /**
     * Reset password with token.
     *
     * @group Auth
     *
     * @bodyParam email string required Email address. Example: jussi@example.com
     * @bodyParam token string required Reset token
     * @bodyParam password string required New password. Example: newpassword
     * @bodyParam password_confirmation string required Password confirmation. Example: newpassword
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'token'    => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset($data, function (User $user, string $password) {
            $user->forceFill([
                'password'       => $password,
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        });

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => __($status)]);
        }

        return response()->json(['message' => __($status)], 422);
    }

    /**
     * Verify Google ID token against Google's tokeninfo endpoint.
     *
     * @return array<string, mixed>|null
     */
    protected function verifyGoogleIdToken(string $idToken): ?array
    {
        $response = Http::asForm()->post('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $idToken,
        ]);

        if (! $response->ok()) {
            return null;
        }

        $payload = $response->json();
        if (! is_array($payload)) {
            return null;
        }

        $clientId = (string) config('services.google.client_id');
        if (! $clientId) {
            return null;
        }

        if (($payload['aud'] ?? null) !== $clientId) {
            return null;
        }

        if (empty($payload['sub'])) {
            return null;
        }

        return $payload;
    }

    protected function generateUniqueUsername(string $email, string $name = ''): string
    {
        $base = Str::of($email)->before('@')->slug('')->value();

        if ($base === '') {
            $base = Str::of($name)->slug('')->value();
        }

        if ($base === '') {
            $base = 'user';
        }

        $base      = Str::lower(substr($base, 0, 20));
        $candidate = $base;
        $counter   = 0;

        while (User::where('username', $candidate)->exists()) {
            $counter++;
            $suffix      = (string) $counter;
            $trimmedBase = substr($base, 0, max(1, 20 - strlen($suffix)));
            $candidate   = $trimmedBase.$suffix;
        }

        return $candidate;
    }
}
