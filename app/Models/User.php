<?php

namespace App\Models;

use App\Support\Roles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Unified authentication account. Consolidates the legacy `accounts`
 * (admin login) and `users` (operator) tables into one.
 *
 * Access is role-based — see config/roles.php for the role → module map.
 * Roles: admin, manager, deliveries, orders, warehouse, staff.
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'active',
        'assign',
        'employee_id',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Ship the resolved module list to the SPA so it can gate the UI without
    // duplicating the role → module map in JavaScript.
    protected $appends = ['modules'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'active' => 'boolean',
            'must_change_password' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function canAccessModule(string $module): bool
    {
        return Roles::canAccess($this->role, $module);
    }

    /** Resolved gated modules this account may access (for the SPA). */
    public function getModulesAttribute(): array
    {
        return Roles::modulesFor($this->role);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
