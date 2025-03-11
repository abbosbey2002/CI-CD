<?php

namespace Modules\ContentManagement\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactBranchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {

        $useFullAddress = filter_var($this->input('use_full_address'), FILTER_VALIDATE_BOOLEAN);
        $usePhoneNumbers = filter_var($this->input('use_phone_numbers'), FILTER_VALIDATE_BOOLEAN);

        $rules = [
            'title' => 'required|string|max:255',

            // Boolean flags – these should be provided (or can be cast to boolean)
            'use_full_address' => 'nullable|boolean',
            'use_phone_numbers' => 'nullable|boolean',

            // Full address required if use_full_address is true
            'full_address' => Rule::requiredIf(function () {
                $ufa = $this->input('use_full_address');

                // Accept both boolean true or "1" string as true
                return $ufa === true || $ufa === '1';
            }),

            // If not using full address, these fields are required (adjust as needed)
            'country' => 'required_if:use_full_address,false|string|max:100',
            'state' => 'required_if:use_full_address,false|string|max:100',
            'city' => 'required_if:use_full_address,false|string|max:100',
            'street' => 'required_if:use_full_address,false|string|max:255',

            'comment' => 'nullable|string',
        ];

        if ($useFullAddress) {
            $rules['phone_number_1'] = 'nullable|string|max:50';
            $rules['phone_number_2'] = 'nullable|string|max:50';
            $rules['phone_number_1_person'] = 'prohibited';
            $rules['phone_number_2_person'] = 'prohibited';
        } else {
            // ✅ Agar `use_full_address = false` bo‘lsa, telefon raqamlari kerak bo‘ladi
            if ($usePhoneNumbers) {
                $rules['phone_number_1'] = 'prohibited';
                $rules['phone_number_2'] = 'prohibited';
                $rules['phone_number_1_person'] = 'required|string|max:50';
                $rules['phone_number_2_person'] = 'nullable|string|max:50';
            } else {
                $rules['phone_number_1'] = 'required|string|max:50';
                $rules['phone_number_2'] = 'nullable|string|max:50';
                $rules['phone_number_1_person'] = 'prohibited';
                $rules['phone_number_2_person'] = 'prohibited';
            }
        }


        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return true;
    // }
}
