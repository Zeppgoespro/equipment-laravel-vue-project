<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'serial_number'     => 'required|string|unique:equipment,serial_number,NULL,id,equipment_type_id,' . $this->equipment_type_id,
            'desc'              => 'nullable|string',
        ];
    }
}
