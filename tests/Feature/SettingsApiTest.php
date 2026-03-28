<?php

beforeEach(function (): void {
    authenticateUser();
});

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

it('returns validation errors for invalid settings payload', function (): void {
    $this->putJson('/api/settings', [
        'timezone' => 'bad-timezone',
        'time_format' => 'bad-format',
        'notifications_enabled' => 'not-a-boolean',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['timezone', 'time_format', 'notifications_enabled']);
});

it('returns a bad request error for malformed settings json', function (): void {
    $this->call(
        'PUT',
        '/api/settings',
        [],
        [],
        [],
        [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
        ],
        <<<'JSON'
{
  "language": "en",
  "timezone": "Asia/Tashkent",
  "time_format": "24h",
  "notifications_enabled":
}
JSON
    )
        ->assertBadRequest()
        ->assertJsonPath('message', 'Malformed JSON payload.');
});
