<?php

namespace Modules\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Emails\SendCodeMail;
use Modules\Auth\Entities\PasswordResetToken;

class VerifyEmailService
{
    public function sendEmail()
    {
        $code = random_int(0000, 9999);
        PasswordResetToken::updateOrCreate(
            ['email' => Auth::user()->email],
            ['code' => Crypt::encryptString($code), 'expires_at' => now()->addHours(3)]
        );

        Mail::to(Auth::user()->email)->send(new SendCodeMail($code));

        return true;
    }

    public function verifyEmail(): bool
    {
        $verification = PasswordResetToken::where('email', request('email'))
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return false;
        }

        $storedCode = Crypt::decryptString($verification->code);
        if (!$verification || request('code') != $storedCode){
            return false;
        }

        $user = User::where('email', $verification->email)->first();

        $user->forceFill(['email_verified_at' => now()]);
        $user->save();

        $verification->delete();

        return true;
    }
}
