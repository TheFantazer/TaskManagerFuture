<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Task;


/**
 * @OA\Info(
 *     title="Task Management API",
 *     version="1.0.0",
 *     description="API для управления списком задач",
 *     @OA\Contact(
 *         email="support@example.com"
 *     )
 * )
 *
 * @OA\PathItem(path="/api/tasks")
 * @OA\Tag(name="Tasks", description="API для управления задачами")
 */
class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Получение списка задач",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Поиск по названию",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Сортировка по полям (due_date, create_date)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список задач",
     *         @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="id", type="integer", description="ID задачи"),
     *          @OA\Property(property="title", type="string", description="Название задачи", maxLength=255),
     *          @OA\Property(property="description", type="string", description="Описание задачи", nullable=true),
     *          @OA\Property(property="due_date", type="string", format="date-time", description="Срок выполнения"),
     *          @OA\Property(property="create_date", type="string", format="date-time", description="Дата создания"),
     *          @OA\Property(property="status", type="string", description="Статус задачи", enum={"выполнена", "не выполнена"}),
     *          @OA\Property(property="priority", type="string", description="Приоритет задачи", enum={"низкий", "средний", "высокий"}),
     *          @OA\Property(property="category", type="string", description="Категория задачи", maxLength=50)
     * )
     *     )
     * )
     */
    public function index(Request $request): Response
    {
        $tasks = Task::query();

        if ($request->has('search')) {
            $tasks->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort')) {
            $tasks->orderBy($request->sort);
        }

        return response($tasks->get(), 200);
    }
    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Создание задачи",
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *              @OA\Property(property="title", type="string", description="Название задачи", maxLength=255),
     *              @OA\Property(property="description", type="string", description="Описание задачи", nullable=true),
     *              @OA\Property(property="due_date", type="string", format="date-time", description="Срок выполнения"),
     *              @OA\Property(property="create_date", type="string", format="date-time", description="Дата создания"),
     *              @OA\Property(property="status", type="string", description="Статус задачи", enum={"выполнена", "не выполнена"}),
     *              @OA\Property(property="priority", type="string", description="Приоритет задачи", enum={"низкий", "средний", "высокий"}),
     *              @OA\Property(property="category", type="string", description="Категория задачи", maxLength=50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Задача успешно создана",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'create_date' => 'required|date',
            'status' => 'required|in:выполнена,не выполнена',
            'priority' => 'required|in:низкий,средний,высокий',
            'category' => 'required|string|max:50',
        ]);

        $task = Task::query()->create($validated);

        return response(['id' => $task->id, 'message' => 'Task created successfully'], 201);
    }
    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Получение задачи по ID",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID задачи",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Данные задачи",
     *         @OA\JsonContent(
     *             type="object",
     *              @OA\Property(property="id", type="integer", description="ID задачи"),
     *              @OA\Property(property="title", type="string", description="Название задачи", maxLength=255),
     *                  @OA\Property(property="description", type="string", description="Описание задачи", nullable=true),
     *                  @OA\Property(property="due_date", type="string", format="date-time", description="Срок выполнения"),
     *                  @OA\Property(property="create_date", type="string", format="date-time", description="Дата создания"),
     *                  @OA\Property(property="status", type="string", description="Статус задачи", enum={"выполнена", "не выполнена"}),
     *                  @OA\Property(property="priority", type="string", description="Приоритет задачи", enum={"низкий", "средний", "высокий"}),
     *                  @OA\Property(property="category", type="string", description="Категория задачи", maxLength=50)
     *         )
     *     )
     * )
     */
    public function show($id): Response
    {
        $task = Task::query()->findOrFail($id);

        return response($task, 200);
    }
    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Обновление задачи",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID задачи",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *              @OA\Property(property="title", type="string", description="Название задачи", maxLength=255),
     *                  @OA\Property(property="description", type="string", description="Описание задачи", nullable=true),
     *                  @OA\Property(property="due_date", type="string", format="date-time", description="Срок выполнения"),
     *                  @OA\Property(property="create_date", type="string", format="date-time", description="Дата создания"),
     *                  @OA\Property(property="status", type="string", description="Статус задачи", enum={"выполнена", "не выполнена"}),
     *                  @OA\Property(property="priority", type="string", description="Приоритет задачи", enum={"низкий", "средний", "высокий"}),
     *                  @OA\Property(property="category", type="string", description="Категория задачи", maxLength=50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Задача успешно обновлена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id): Response
    {
        $task = Task::query()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'sometimes|required|date',
            'create_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:выполнена,не выполнена',
            'priority' => 'sometimes|required|in:низкий,средний,высокий',
            'category' => 'sometimes|required|string|max:50',
        ]);

        $task->update($validated);

        return response(['message' => 'Task updated successfully'], 200);
    }
    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Удаление задачи",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID задачи",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Задача успешно удалена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy($id): Response
    {
        Task::query()->findOrFail($id)->delete();

        return response(['message' => 'Task deleted successfully'], 200);
    }
}
