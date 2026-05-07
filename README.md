# Project Management Backend

## 概要

プロジェクトおよびタスク管理機能を提供するバックエンドAPIです。  
LaravelでREST APIを構築し、Reactフロントエンドと連携してデータの取得・更新を行います。

---

## 使用技術

- Laravel
- PHP
- MySQL
- Eloquent ORM
- REST API

---

## 主な機能

- プロジェクト一覧取得
- プロジェクト詳細取得
- プロジェクト作成
- プロジェクト更新
- プロジェクト削除
- タスク一覧取得
- タスク作成
- タスク更新
- タスク削除
- タスク完了 / 未完了切り替え

---

## API設計

Reactフロントエンドからのリクエストを受け取り、
JSON形式でデータを返却しています。

### プロジェクト関連

| Method | Endpoint | 内容 |
|---|---|---|
| GET | `/api/projects` | プロジェクト一覧取得 |
| GET | `/api/projects/{projectId}` | プロジェクト詳細取得 |
| POST | `/api/projects` | プロジェクト作成 |
| PUT | `/api/projects/{projectId}` | プロジェクト更新 |
| DELETE | `/api/projects/{projectId}` | プロジェクト削除 |

### タスク関連

| Method | Endpoint | 内容 |
|---|---|---|
| GET | `/api/projects/{projectId}/tasks` | プロジェクトに紐づくタスク一覧取得 |
| GET | `/api/tasks/{taskId}` | タスク詳細取得 |
| POST | `/api/projects/{projectId}/tasks` | タスク作成 |
| PUT | `/api/tasks/{taskId}` | タスク更新 |
| DELETE | `/api/tasks/{taskId}` | タスク削除 |
| PATCH | `/api/tasks/{taskId}/toggle` | タスク状態変更 |

また、
プロジェクトごとの

- タスク総数
- 完了済みタスク数
- status判定
- progress_percent

などもAPI側で管理しています。

---

## Model設計

Eloquent ORMを利用し、
Project と Task のリレーションを定義しています。

### Project Model

- タスクとのリレーション管理
- status算出
- progress_percent算出
- タスク集計処理
- scopeによるクエリ共通化

などを担当しています。

### Task Model

- タスク情報管理
- 完了状態管理
- プロジェクトとの関連付け

を担当しています。

---

## 工夫した点

### status を DB に持たず算出で管理

status はタスクの状態によって変わるため、
DBには保存せず Model 側で判定しています。

DBに保存すると、
タスク更新時に status 更新漏れが発生する可能性があるため、
タスク状態から動的に判定する形にしました。

---

### withCount を利用した集計処理

タスク総数や完了済みタスク数は、
`withCount` を利用して取得しています。

```php
Project::withCount([
    'tasks',
    'tasks as done_tasks_count' => fn ($query) =>
        $query->where('is_done', true),
]);
```

最初はPHP側でタスク数を count していましたが、
一覧表示時の処理量が増えやすかったため、
withCount を利用してSQL側で集計するように改善しました。
---
### N+1問題を意識したデータ取得

関連データ取得時には、
N+1問題を避けることを意識しています。

`withCount` や `loadCount` を利用し、
必要なデータをまとめて取得するようにしました。

---

### フロントエンドとバックエンドの責務分離

最初はフロント側で
status 判定や集計処理を行っていました。

ただ、
ロジックが増えるにつれて
フロント側の処理が複雑になってきたため、
現在は Laravel 側で集計や status 判定を行っています。

React 側は取得したデータを表示する役割に寄せ、
責務を分けるようにしました。

---

## 苦労した点

### データ取得と集計処理

プロジェクト一覧取得時に、

- タスク総数
- 完了済みタスク数
- status判定
- progress_percent算出

などを効率的に取得する必要がありました。

最初はフロント側で集計や判定を行っていましたが、
処理が分散し管理しづらくなっていました。

そのため、

- `withCount`
- `scope`
- Model側でのstatus算出

などを利用し、
責務を整理しながら改善しました。

---

## 今後の改善
### Serviceクラスへのロジック分離

現在の規模では問題ありませんが、
機能追加で処理が増えるとControllerやModelが肥大化し、
管理しづらくなると考えています。

そのため今後はServiceクラスへ処理を分離し、
役割を整理したいと考えています。

### テストコード追加

現在は手動確認中心のため、
Feature Test や Unit Test を追加し、
品質向上を進めたいと考えています。
