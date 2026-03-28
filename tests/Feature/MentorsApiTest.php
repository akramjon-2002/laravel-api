<?php

use App\Models\Category;
use App\Models\Mentor;
use App\Models\Review;
use App\Models\Task;

beforeEach(function (): void {
    authenticateUser();
});

it('lists mentors and recent mentors', function (): void {
    $this->getJson('/api/mentors')
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'role', 'rating', 'reviews_count', 'is_followed'],
            ],
            'links',
            'meta',
        ]);

    $this->getJson('/api/mentors/recent')
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'role'],
            ],
        ]);
});

it('returns mentor details', function (): void {
    $category = Category::factory()->create([
        'name' => 'Automation QA',
        'slug' => 'automation-qa',
    ]);
    $mentor = Mentor::factory()->create([
        'category_id' => $category->id,
        'name' => 'Factory Mentor',
        'role' => 'Automation Reviewer',
    ]);

    $this->getJson('/api/mentors/'.$mentor->id)
        ->assertOk()
        ->assertJsonPath('data.name', 'Factory Mentor')
        ->assertJsonPath('data.role', 'Automation Reviewer');
});

it('computes mentor metrics from related tasks and reviews instead of stored counters', function (): void {
    $category = Category::query()->firstOrFail();
    $mentor = Mentor::factory()->create([
        'category_id' => $category->id,
        'tasks_count' => 99,
        'reviews_count' => 99,
        'rating' => 1.00,
    ]);

    Task::factory()->count(2)->create([
        'category_id' => $category->id,
        'mentor_id' => $mentor->id,
    ]);

    Review::factory()->create([
        'mentor_id' => $mentor->id,
        'user_id' => seededUser()->id,
        'rating' => 4,
    ]);

    Review::factory()->create([
        'mentor_id' => $mentor->id,
        'rating' => 5,
    ]);

    $this->getJson('/api/mentors/'.$mentor->id)
        ->assertOk()
        ->assertJsonPath('data.tasks_count', 2)
        ->assertJsonPath('data.reviews_count', 2)
        ->assertJsonPath('data.rating', 4.5);
});

it('can follow and unfollow a mentor', function (): void {
    $category = Category::factory()->create([
        'name' => 'Platform Engineering',
        'slug' => 'platform-engineering',
    ]);
    $mentor = Mentor::factory()->create([
        'category_id' => $category->id,
    ]);

    $this->postJson('/api/mentors/'.$mentor->id.'/follow')
        ->assertOk()
        ->assertJsonPath('data.is_followed', true);

    $this->deleteJson('/api/mentors/'.$mentor->id.'/follow')
        ->assertOk()
        ->assertJsonPath('data.is_followed', false);
});

it('returns validation errors for invalid mentor filters', function (): void {
    $this->getJson('/api/mentors?sort=wrong&category_id=999999')
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['sort', 'category_id']);
});

it('returns a JSON not found error for a missing mentor', function (): void {
    $this->postJson('/api/mentors/999999/follow')
        ->assertNotFound()
        ->assertJsonPath('message', 'Mentor not found.');
});
