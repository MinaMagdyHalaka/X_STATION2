<?php

namespace Modules\User\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Services\UserService;
use Modules\User\Transformers\UserResource;

class UserController extends Controller
{

    use HttpResponse;
    public UserService $userService;
    public static string $collectionName = 'avatar';

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $result = $this->userService->index();

        return $this->resourceResponse(UserResource::collection($result), translate_word('success'));

    }

    public function store(UserRequest $request): JsonResponse
    {
        $result = $this->userService->store($request->validated());

        if (is_bool($result)) {
            return $this->createdResponse(message: translate_success_message('user', 'created'));
        }

        return $this->validationErrorsResponse($result);
    }

    public function show($id): JsonResponse
    {
        $result = $this->userService->show($id);

        return $this->resourceResponse(new UserResource($result));
    }

    public function update(UserRequest $request, $id): JsonResponse
    {
        $this->userService->update($request->validated(), $id);

        return $this->okResponse(message: translate_success_message('user', 'updated'));
    }

    public function destroy($id): JsonResponse
    {
        $this->userService->destroy($id);

        return $this->okResponse(translate_success_message('user', 'deleted'));
    }

    public function rating(UserRequest $request)
    {
        $this->userService->rating($request->validated());
        return $this->okResponse(message: translate_word('rated'));
    }

    public function favorites($userId)
    {
        $result = $this->userService->favorites($userId);
        if ($result){
            return $this->okResponse(message: translate_word('added'));
        }
        return $this->okResponse(message: translate_word('removed'));
    }

    public function showAllFavorites()
    {
        $result = $this->userService->showAllFavorites();
        return $this->resourceResponse($result);
    }

}
