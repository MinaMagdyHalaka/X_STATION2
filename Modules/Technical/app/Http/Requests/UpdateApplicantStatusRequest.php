<?php

namespace Modules\Technical\app\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Technical\Enums\ApplicantEnum;

class UpdateApplicantStatusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => ValidationRuleHelper::foreignKeyRules(),
            'post_id' => ValidationRuleHelper::foreignKeyRules(),
            'status' => ValidationRuleHelper::enumRules([ApplicantEnum::ACCEPTED,ApplicantEnum::REJECTED])
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
