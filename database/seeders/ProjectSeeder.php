<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'name' => 'Webサイトリニューアル',
                'summary' => 'コーポレートサイトのデザインと実装',
                'due_date' => now()->addMonths(2)->format('Y-m-d'),
            ],
            [
                'name' => 'API開発',
                'summary' => 'モバイルアプリ用REST API',
                'due_date' => now()->addMonth()->format('Y-m-d'),
            ],
            [
                'name' => 'ドキュメント整備',
                'summary' => null,
                'due_date' => null,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}