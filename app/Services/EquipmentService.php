<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\EquipmentResource;

/**
 * Сервис для работы с оборудованием.
 */
class EquipmentService
{
    /**
     * Получает постраничный список оборудования с возможностью поиска - Сейчас не используется
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

        foreach ($equipments as $index => $item) {
            // Валидация каждого оборудования отдельно
            $validator = \Illuminate\Support\Facades\Validator::make($item, [
                'equipment_type_id' => 'required|exists:equipment_types,id',
                'serial_number' => [
                    'required',
                    'string',
                    'distinct',
                    'unique:equipment,serial_number,NULL,id,equipment_type_id,' . $item['equipment_type_id'],
                ],
                'desc' => 'nullable|string',
            ]);

            // Если валидация не проходит, добавляем в ошибки и переходим к следующему элементу
            if ($validator->fails()) {
                $result['errors'][$index] = $validator->errors()->toArray(); // Сбор всех ошибок для формы
                logger()->error('Ошибка валидации для формы ' . $index, $validator->errors()->toArray()); // Логируем ошибки валидации
                continue;
            }

            // Если валидация проходит, продолжаем создание оборудования
            try {
                // Проверка маски серийного номера
                $equipmentType = EquipmentType::findOrFail($item['equipment_type_id']);
                if (!$this->validateSerialNumber($equipmentType->mask, $item['serial_number'])) {
                    $result['errors'][$index] = ['serial_number' => ['Неверный формат серийного номера для данного типа оборудования.']];
                    logger()->error('Ошибка валидации серийного номера для формы ' . $index, ['serial_number' => $item['serial_number']]);
                    continue;
                }

                // Создаем оборудование, если все проверки пройдены
                $equipment = Equipment::create($item);
                $result['success'][$index] = new EquipmentResource($equipment); // Возвращаем ресурс созданного оборудования
                logger()->info('Оборудование успешно создано для формы ' . $index, ['equipment' => $equipment]);

            } catch (\Exception $e) {
                $result['errors'][$index] = ['general' => [$e->getMessage()]];
                logger()->error('Произошло исключение при создании оборудования для формы ' . $index, ['exception' => $e->getMessage()]);
            }
        }

        logger()->info('Итоговый массив результатов', $result);
        return $result; // Возвращаем результат с ошибками и успешными операциями
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
