<?php

namespace Modules\Auth\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Modules\User\Enums\UserTypeEnum;

class RegisterRequest extends FormRequest
{
    use HttpResponse;
    public static bool $inUpdate;
    public function __construct()
    {
        parent::__construct();
        static::$inUpdate =! preg_match('/.*auth$/', $this->url());
    }
    public function rules()
    {
        $idValue = $this->route('id');

        return [
            'name' => ValidationRuleHelper::stringRules(),
            'email' => ValidationRuleHelper::emailRules([
                'unique' => ValidationRuleHelper::getUniqueColumn(static::$inUpdate, 'users', $idValue),
            ]),
            'password' => ValidationRuleHelper::defaultPasswordRules(['confirmed' => '']),
            'phone_number' => ValidationRuleHelper::phoneRules([
                'unique' => ValidationRuleHelper::getUniqueColumn(static::$inUpdate, 'users', $idValue,'phone_number'),
            ]),
            'address' => ValidationRuleHelper::addressRules(),
            'salary' => ValidationRuleHelper::integerRules(['required' => 'sometimes']),
            'avatar' => ValidationRuleHelper::storeOrUpdateImageRules(true),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
