<?php

namespace Modules\Post\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\Post\app\Http\Requests\PostRequest;
use Modules\Post\app\Resources\PostResource;
use Modules\Post\Service\PostService;

class PostController extends Controller
{
    public static string $collectionName = 'post';
    use HttpResponse;
    public function __construct(private readonly PostService $postService)
    {
    }

    public function index()
    {
        $result = $this->postService->index();

        return $this->resourceResponse(PostResource::collection($result));
    }

    public function store(PostRequest $request)
    {
        $this->postService->store($request->validated());

        return $this->createdResponse(message: translate_success_message('post','created'));
    }

    public function show($id)
    {
        $result = $this->postService->show($id);

        return $this->resourceResponse(PostResource::make($result));
    }

}
