<?php

namespace App\Services;

use App\Models\EquipmentType;
/**
 * Не используется
 */
class EquipmentTypeService
{

    /**
     * Получаем постраничный список типов оборудования с возможностью поиска
     */
    public function getPaginatedList($queryParams)
    {
        $query = EquipmentType::query();

        foreach ($queryParams as $key => $value) {
            if ($key === 'name') {
                $query->where($key, 'like', '%' . $value . '%');
            }
        }

        return $query->paginate(10);
    }
}
