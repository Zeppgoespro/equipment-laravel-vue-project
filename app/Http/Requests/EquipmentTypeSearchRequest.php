<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentTypeSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => 'nullable|string',  // Убеждаемся, что "name" - это строка
            'mask'  => 'nullable|string',  // Убеждаемся, что "mask" - это строка
            'q'     => 'nullable|string',  // Убеждаемся, что "q" - это строка
        ];
    }
}
