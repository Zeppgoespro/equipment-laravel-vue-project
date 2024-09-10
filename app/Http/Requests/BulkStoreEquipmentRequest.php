<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkStoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'equipment'                     => 'required|array',
            'equipment.*.equipment_type_id' => 'required|exists:equipment_types,id',
            'equipment.*.serial_number'     => 'required|string|distinct|unique:equipment,serial_number,NULL,id,equipment_type_id,' . $this->input('equipment.*.equipment_type_id'),
            'equipment.*.desc'              => 'nullable|string',
        ];
    }
}
