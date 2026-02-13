<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();

        if ($projects->isEmpty()) {
            return;
        }

        $taskNames = [
            '要件定義', '設計', '実装', 'テスト', 'レビュー', 'デプロイ',
        ];

        foreach ($projects as $project) {
            foreach (array_slice($taskNames, 0, rand(2, 5)) as $i => $name) {
                Task::create([
                    'project_id' => $project->id,
                    'name' => $project->name . ' - ' . $name,
                    'is_done' => $i === 0, // 1つ目だけ完了など
                    'due_date' => now()->addDays(rand(5, 30))->format('Y-m-d'),
                ]);
            }
        }
    }
}