<?php

namespace Modules\auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordService
{
    public User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function changePassword(array $data)
    {
        $user = $this->userModel::whereId(Auth::user()->id)->first();
        if (! Hash::check($data['old_password'], $user->password)){
            return false;
        }
        $user->update([
            'password' => $data['new_password'],
        ]);

       return true;
    }
}
