<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

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
}



