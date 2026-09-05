<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskCheckItem;
use Illuminate\Database\Seeder;

class TaskCheckItemSeeder extends Seeder
{
    public function run(): void
    {
        $task = Task::first();

        if (!$task) {
            $this->command->warn('タスクが存在しないため、チェック項目を作成できませんでした。');
            return;
        }

        $checkItems = [
            [
                'title' => '画面のレイアウトを作成する',
                'is_done' => true,
            ],
            [
                'title' => 'チェックボックスを表示する',
                'is_done' => true,
            ],
            [
                'title' => 'APIと接続する',
                'is_done' => false,
            ],
            [
                'title' => '進捗率を表示する',
                'is_done' => false,
            ],
        ];

        foreach ($checkItems as $checkItem) {
            $task->checkItems()->create($checkItem);
        }
    }
}
