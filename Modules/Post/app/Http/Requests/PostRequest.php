<?php

namespace Modules\Post\app\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'title' => ValidationRuleHelper::stringRules(),
            'description' => ValidationRuleHelper::longTextRules(),
            'image' => ValidationRuleHelper::storeOrUpdateImageRules(true),
        ];
    }

    public function failedValidation(Validator $validator): bool
    {
        $this->throwValidationException($validator);
    }
}
