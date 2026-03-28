<?php

it('returns a JSON not found error for unknown api routes', function (): void {
    $this->getJson('/api/unknown-endpoint')
        ->assertNotFound()
        ->assertJsonPath('message', 'API route not found.');
});

it('returns a compact JSON method not allowed error for api routes', function (): void {
    $this->postJson('/api/overview')
        ->assertStatus(405)
        ->assertJsonPath('message', 'Method not allowed. Supported methods: GET, HEAD.')
        ->assertJsonMissingPath('exception')
        ->assertJsonMissingPath('trace');
});
