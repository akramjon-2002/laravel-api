<?php

use Laravel\Sanctum\PersonalAccessToken;

it('logs in and returns a sanctum token', function (): void {
    $this->postJson('/api/auth/login', [
        'email' => 'dennis@example.com',
        'password' => 'password',
        'device_name' => 'pest-suite',
    ])
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'token',
                'token_type',
                'user' => ['id', 'name', 'avatar_url'],
            ],
        ])
        ->assertJsonMissingPath('data.user.email')
        ->assertJsonPath('data.token_type', 'Bearer');
});

it('rejects invalid credentials', function (): void {
    $this->postJson('/api/auth/login', [
        'email' => 'dennis@example.com',
        'password' => 'wrong-password',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});

it('returns the authenticated user profile', function (): void {
    authenticateUser();

    $this->getJson('/api/auth/me')
        ->assertOk()
        ->assertJsonPath('data.name', 'Dennis Nzioki')
        ->assertJsonMissingPath('data.email');
});

it('logs out the current sanctum token', function (): void {
    $user = seededUser();
    $token = $user->createToken('logout-test')->plainTextToken;

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/auth/logout')
        ->assertOk()
        ->assertJsonPath('message', 'Logged out successfully.');

    expect(PersonalAccessToken::query()->count())->toBe(0);
});
