<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class,
)->in('Feature');

function seededUser(): User
{
    return User::query()
        ->where('email', config('app.demo_user_email'))
        ->firstOrFail();
}

function authenticateUser(): User
{
    $user = seededUser();

    Sanctum::actingAs($user);

    return $user;
}
