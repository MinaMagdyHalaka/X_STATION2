<?php

namespace Modules\User\Enums;

enum UserTypeEnum
{
    const ADMIN = 'admin';
    const CUSTOMER = 'customer';
    const TECHNICAL  = 'technical';

    public static function availableTypes(): array
    {
        return [
            self::ADMIN,
            self::CUSTOMER,
            self::TECHNICAL,
        ];
    }
}
