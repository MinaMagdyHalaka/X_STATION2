<?php

namespace Modules\Auth\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\ChangePasswordRequest;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Services\ChangePasswordService;
use Modules\Auth\Services\LoginService;

class ChangePasswordController extends Controller
{
    use HttpResponse;
    public function __construct(private readonly ChangePasswordService $changePasswordService)
    {
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $result = $this->changePasswordService->changePassword($request->validated());
        if ($result){
            return $this->okResponse($result, message: translate_success_message('password', 'changed'));
        }
        return $this->validationErrorsResponse(message: translate_error_message('old_password', 'wrong'));
    }

}
