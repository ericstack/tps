<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Support\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        return User::query()->latest()->paginate(25);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'password' => ['required', Password::defaults()],
            'role' => ['required', Rule::in(Roles::names())],
            'active' => ['boolean'],
            'assign' => ['nullable', 'string', 'max:255'],
            'employee_id' => ['nullable', 'integer', 'unique:users,employee_id', 'exists:employees,id'],
            'must_change_password' => ['boolean'],
        ]);

        return response()->json(User::create($data), 201);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username,'.$user->id],
            'password' => ['nullable', Password::defaults()],
            'role' => ['required', Rule::in(Roles::names())],
            'active' => ['boolean'],
            'assign' => ['nullable', 'string', 'max:255'],
            'employee_id' => ['nullable', 'integer', Rule::unique('users', 'employee_id')->ignore($user->id), 'exists:employees,id'],
            'must_change_password' => ['boolean'],
        ]);

        // Don't let the last active admin demote or deactivate themselves out of access.
        $losesAdmin = $user->isAdmin() && ($data['role'] !== 'admin' || ($request->has('active') && ! $data['active']));
        if ($losesAdmin && $this->activeAdminCount() <= 1) {
            throw ValidationException::withMessages([
                'role' => ['Cannot remove the last active administrator.'],
            ]);
        }

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return $user;
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin() && $this->activeAdminCount() <= 1) {
            throw ValidationException::withMessages([
                'user' => ['Cannot delete the last active administrator.'],
            ]);
        }

        $user->delete();

        return response()->noContent();
    }

    /**
     * Provision a login account for an employee: username defaults to the
     * employee_code, a temp password is generated, and the account is flagged
     * to force a password change on first login. The plaintext temp password
     * is returned ONCE here and never exposed again.
     */
    public function provision(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'integer', 'exists:employees,id', 'unique:users,employee_id'],
            'role' => ['required', Rule::in(Roles::names())],
        ]);

        $employee = Employee::findOrFail($data['employee_id']);

        if (User::where('username', $employee->employee_code)->exists()) {
            throw ValidationException::withMessages([
                'employee_id' => ["A user with username {$employee->employee_code} already exists."],
            ]);
        }

        $tempPassword = Str::password(12);

        $user = User::create([
            'name' => $employee->employee_name,
            'username' => $employee->employee_code,
            'password' => $tempPassword,
            'role' => $data['role'],
            'active' => true,
            'employee_id' => $employee->id,
            'must_change_password' => true,
        ]);

        return response()->json([
            'user' => $user,
            'temp_password' => $tempPassword,
        ], 201);
    }

    private function activeAdminCount(): int
    {
        return User::where('role', 'admin')->where('active', true)->count();
    }
}
