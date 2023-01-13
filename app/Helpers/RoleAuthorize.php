<?php

namespace App\Helpers;

use App\Models\Constants\UserConstants;

class RoleAuthorize
{

    /**
     * Check if current logged user is admin
     *
     * Return TRUE if current logged user having admin role
     * and FALSE on otherwise
     *
     * @return bool
     */
    public static function isAdmin()
    {
        $user = auth()->user();
        return (
            in_array($user->role, UserConstants::getRoles()) &&
            $user->role === UserConstants::ROLE_ADMIN
        );
    }
}
