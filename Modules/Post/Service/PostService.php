<?php

namespace Modules\Post\Service;

use Illuminate\Support\Facades\Auth;
use Modules\Post\app\Http\Controllers\PostController;
use Modules\Post\app\Models\Post;
use Modules\User\Enums\UserTypeEnum;

class PostService
{
    public Post $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function index()
    {
        $user = Auth::user();

        $posts = $this->postModel::with(['image', 'user:id,name', 'accepted'])->get();
        if ($user->type == UserTypeEnum::TECHNICAL){
            $technicalId = $user->technical->id;
            $posts->load(['technicals' => function ($query) use ($technicalId){
                $query->wherePivot('technical_id', $technicalId);
            }]);
        }
        return $posts;
    }

    public function store($data)
    {
        $post = $this->postModel::create(['user_id' => Auth::user()->id] + $data);
        if (isset($data['image'])){
            $post->registerMediaCollections();
            $post->addMediaFromRequest('image')->toMediaCollection(PostController::$collectionName);
        }

        return true;
    }

    public function show($id)
    {
        return $this->postModel::whereId($id)->with([
            'image', 'user','technicals:user_id','technicals.user','accepted'])->firstOrFail();
    }

    public function postExists($postId, &$errors, $errorKey = 'post_id')
    {
        $post = $this->postModel::whereId($postId)->first();
        if (!$post){
            $errors[$errorKey] = translate_error_message('post', 'not_exists');
        }
        return $post;
    }
}
