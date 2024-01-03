<?php

namespace Modules\Auth\Services;

use App\Models\User;
use Modules\User\Enums\UserTypeEnum;
use Modules\User\Http\Controllers\UserController;

class RegisterService
{
    public User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function register(array $data)
    {
        $user = $this->userModel::create($data + ['type' => UserTypeEnum::CUSTOMER]);
        if (isset($data['avatar'])){
            $user->addMediaFromRequest('avatar')->toMediaCollection(UserController::$collectionName);
        }

        return true;
    }
}
