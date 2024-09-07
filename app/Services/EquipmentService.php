<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Http\Resources\EquipmentResource;
use Illuminate\Support\Facades\DB;

/**
 * Сервис для работы с оборудованием.
 */
class EquipmentService
{
    /**
     * Получает постраничный список оборудования с возможностью поиска.
     *
     * @param array $queryParams Параметры запроса для поиска и фильтрации.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPaginatedList($queryParams)
    {
        $query = Equipment::query();

        // Поиск по серийному номеру или описанию
        foreach ($queryParams as $key => $value) {
            if ($key === 'serial_number' && !empty($value)) {
                $query->where('serial_number', 'like', '%' . $value . '%');
            } elseif ($key === 'desc' && !empty($value)) {
                $query->orWhere('desc', 'like', '%' . $value . '%');
            }
        }

        return EquipmentResource::collection($query->paginate(10));
    }

    /**
     * Сохраняет новое оборудование.
     *
     * @param array $data Данные для создания оборудования.
     * @return \Illuminate\Http\JsonResponse
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
                        'message' => 'Серийный номер не соответствует маске для данного типа оборудования.',
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

    /**
     * Возвращает информацию об оборудовании по ID.
     *
     * @param int $id ID оборудования.
     * @return EquipmentResource
     */
    public function show($id)
    {
        return new EquipmentResource(Equipment::findOrFail($id));
    }

    /**
     * Обновляет информацию об оборудовании.
     *
     * @param int $id ID оборудования.
     * @param array $data Данные для обновления.
     * @return EquipmentResource
     */
    public function update($id, array $data)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update($data);
        return new EquipmentResource($equipment);
    }

    /**
     * Удаляет оборудование.
     *
     * @param int $id ID оборудования.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
        return response()->json(['message' => 'Успешно удалено!']);
    }

    /**
     * Проверяет, соответствует ли серийный номер маске для типа оборудования.
     *
     * @param string $mask Маска серийного номера.
     * @param string $serialNumber Серийный номер для проверки.
     * @return bool
     */
    protected function validateSerialNumber($mask, $serialNumber)
    {
        // Обрезаем пробелы и проверяем правильность длины серийного номера
        $serialNumber = trim($serialNumber);

        // Генерируем регулярное выражение
        $pattern = '/^' . strtr($mask, [
            'N' => '\d',         // Цифра от 0 до 9
            'A' => '[A-Z]',      // Заглавная буква
            'a' => '[a-z]',      // Строчная буква
            'X' => '[A-Z0-9]',   // Заглавная буква или цифра
            'Z' => '[-_@]',      // Один из "-", "_", "@"
        ]) . '$/';

        // Логирование: серийный номер и его символы
        logger()->info("Валидация серийного номера", [
            'pattern' => $pattern,
            'serial_number' => $serialNumber,
            'mask' => $mask,
            'length' => strlen($serialNumber),
            'characters' => str_split($serialNumber)
        ]);

        $isValid = preg_match($pattern, $serialNumber);

        // Логирование результата валидации
        logger()->info("Результат валидации", ['isValid' => $isValid]);

        return $isValid;
    }
}
