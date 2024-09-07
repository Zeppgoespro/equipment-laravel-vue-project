<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Services\EquipmentService;
use Illuminate\Http\Request;

/**
 * Контроллер для управления оборудованием.
 */
class EquipmentController extends Controller
{
    /**
     * Конструктор класса.
     *
     * @param EquipmentService $equipmentService Сервис для работы с оборудованием.
     */
    public function __construct(protected EquipmentService $equipmentService)
    {
    }

    /**
     * Возвращает список оборудования с пагинацией и поиском.
     *
     * @param Request $request HTTP-запрос с параметрами.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->equipmentService->getPaginatedList($request->query());
    }

    /**
     * Создает новое оборудование.
     *
     * @param StoreEquipmentRequest $request HTTP-запрос с данными для создания.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreEquipmentRequest $request)
    {
        return $this->equipmentService->store($request->validated());
    }

    /**
     * Возвращает информацию об оборудовании по ID.
     *
     * @param int $id ID оборудования.
     * @return EquipmentResource
     */
    public function show($id)
    {
        return $this->equipmentService->show($id);
    }

    /**
     * Обновляет информацию об оборудовании.
     *
     * @param UpdateEquipmentRequest $request HTTP-запрос с данными для обновления.
     * @param int $id ID оборудования.
     * @return EquipmentResource
     */
    public function update(UpdateEquipmentRequest $request, $id)
    {
        return $this->equipmentService->update($id, $request->validated());
    }

    /**
     * Удаляет оборудование.
     *
     * @param int $id ID оборудования.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->equipmentService->destroy($id);
    }
}
