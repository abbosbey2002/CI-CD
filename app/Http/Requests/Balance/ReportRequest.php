<?php

namespace App\Http\Requests\Balance;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
     /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'mimes:xls,xlsx,csv', // ✅ Разрешены только файлы .xls, .xlsx и .csv
                'max:10240', // ✅ Максимальный размер файла 10MB
            ],
        ];
    }

    public function messages()
    {
        return [
            'file.required' => '❌ Файл обязателен для загрузки!',
            'file.mimes' => '❌ Разрешены только файлы .xls, .xlsx и .csv!',
            'file.max' => '❌ Размер файла не должен превышать 10MB!',
        ];
    }


    /**
     * Проверяет, является ли файл в кодировке UTF-8
     */
    private function isUtf8($filePath)
    {
        $content = file_get_contents($filePath);
        return mb_check_encoding($content, 'UTF-8');
    }
}
