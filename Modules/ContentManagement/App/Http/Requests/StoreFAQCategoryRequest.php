<?php

namespace Modules\ContentManagement\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFAQCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|unique:faq_categories,title|string|max:50',
            'description' => 'nullable|string|max:250',
            'image' => 'nullable|image|max:10240',
            'parent_category_id' => 'nullable|exists:faq_categories,id',
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
