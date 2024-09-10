<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'serial_number' => 'nullable|string',  // Убеждаемся, что "serial_number" - это строка
            'desc'          => 'nullable|string',  // Убеждаемся, что "desc" - это строка
            'q'             => 'nullable|string',  // Убеждаемся, что "q" - это строка
        ];
    }
}
