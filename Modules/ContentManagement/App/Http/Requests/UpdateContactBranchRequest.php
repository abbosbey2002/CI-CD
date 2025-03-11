<?php

namespace Modules\ContentManagement\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactBranchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'title' => 'string|max:255',
            'full_address' => 'nullable|string',
            'country' => 'string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'string|max:100',
            'street' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'use_full_address' => 'boolean',
            'use_phone_numbers' => 'boolean',
            'phone_number_1' => 'nullable|string|max:20',
            'phone_number_1_person' => 'nullable|string|max:50',
            'phone_number_2' => 'nullable|string|max:20',
            'phone_number_2_person' => 'nullable|string|max:50',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return true;
    // }
}
