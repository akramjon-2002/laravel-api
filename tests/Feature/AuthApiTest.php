<?php

use Illuminate\Support\Str;
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

it('rate limits repeated login attempts', function (): void {
    $ip = '203.0.113.10';
    $email = 'dennis@example.com';

    foreach (range(1, 5) as $attempt) {
        $this->withServerVariables(['REMOTE_ADDR' => $ip])
            ->postJson('/api/auth/login', [
                'email' => $email,
                'password' => 'wrong-password',
                'device_name' => 'throttle-check-'.$attempt,
            ])
            ->assertUnprocessable();
    }

    $this->withServerVariables(['REMOTE_ADDR' => $ip])
        ->postJson('/api/auth/login', [
            'email' => $email,
            'password' => 'wrong-password',
            'device_name' => 'throttle-check-final-'.Str::random(5),
        ])
        ->assertStatus(429)
        ->assertJsonPath('message', 'Too many login attempts. Please try again later.');
});
