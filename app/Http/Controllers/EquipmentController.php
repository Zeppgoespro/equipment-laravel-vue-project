<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentSearchRequest;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Requests\BulkStoreEquipmentRequest;
use App\Services\EquipmentService;
use App\Models\Equipment;
use App\Http\Resources\EquipmentResource;

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
     * @param EquipmentSearchRequest $request HTTP-запрос с параметрами поиска.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(EquipmentSearchRequest $request)
    {
        $query = Equipment::query();

        // Поиск по 'q' в 'serial_number' и 'desc'
        if ($request->has('q')) {
            $query->where('serial_number', 'like', '%' . $request->q . '%')
                  ->orWhere('desc', 'like', '%' . $request->q . '%');
        }

        if ($request->has('serial_number')) {
            $query->where('serial_number', 'like', '%' . $request->serial_number . '%');
        }

        if ($request->has('desc')) {
            $query->where('desc', 'like', '%' . $request->desc . '%');
        }

        return EquipmentResource::collection($query->paginate(10));
    }

    /**
     * Создает новое оборудование.
     *
     * @param StoreEquipmentRequest $request HTTP-запрос с данными для создания оборудования.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreEquipmentRequest $request)
    {
        return $this->equipmentService->store($request->validated());
    }

    /**
     * Массовое создание нового оборудования.
     *
     * @param BulkStoreEquipmentRequest $request HTTP-запрос с данными для массового создания оборудования.
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeBulk(BulkStoreEquipmentRequest $request)
    {
        $equipments = $request->input('equipment');
        $result = $this->equipmentService->storeBulk($equipments);

        $response = [
            'errors' => [],
            'success' => [],
        ];

        foreach ($result['errors'] as $index => $error) {
            $response['errors'][(string)$index] = [$error];
        }

        foreach ($result['success'] as $index => $equipment) {
            $response['success'][(string)$index] = new EquipmentResource($equipment);
        }

        return response()->json($response, empty($response['errors']) ? 200 : 400);
    }

    /**
     * Возвращает информацию об оборудовании по ID.
     *
     * @param Equipment $equipment Модель оборудования.
     * @return EquipmentResource
     */
    public function show(Equipment $equipment)  // Используем неявное привязывание модели
    {
        return new EquipmentResource($equipment);
    }

    /**
     * Обновляет информацию об оборудовании.
     *
     * @param UpdateEquipmentRequest $request HTTP-запрос с данными для обновления оборудования.
     * @param Equipment $equipment Модель оборудования.
     * @return EquipmentResource
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment)  // Используем неявное привязывание модели
    {
        $equipment->update($request->validated());
        return new EquipmentResource($equipment);
    }

    /**
     * Удаляет оборудование.
     *
     * @param Equipment $equipment Модель оборудования.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Equipment $equipment)  // Используем неявное привязывание модели
    {
        $equipment->delete();
        return response()->json(['message' => 'Успешно удалено!']);
    }
}
