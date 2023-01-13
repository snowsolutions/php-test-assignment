<?php

namespace App\Models\Constants;

class UserConstants {

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    public static function getRoles()
    {
        return [self::ROLE_USER, self::ROLE_ADMIN];
    }
}
