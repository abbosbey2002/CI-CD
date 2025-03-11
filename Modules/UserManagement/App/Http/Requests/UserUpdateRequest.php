<?php

namespace Modules\UserManagement\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'nullable|string',
            'login' => 'nullable|string|unique:new_users',
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|unique:new_users',
            'tg_id' => 'nullable|string|unique:new_users',
            'company_tin' => 'nullable|string|unique:new_users',
            'company_integration_id' => 'nullable|string|unique:new_users',
            'type' => 'nullable|string|max:50',
            'full_address' => [
                'nullable', 'string',
                function ($attribute, $value, $fail) {
                    if ($this->input('use_full_address') === true && empty($value)) {
                        $fail('The full address field is required when use_full_address is true.');
                    }
                },
            ],

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
