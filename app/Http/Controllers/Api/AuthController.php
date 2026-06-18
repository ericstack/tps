<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Session-based login for the Vue SPA (Sanctum stateful).
     * Replaces legacy app/loginController.php.
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if (! $user || ! Auth::attempt($credentials)) {
            ActivityLog::create(['type' => 'Login', 'msg' => 'Invalid credentials for '.$credentials['username']]);
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (! $user->active) {
            throw ValidationException::withMessages([
                'username' => ['This account is inactive.'],
            ]);
        }

        $request->session()->regenerate();
        ActivityLog::create(['type' => 'Login', 'msg' => $user->username.' logged in']);

        return response()->json(['user' => $user]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['user' => $request->user()]);
    }

    /**
     * Self-service password change. When the account is flagged
     * must_change_password (a freshly provisioned login), the current
     * password is not required; otherwise it must be verified.
     */
    public function changePassword(Request $request): JsonResponse
    {
        $user = $request->user();
        $forced = (bool) $user->must_change_password;

        $request->validate([
            'current_password' => [$forced ? 'nullable' : 'required', 'string'],
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if (! $forced && ! Hash::check((string) $request->input('current_password'), $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        if (Hash::check($request->input('new_password'), $user->password)) {
            throw ValidationException::withMessages([
                'new_password' => ['The new password must differ from the current one.'],
            ]);
        }

        $user->forceFill([
            'password' => $request->input('new_password'),
            'must_change_password' => false,
        ])->save();

        ActivityLog::create(['type' => 'Account', 'msg' => $user->username.' changed their password']);

        return response()->json(['user' => $user->fresh()]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out.']);
    }
}
