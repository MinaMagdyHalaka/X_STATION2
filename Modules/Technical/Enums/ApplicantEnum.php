<?php

namespace Modules\Technical\Enums;

enum ApplicantEnum
{
    const ACCEPTED = 'accepted';
    const PENDING = 'pending';
    const REJECTED = 'rejected';

    public static function applicantEnum(): array
    {
        return [
            self::ACCEPTED,
            self::PENDING,
            self::REJECTED,
        ];
    }
}
