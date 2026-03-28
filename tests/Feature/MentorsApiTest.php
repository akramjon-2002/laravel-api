<?php

use App\Models\Mentor;

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
    $mentor = Mentor::query()->where('name', 'Sarah Johnson')->firstOrFail();

    $this->getJson('/api/mentors/'.$mentor->id)
        ->assertOk()
        ->assertJsonPath('data.name', 'Sarah Johnson')
        ->assertJsonPath('data.role', 'Senior UI/UX Designer');
});

it('can follow and unfollow a mentor', function (): void {
    $mentor = Mentor::query()->where('name', 'Sarah Johnson')->firstOrFail();

    $this->postJson('/api/mentors/'.$mentor->id.'/follow')
        ->assertOk()
        ->assertJsonPath('data.is_followed', true);

    $this->deleteJson('/api/mentors/'.$mentor->id.'/follow')
        ->assertOk()
        ->assertJsonPath('data.is_followed', false);
});
