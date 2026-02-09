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
}
