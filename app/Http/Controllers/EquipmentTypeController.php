<?php

namespace App\Http\Controllers;

use App\Services\EquipmentTypeService;
use App\Http\Requests\EquipmentTypeSearchRequest;
use App\Http\Resources\EquipmentTypeResource;
use App\Models\EquipmentType;

class EquipmentTypeController extends Controller
{
    public function __construct(protected EquipmentTypeService $equipmentTypeService)
    {
    }

    public function index(EquipmentTypeSearchRequest $request)
    {
        $query = EquipmentType::query();

        // Поиск по 'q' в 'name' и 'mask'
        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('mask', 'like', '%' . $request->q . '%');
        }

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%'); // Поиск по "name"
        }

        if ($request->has('mask')) {
            $query->where('mask', 'like', '%' . $request->mask . '%'); // Поиск по "mask"
        }

        return EquipmentTypeResource::collection($query->paginate(10));
    }
}
