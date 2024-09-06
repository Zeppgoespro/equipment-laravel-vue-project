<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Http\Resources\EquipmentResource;
use Illuminate\Support\Facades\DB;

/**
 * Получаем постраничный список оборудования с возможностью поиска
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
        $result = ['errors' => [], 'success' => []];
        DB::beginTransaction();

        try {
            if (isset($data['equipment_type_id'])) {
                $data = [$data];  // Превращаем в массив единичный экземпляр
            }

            foreach ($data as $item) {
                $equipmentType = EquipmentType::findOrFail($item['equipment_type_id']);
                if (!$this->validateSerialNumber($equipmentType->mask, $item['serial_number'])) {
                    $result['errors'][] = [
                        'index'   => array_search($item, $data),
                        'message' => 'The serial number does not match the mask for this type of equipment.',
                    ];
                    continue;
                }

                $equipment = Equipment::create($item);
                $result['success'][] = new EquipmentResource($equipment);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            $result['errors'][] = ['message' => $e->getMessage()];
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
        return response()->json(['message' => 'Successfully removed!']);
    }

    protected function validateSerialNumber($mask, $serialNumber)
    {
        // Делаем шаблон
        $pattern = '/^' . strtr($mask, [
            'N' => '\d',         // Цифра от 0 до 9
            'A' => '[A-Z]',      // Прописная буква
            'a' => '[a-z]',      // Строчная буква
            'X' => '[A-Z0-9]',   // Заглавная буква или цифра
            'Z' => '[-_@]',      // Символ из списка: "-", "_", "@"
        ]) . '$/';

        // Добавляем в лог сгенерированный шаблон и серийный номер для отладки
        logger()->info("Validating Serial Number", [
            'pattern' => $pattern,
            'serial_number' => $serialNumber,
            'mask' => $mask
        ]);

        $isValid = preg_match($pattern, $serialNumber);

        // Записываем результат проверки
        logger()->info("Validation Result", ['isValid' => $isValid]);

        return $isValid;
    }

}
