<?php

namespace App\Http\Controllers;

use App\Services\EquipmentTypeService;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    public function __construct(protected EquipmentTypeService $equipmentTypeService)
    {
    }

    public function index(Request $request)
    {
        return $this->equipmentTypeService->getPaginatedList($request->query());
    }
}
