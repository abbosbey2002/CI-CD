<?php

namespace Modules\UserManagement\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|string',
            'login' => 'required|string|unique:new_users',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|unique:new_users',
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
