<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Http\Resources\EquipmentResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Получаем постраничный список оборудования с возможностью поиска.
 */
class EquipmentService
{
    public function getPaginatedList($queryParams)
    {
        $query = Equipment::query();

        // Поиск по серийному номеру или описанию
        foreach ($queryParams as $key => $value) {
            if (in_array($key, ['serial_number', 'desc'])) {
                $query->where($key, 'like', '%' . $value . '%');
            }
        }

        return EquipmentResource::collection($query->paginate(10));
    }

    /**
     * Сохраняем новое оборудование
     */
    public function store(array $data)
    {
        $result =['errors' => [], 'succes' => []];
        DB::beginTransaction();

        try {
            foreach ($data as $item) {
                // Валидируем серийный номер маской
                $equipmentType = EquipmentType::findOrFail($item['equipment_type_id']);
                if (!$this->ValidateSerialNumber($equipmentType->mask, $item['serial_number'])) {
                    $result['errors'][] = [
                        'index'     => array_search($item, $data),
                        'message'   => 'Серийный номер не соответствует маске для данного типа оборудования.',
                    ];
                    continue;
                }

                $equipment = Equipment::create($item);
                $result['success'][] = new EquipmentResource($equipment);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            $result['errors'][] = $e->getMessage();
        }

        return response()->json($result, empty($result['errors']) ? 200 : 400);
    }

    public function show($id)
    {
        return new EquipmentResource(Equipment::findOrFail($id));
    }

    public function update($id, array $data)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update($data);
        return new EquipmentResource($equipment);
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
        return response()->json(['message' => 'Успешно удалено!']);
    }

    protected function validateSerialNumber($mask, $serialNumber)
    {
        $pattern = '/^' . str_replace(
            ['N', 'A', 'a', 'X', 'Z'],
            ['\d', '[A-Z]', '[a-z]', '[A-Z0-9]', '[-_@]'],
            $mask
        ) . '$/';
        return preg_match($pattern, $serialNumber);
    }
}
