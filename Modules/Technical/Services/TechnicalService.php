<?php

namespace Modules\Technical\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Category\Service\categoryService;
use Modules\Post\app\Models\Post;
use Modules\Post\Service\PostService;
use Modules\Technical\app\Models\Application;
use Modules\Technical\app\Models\Technical;
use Modules\Technical\app\Notifications\ApplyNotification;
use Modules\Technical\Enums\ApplicantEnum;
use Modules\User\Enums\UserTypeEnum;

class TechnicalService
{
    public Technical $technicalModel;
    public User $userModel;
    public Application $applicationModel;
    public Post $postModel;
    public function __construct()
    {
        $this->technicalModel = new Technical();
        $this->userModel = new User();
        $this->applicationModel = new Application();
        $this->postModel = new Post();
    }

    public function index()
    {
        return $this->userModel::where('type','technical')->searchable(['name','email','phone_number'])->get();
    }
    public function store($data)
    {
        $errors = [];

        (new categoryService())->categoryExists($data['category_id'], $errors);
        if ($errors){
            return ['errors' => $errors];
        }

        DB::transaction(function () use ($data){
            $user = $this->userModel::create($data + ['type' => UserTypeEnum::TECHNICAL]);
            $technical = $this->technicalModel;
            $technical->forceFill([
                'user_id' => $user->id,
                'category_id' => $data['category_id'],
                'national_id' => $data['national_id'],
                'experience_years' => $data['experience_years'],
            ]);
            $technical->save();
        });

        return true;
    }

    public function getCategoryTechnicals($categoryId)
    {
        return $this->technicalModel::where('category_id', $categoryId)->with(['user','user.favorite' => function ($query){
        $query->where('user_id', auth()->id());
    }])->get();
    }

    public function applyForPost($postId): array|bool
    {
        $errors = [];
        $technical = $this->technicalModel::where('user_id', Auth::user()->id)->first();
        $post = (new PostService())->postExists($postId, $errors);
        if ($errors){
            return ['errors' => $errors];
        }
        $applied = $technical->posts()->where('post_id' , $postId)->exists();

        if ($applied){
            $technical->posts()->detach();
            return false;
        }
        $technical->posts()->attach(['post_id' => $postId], ['status' => ApplicantEnum::PENDING]);

        $post->user->notify(new ApplyNotification([
            'message' => Auth::user()->name.''.'Applied To Your Post',
            'notificationType' => 'applyPost',
            'modelId' => (int)$postId,
        ]));

        return true;

    }

    public function updateApplicantStatus(array $data)
    {
        $errors = [];
        $technical = $this->technicalModel::where('user_id', $data['user_id'])->first();
        if (!$technical){
            $errors['user_id'] = translate_error_message('technical','not_exists');
            return $errors;
        }
        $post = $this->postModel::where([
            'id' => $data['post_id'],
            'user_id' => auth()->id(),
        ])->first();

        if (!$post){
            $errors['post_id'] = translate_error_message('post','not_yours');
            return $errors;
        }
        $applicant = $technical->posts()->where('post_id',$post->id)->exists();

        if (!$applicant){
            return 'not_your_post';
        }

        if ($data['status'] == ApplicantEnum::REJECTED){
            $technical->posts()->detach($post->id);
            return 'rejected';
        }
        if ($data['status'] == ApplicantEnum::ACCEPTED) {
            $technical->posts()->updateExistingPivot($post->id, ['status' => $data['status']]);
            $technical->user->notify(new ApplyNotification([
                'message' => auth()->user()->name.' '.'Has Chosen You To Do His Job',
                'notificationType' => 'applyTechnical',
                'modelId' => $post->id,
            ]));
            return 'accepted';
        }
        die();
    }

    public function allAccepted()
    {
        $technical = $this->technicalModel::where('user_id' , auth()->id())->first();

        return $technical->posts()->where('status',ApplicantEnum::ACCEPTED)->get();
    }

}
