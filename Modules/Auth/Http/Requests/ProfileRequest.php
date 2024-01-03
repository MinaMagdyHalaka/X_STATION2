<?php

namespace Modules\Auth\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Modules\User\Enums\UserTypeEnum;

class ProfileRequest extends FormRequest
{
    use HttpResponse;

    public function rules()
    {
        $inUpdate = $this->method() == 'POST';
        $idValue = Auth::user()->id;

        return [
            'name' => ValidationRuleHelper::stringRules(),
            'email' => ValidationRuleHelper::emailRules([
                'unique' => ValidationRuleHelper::getUniqueColumn($inUpdate, 'users', $idValue),
            ]),
            'avatar' => ValidationRuleHelper::storeOrUpdateImageRules($inUpdate),
            'salary' => ValidationRuleHelper::integerRules(['required' => 'sometimes']),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
