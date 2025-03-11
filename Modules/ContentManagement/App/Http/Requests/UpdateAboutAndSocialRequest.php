<?php

namespace Modules\ContentManagement\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutAndSocialRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'about_description' => 'string|max:1000',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'telegram_link' => 'nullable|url',
            'telegram_bot_link' => 'nullable|url',
            'youtube_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'whatsapp_link' => 'nullable|url',
            'terms_title' => 'string|max:100',
            'terms_description' => 'string|max:250',
            'terms_file' => 'nullable|file|max:10240',
        ];
    }
}
