<?php

namespace Modules\UserManagement\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow access for all authenticated users
    }

    public function rules()
    {
        return [
            'old_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6'
        ];
    }

    public function messages()
    {
        return [
            'login.exists' => 'The provided login does not exist in our records.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
            'new_password.min' => 'The new password must be at least 6 characters long.'
        ];
    }
}
