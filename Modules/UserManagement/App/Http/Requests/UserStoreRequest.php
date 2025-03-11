<?php

namespace Modules\UserManagement\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|string',
            'login' => 'nullable|string|unique:new_users',
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|unique:new_users',
            'tg_id' => 'required|string|unique:new_users',
            'company_tin' => 'nullable|string|unique:new_users',
            'company_integration_id' => 'nullable|string|unique:new_users',
            'type' => 'nullable|string|max:50',
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
