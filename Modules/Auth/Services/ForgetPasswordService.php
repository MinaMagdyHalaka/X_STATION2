<?php

namespace Modules\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Emails\SendCodeMail;
use Modules\Auth\Entities\PasswordResetToken;

class ForgetPasswordService
{
    public function sendResetCode(): bool
    {
        $user = User::where('email', request()->validate(['email' => 'required|email:rfc,dns']))->first();
        if (!$user){
            return false;
        }
        $code = random_int(0000, 9999);
        PasswordResetToken::updateOrCreate(
            ['email' => $user->email],
            ['code' => Crypt::encryptString($code), 'expires_at' => now()->addHours()]
        );

        Mail::to($user->email)->send(new SendCodeMail($code));

        return true;
    }

    public function resetPassword(array $data): bool
    {
        $passwordReset = PasswordResetToken::where('email', $data['email'])
            ->where('expires_at', '>', now())
            ->first();

        $storedCode = Crypt::decryptString($passwordReset->code);
        if (!$passwordReset || request('code') != $storedCode){
            return false;
        }

        $user = User::where('email', $passwordReset->email)->first();

        $user->update(['password' => $data['new_password']]);

        $passwordReset->delete();

        return true;
    }
}
