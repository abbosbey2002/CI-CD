<?php

namespace Modules\ContentManagement\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    // public function authorize()
    // {
    //     return true;
    // }

    public function rules()
    {
        return [
            'title' => 'nullable|string|max:255',
            'file' => 'nullable|file|max:20480',
        ];
    }
}
