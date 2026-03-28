<?php

use App\Models\Category;
use App\Models\Task;

it('lists tasks with pagination metadata', function (): void {
    $this->getJson('/api/tasks')
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'status', 'progress', 'category', 'mentor'],
            ],
            'links',
            'meta',
        ]);
});

it('filters tasks by search and category', function (): void {
    $category = Category::query()->where('slug', 'backend-development')->firstOrFail();

    $this->getJson('/api/tasks?search=Interview&category_id='.$category->id)
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.title', 'Interview Task API Delivery')
        ->assertJsonPath('data.0.category.slug', 'backend-development');
});

it('returns task details', function (): void {
    $task = Task::query()->where('title', 'Creating Awesome Mobile Apps')->firstOrFail();

    $this->getJson('/api/tasks/'.$task->id)
        ->assertOk()
        ->assertJsonPath('data.title', 'Creating Awesome Mobile Apps')
        ->assertJsonCount(3, 'data.steps');
});

it('returns task steps', function (): void {
    $task = Task::query()->where('title', 'Creating Awesome Mobile Apps')->firstOrFail();

    $this->getJson('/api/tasks/'.$task->id.'/steps')
        ->assertOk()
        ->assertJsonCount(3, 'data')
        ->assertJsonPath('data.0.sort_order', 1);
});
