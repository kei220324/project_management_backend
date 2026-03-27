<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(StoreTaskRequest $request, Project $project)
{
    $task = $project->tasks()->create([
        'name' => $request->name,
        'due_date' => $request->due_date,
        'is_done' => 0
    ]);

    return response()->json($task, 201);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function toggle(Task $task)
    {
        $task->update([
            'is_done' => !$task->is_done,
        ]);
    
        return response()->json($task);
    }
}
