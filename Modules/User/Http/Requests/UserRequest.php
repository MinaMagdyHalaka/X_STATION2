<?php

namespace Modules\User\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\User\Enums\UserTypeEnum;

class UserRequest extends FormRequest
{
    use HttpResponse;

    public function rules()
    {
        $inUpdate = !preg_match('/.*users$/', $this->url());
        $isRate = preg_match('/.*rate$/', $this->url());
        $idValue = $this->route('id');

        $rules = [
            'name' => ValidationRuleHelper::stringRules(),
            'email' => ValidationRuleHelper::emailRules([
                'unique' => $this->getUniqueColumn($inUpdate, $idValue, 'users', 'email', 'id')
            ]),
            'password' => ValidationRuleHelper::defaultPasswordRules(),
            'role_id' => ValidationRuleHelper::foreignKeyRules(),
            //'type' => ValidationRuleHelper::enumRules([UserTypeEnum::EMPLOYEE]),
            'avatar' => ValidationRuleHelper::storeOrUpdateImageRules($inUpdate)
        ];
        if ($inUpdate) {
            unset($rules['password']);
        }
        if ($isRate){
            $rules = [
                'user_id' => ValidationRuleHelper::foreignKeyRules(),
                'rate' => ValidationRuleHelper::floatRules(['max'=>'max:5'])
            ];
        }

        return $rules;
    }
    public function failedValidation(Validator $validator)
    {
        $this->throwValidationException($validator); // TODO: Change the autogenerated stub
    }

    public function getUniqueColumn($inUpdate, $idValue, $table, $column, $ignoredColumn)
    {
        $ignoredColumn = $inUpdate ? $ignoredColumn : null;
        return Rule::unique($table, $column)->ignore($idValue, $ignoredColumn);
    }
}