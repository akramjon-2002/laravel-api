<?php

it('returns a JSON not found error for unknown api routes', function (): void {
    $this->getJson('/api/unknown-endpoint')
        ->assertNotFound()
        ->assertJsonPath('message', 'API route not found.');
});
