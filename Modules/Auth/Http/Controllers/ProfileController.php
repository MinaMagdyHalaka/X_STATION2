<?php

namespace Modules\Auth\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\ProfileRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Services\ProfileService;
use Modules\Auth\Services\RegisterService;
use Modules\User\Http\Requests\UserRequest;

class ProfileController extends Controller
{
    use HttpResponse;
    public function __construct(private readonly ProfileService $profileService)
    {
    }

    public function show(): JsonResponse
    {
        $result = $this->profileService->show();

        return $this->resourceResponse($result);
    }

    public function update(ProfileRequest $request): JsonResponse
    {
        $this->profileService->update($request->validated());

        return $this->okResponse(message: translate_success_message('profile', 'updated'));
    }

}
