<?php

namespace Modules\Technical\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Post\app\Resources\PostResource;
use Modules\Technical\app\Http\Requests\TechnicalRequest;
use Modules\Technical\app\Http\Requests\UpdateApplicantStatusRequest;
use Modules\Technical\app\Resources\TechnicalResource;
use Modules\Technical\Services\TechnicalService;
use Modules\User\Transformers\UserResource;

class TechnicalController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly TechnicalService $technicalService)
    {
    }

    public function index()
    {
        $result = $this->technicalService->index();

        return $this->resourceResponse(UserResource::collection($result));
    }

    public function store(TechnicalRequest $request)
    {
        $result = $this->technicalService->store($request->validated());
        if (isset($result['errors'])){
            return $this->validationErrorsResponse($result['errors']);
        }

        return $this->okResponse(message: translate_success_message('user','created'));
    }

    public function getCategoryTechnicals($categoryId): JsonResponse
    {
        $result = $this->technicalService->getCategoryTechnicals($categoryId);

        return $this->resourceResponse(TechnicalResource::collection($result));
    }

    public function applyForPost($postId): JsonResponse
    {
        $result = $this->technicalService->applyForPost($postId);
        if (isset($result['errors'])){
            return $this->validationErrorsResponse($result['errors']);
        }
        if (!$result){
            return $this->okResponse(message: translate_word('canceled'));
        }
        return $this->okResponse(message: translate_word('applied'));
    }

    public function getUserNotifications()
    {
        return $this->resourceResponse(Auth::user()->notifications);
    }

    public function updateApplicantStatus(UpdateApplicantStatusRequest $request){
        $result = $this->technicalService->updateApplicantStatus($request->validated());
        if ($result == 'not_your_post'){
            return $this->validationErrorsResponse(message: translate_word('not_your_post'));
        }
        if ($result == 'rejected'){
            return $this->okResponse(message: translate_word('rejected'));
        }
        if ($result == 'accepted'){
            return $this->okResponse(message: translate_word('applied'));
        }
        return $this->validationErrorsResponse($result);
    }

    public function allAccepted()
    {
        $acceptedPosts = $this->technicalService->allAccepted();

        return $this->resourceResponse(PostResource::collection($acceptedPosts));
    }
}
