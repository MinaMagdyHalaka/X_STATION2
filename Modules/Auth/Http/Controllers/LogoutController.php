<?php

namespace Modules\Auth\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Services\LoginService;
use Modules\Auth\Services\LogoutService;

class LogoutController extends Controller
{
    use HttpResponse;
    public function __construct(private readonly LogoutService $logoutService)
    {
    }

    public function logout(): JsonResponse
    {
        $result = $this->logoutService->logout();

        return $this->okResponse($result, message: translate_word('logged_out'));
    }

}
