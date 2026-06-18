<?php

namespace App\Support;

use Illuminate\Support\Facades\Config;

// Thin accessor over config/roles.php so the role/module map is read in one
// place. Used by the User model, the module middleware, and validation.
class Roles
{
    /** All valid role names (for validation / select options). */
    public static function names(): array
    {
        return array_keys(Config::get('roles.roles', []));
    }

    /** The list of access-gated module keys. */
    public static function gated(): array
    {
        return Config::get('roles.gated', []);
    }

    /** Resolved module list for a role ('*' expands to every gated module). */
    public static function modulesFor(?string $role): array
    {
        $modules = Config::get("roles.roles.$role");

        if ($modules === null) {
            return [];
        }

        return in_array('*', $modules, true) ? self::gated() : $modules;
    }

    /** Whether a role grants access to a given module. */
    public static function canAccess(?string $role, string $module): bool
    {
        return in_array($module, self::modulesFor($role), true);
    }
}
