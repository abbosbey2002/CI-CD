<?php

namespace Modules\UserManagement\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'nullable|string',
            'login' => 'required|string|unique:new_users,login,'.$this->id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|unique:new_users,phone,'.$this->id,
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
