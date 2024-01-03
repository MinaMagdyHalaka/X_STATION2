<?php

namespace Modules\Auth\Services;


class LogoutService
{
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return true;
    }
}
