<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentType;
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
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    /*
    public function getPaginatedList($queryParams)
    {
        $query = Equipment::query();

        // Searching logic
        foreach ($queryParams as $key => $value) {
            if ($key === 'serial_number' && !empty($value)) {
                $query->where('serial_number', 'like', '%' . $value . '%');
            } elseif ($key === 'desc' && !empty($value)) {
                $query->orWhere('desc', 'like', '%' . $value . '%');
            } elseif ($key === 'q' && !empty($value)) {
                // Search across both serial_number and desc for partial matches
                $query->where(function ($subQuery) use ($value) {
                    $subQuery->where('serial_number', 'like', '%' . $value . '%')
                             ->orWhere('desc', 'like', '%' . $value . '%');
                });
            }
        }

        // Return plain data (collection)
        return $query->paginate(10);
    }
    */

    /**
     * Сохраняет новое оборудование.
     *
     * @param array $data Данные для создания оборудования.
     * @return array
     */
    public function store(array $data)
    {
        $result = ['errors' => [], 'success' => []];
        DB::beginTransaction();

        try {
            $equipmentType = EquipmentType::findOrFail($data['equipment_type_id']);

            if (!$this->validateSerialNumber($equipmentType->mask, $data['serial_number'])) {
                $result['errors'][] = 'Серийный номер не соответствует маске для данного типа оборудования.';
            } else {
                $equipment = Equipment::create($data);
                $result['success'][] = $equipment;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $result['errors'][] = ['message' => $e->getMessage()];
        }

        return $result;
    }

    /**
     * Массовое создание оборудования.
     *
     * @param array $equipments Массив данных оборудования.
     * @return array
     */
    public function storeBulk(array $equipments)
    {
        $result = ['errors' => [], 'success' => []];

        DB::beginTransaction();

        try {
            foreach ($equipments as $index => $item) {
                $equipmentType = EquipmentType::findOrFail($item['equipment_type_id']);

                if (!$this->validateSerialNumber($equipmentType->mask, $item['serial_number'])) {
                    $result['errors'][$index] = [
                        'message' => 'Серийный номер не соответствует маске для этого типа оборудования.'
                    ];
                    continue;
                }

                $equipment = Equipment::create($item);
                $result['success'][$index] = $equipment;
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            $result['errors'][] = ['message' => $e->getMessage()];
        }

        return $result;
    }

    /**
     * Возвращает информацию об оборудовании по ID.
     *
     * @param int $id ID оборудования.
     * @return Equipment
     */
    public function show($id)
    {
        return Equipment::findOrFail($id);
    }

    /**
     * Обновляет информацию об оборудовании.
     *
     * @param int $id ID оборудования.
     * @param array $data Данные для обновления.
     * @return Equipment
     */
    public function update($id, array $data)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update($data);
        return $equipment;
    }

    /**
     * Удаляет оборудование.
     *
     * @param int $id ID оборудования.
     * @return array
     */
    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
        return ['message' => 'Успешно удалено!'];
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
