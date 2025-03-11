<?php

namespace Modules\Ticketing\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function authorize()
    {
        return true; // or check user role if needed
    }

    public function rules()
    {
        return [
            'message' => 'required|string',
        ];
    }
}