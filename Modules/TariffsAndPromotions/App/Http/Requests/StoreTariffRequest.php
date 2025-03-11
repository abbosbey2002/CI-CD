<?php

namespace Modules\TariffsAndPromotions\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTariffRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tariffs')->whereNull('deleted_at'),
            ],
            'description' => 'string|max:1000',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:10240',
            'feature_1' => 'nullable|string|max:100',
            'feature_2' => 'nullable|string|max:100',
            'feature_3' => 'nullable|string|max:100',
            'feature_4' => 'nullable|string|max:100',
            'feature_5' => 'nullable|string|max:100',
            'feature_6' => 'nullable|string|max:100',
            'feature_7' => 'nullable|string|max:100',
            'feature_8' => 'nullable|string|max:100',
            'feature_9' => 'nullable|string|max:100',
            'feature_10' => 'nullable|string|max:100',
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
