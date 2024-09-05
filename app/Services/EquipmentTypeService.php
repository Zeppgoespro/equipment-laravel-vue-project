<?php

namespace App\Services;

use App\Models\EquipmentType;
use App\Http\Resources\EquipmentTypeResource;

class EquipmentTypeService
{

    /**
     * Получаем постраничный список типов оборудования с возможностью поиска.
     */
    public function getPaginatedList($queryParams)
    {
        $query = EquipmentType::query();

        // Поиск по названию
        foreach ($queryParams as $key => $value) {
            if ($key === 'name') {
                $query->where($key, 'like', '%' . $value . '%');
            }
        }

        return EquipmentTypeResource::collection($query->paginate(10));
    }

}
