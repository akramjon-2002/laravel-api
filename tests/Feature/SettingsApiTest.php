<?php

it('returns current settings', function (): void {
    $this->getJson('/api/settings')
        ->assertOk()
        ->assertJsonPath('data.language', 'en')
        ->assertJsonPath('data.timezone', 'UTC');
});

it('updates settings', function (): void {
    $this->putJson('/api/settings', [
        'timezone' => 'Asia/Tashkent',
        'time_format' => '12h',
        'notifications_enabled' => false,
    ])
        ->assertOk()
        ->assertJsonPath('data.timezone', 'Asia/Tashkent')
        ->assertJsonPath('data.time_format', '12h')
        ->assertJsonPath('data.notifications_enabled', false);
});
