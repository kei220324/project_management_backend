<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()
            ->select(['id', 'name', 'summary', 'due_date'])
            ->withTaskStats()
            ->latest('id')
            ->get();

        return response()->json($projects);
    }

    public function show(Project $project)
    {
        $project = Project::query()
            ->select(['id', 'name', 'summary', 'due_date'])
            ->withTaskStats()
            ->with([
                'tasks' => function ($query) {
                    $query
                        ->select(['id', 'project_id', 'name', 'is_done', 'due_date'])
                        ->orderBy('due_date')
                        ->orderBy('id');
                },
            ])
            ->findOrFail($project->id);

        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
            'message' => 'project deleted',
        ]);
    }
 public function store(StoreProjectRequest $request)
{
    $project = Project::create([
         'name' => $request->name,
        'summary' => $request->summary,
        'due_date' => $request->due_date,
    ]);

    return response()->json($project, 201);
}

public function update(StoreProjectRequest $request, Project $project)
{
    $project->update($request->validated());

    return response()->json($project);
}



}








