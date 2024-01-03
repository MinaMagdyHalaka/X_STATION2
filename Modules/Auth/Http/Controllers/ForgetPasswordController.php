<?php

namespace Modules\Auth\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\ForgetPasswordRequest;
use Modules\Auth\Services\ForgetPasswordService;
use function Symfony\Component\Translation\t;

class ForgetPasswordController extends Controller
{
    use HttpResponse;
    public function __construct(private readonly ForgetPasswordService $forgetPasswordService)
    {
    }

    public function sendResetCode(): JsonResponse
    {
        $result = $this->forgetPasswordService->sendResetCode();
        if (!$result){
            return $this->validationErrorsResponse(message: translate_error_message('email', 'not_exists'));
        }
        return $this->okResponse(message: translate_word('reset_code_sent'));
    }

    public function resetPassword(ForgetPasswordRequest $request): JsonResponse
    {
        $result = $this->forgetPasswordService->resetPassword($request->validated());
        if ($result){
            return $this->okResponse(message: translate_word('password_reset_successfully'));
        }
        return $this->errorResponse(message: translate_word('expired_invalid_code'));
    }

}
