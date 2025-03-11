<?php

namespace Modules\TariffsAndPromotions\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'string|max:255',
            'date_from' => 'date|after_or_equal:today',
            'date_to' => 'date|after_or_equal:date_from',
            'description' => 'string',
            'image' => 'nullable|image|max:10240',
            'is_active' => 'boolean',
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
