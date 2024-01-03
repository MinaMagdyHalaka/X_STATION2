<?php

namespace Modules\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\u;

class LoginService
{
    public User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function login(array $data)
    {
        if (! Auth::attempt($data)){
            return 'wrong_credentials';
        }

        $user = User::where(['email'=> $data['email']])->with('avatar')->first();
        if(!$user->email_verified_at){
            return 'not_verified';
        }
        $token = $user->createToken("API TOKEN")->plainTextToken;
        $user->token = $token;

        return $user;
    }
}
