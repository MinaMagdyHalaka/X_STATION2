<?php

namespace Modules\Auth\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Transformers\UserResource;

class ProfileService
{
    public User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function show()
    {
        $user = $this->userModel::whereId(Auth::user()->id)->with('avatar')->first();

        return UserResource::make($user);
    }

    public function update(array $data): bool
    {
        $user = $this->show();
        $user->update($data);
        $user->registerMediaCollections();
        $user->addMediaFromRequest('avatar')->toMediaCollection(UserController::$collectionName);

        return true;
    }
}
