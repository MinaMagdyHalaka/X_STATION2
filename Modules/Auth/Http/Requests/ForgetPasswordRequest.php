<?php

namespace Modules\Auth\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Enums\UserTypeEnum;

class ForgetPasswordRequest extends FormRequest
{
    use HttpResponse;

    public function rules()
    {
        return [
            'email' => ValidationRuleHelper::emailRules(['unique' => '']),
            'new_password' => ValidationRuleHelper::defaultPasswordRules(['confirmed' => '']),
            'confirm_password' => ValidationRuleHelper::defaultPasswordRules(['confirmed' => '', 'same' => 'same:new_password']),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
