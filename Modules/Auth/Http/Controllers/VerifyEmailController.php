<?php

namespace Modules\Auth\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Services\VerifyEmailService;

class VerifyEmailController extends Controller
{
    use HttpResponse;
    public function __construct(private readonly VerifyEmailService $verifyEmailService)
    {
    }
    public function sendEmail(): JsonResponse
    {
        $this->verifyEmailService->sendEmail();

        return $this->okResponse(message: translate_word('reset_code_sent'));
    }

    public function verifyEmail(): JsonResponse
    {
        $result = $this->verifyEmailService->verifyEmail();
        if ($result){
            return $this->okResponse(message: translate_word('verified'));
        }
        return $this->errorResponse(message: translate_word('expired_invalid_code'));
    }
}
