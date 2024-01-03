<?php

namespace App\Helpers;

class GeneralHelper
{
    public static function getDefaultLoggedUserMiddlewares(string $permissions = null): array
    {

        $permissions = $permissions ? 'permission:'.$permissions : null;

        $middlewares = [
            'auth:sanctum',
        ];

        if ($permissions) {
            $middlewares[] = $permissions;
        }

        return $middlewares;
    }

    public static function userTypeIn(array $types)
    {
        return 'user_type_in:'.(implode('|', $types));
    }

    public static function authMiddleware()
    {
        return 'auth:sanctum';
    }
}
