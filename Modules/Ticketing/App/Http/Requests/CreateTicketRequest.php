<?php

namespace Modules\Ticketing\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTicketRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'in:low,medium,high',
        ];
    }
}
