<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function resolveDemoUser(): User
    {
        return User::query()
            ->where('email', config('app.demo_user_email'))
            ->first() ?? User::query()->firstOrFail();
    }
}
