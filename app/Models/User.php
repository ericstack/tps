<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Unified authentication account. Consolidates the legacy `accounts`
 * (admin login) and `users` (operator) tables into one.
 *
 * access: 1 = admin, 2 = standard user (matches legacy convention).
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'access',
        'active',
        'assign',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'access' => 'integer',
            'active' => 'boolean',
        ];
    }
}
