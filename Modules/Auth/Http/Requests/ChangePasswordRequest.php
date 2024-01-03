<?php

namespace Modules\Auth\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    use HttpResponse;

    public function rules()
    {
        return [
            'old_password' => 'required',
            'new_password' => ValidationRuleHelper::defaultPasswordRules(['confirmed' => '','different' => 'different:old_password']),
            'confirm_password' => ValidationRuleHelper::defaultPasswordRules(['confirmed' => '', 'same' => 'same:new_password']),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }

    public function messages()
    {
        return [
            'new_password.different' => 'new password must be different'
        ];
    }
}
