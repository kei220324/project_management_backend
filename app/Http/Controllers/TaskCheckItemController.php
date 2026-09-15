<?php


namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\TaskCheckItem;
use App\Http\Requests\StoreTaskCheckItemRequest;
use App\Http\Requests\UpdateTaskCheckItemRequest;

use Symfony\Component\HttpFoundation\JsonResponse;

class TaskCheckItemController extends Controller
{
    public function index(Task $task): JsonResponse
    {
        $checkItems = $task->checkItems()
            ->orderBy('id')
            ->get();

        return response()->json($checkItems);
    }

    public function update(UpdateTaskCheckItemRequest $request, Task $task, TaskCheckItem $checkItem): JsonResponse
    {
  
        if ($checkItem->task_id !== $task->id) {
            return response()->json(['error' => 'Check item does not belong to the specified task.'], 400);
        }

        $checkItem->update($request->validated());

        return response()->json($checkItem);
    }

    public function store(
        StoreTaskCheckItemRequest $request,
        Task $task
    ): JsonResponse {
        $validatedData = $request->validated();

        $checkItem = new TaskCheckItem($validatedData);
        $checkItem->task()->associate($task);
        $checkItem->save();

        return response()->json($checkItem, 201);
    }

    public function destroy(Task $task,TaskCheckItem $checkItem): JsonResponse
    {
        if ($checkItem->task_id !== $task->id) {
            return response()->json(['error' => 'Check item does not belong to the specified task.'], 400);
        }

        $checkItem->delete();

        return response()->json(null, 204);

    }
    
}
