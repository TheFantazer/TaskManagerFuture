<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Task;
class TaskController extends Controller
{
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

    public function show($id): Response
    {
        $task = Task::query()->findOrFail($id);

        return response($task, 200);
    }

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

    public function destroy($id): Response
    {
        Task::query()->findOrFail($id)->delete();

        return response(['message' => 'Task deleted successfully'], 200);
    }
}
