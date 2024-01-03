<?php

namespace Modules\Auth\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Services\RegisterService;

class RegisterController extends Controller
{
    use HttpResponse;
    public function __construct(private readonly RegisterService $registerService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $this->registerService->register($request->validated());

        return $this->okResponse(message: translate_success_message('user', 'created'));
    }

}
