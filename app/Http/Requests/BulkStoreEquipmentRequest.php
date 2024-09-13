<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Не используется, см. EquipmentService
 */
class BulkStoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'equipment' => 'required|array',  // Проверяем, что 'equipment' является массивом
            'equipment.*.equipment_type_id' => 'required|exists:equipment_types,id',  // Валидация каждого 'equipment_type_id' в массиве 'equipment'
            'equipment.*.serial_number' => [
                'required',
                'string',
                'distinct',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];  // Извлекаем индекс из 'equipment.*.serial_number'
                    $equipmentTypeId = $this->input("equipment.$index.equipment_type_id");
                    if ($equipmentTypeId && \App\Models\Equipment::where('serial_number', $value)->where('equipment_type_id', $equipmentTypeId)->exists()) {
                        $fail('Серийный номер уже существует для данного типа оборудования.');
                    }
                }
            ],
            'equipment.*.desc' => 'nullable|string',  // Необязательное поле 'desc' как строка
        ];
    }
}
