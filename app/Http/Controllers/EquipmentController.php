<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Services\EquipmentService;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{

    public function __construct(protected EquipmentService $equipmentService)
    {
    }

    public function index(Request $request)
    {
        return $this->equipmentService->getPaginatedList($request->query());
    }

    public function store(StoreEquipmentRequest $request)
    {
        return $this->equipmentService->store($request->validated());
    }

    public function show($id)
    {
        return $this->equipmentService->show($id);
    }

    public function update(UpdateEquipmentRequest $request, $id)
    {
        return $this->equipmentService->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->equipmentService->destroy($id);
    }

}
