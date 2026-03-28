<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;

class ResolveCurrentUserAction
{
    public function __invoke(?Authenticatable $authenticatedUser = null): User
    {
        if ($authenticatedUser instanceof User) {
            return $authenticatedUser;
        }

        throw new AuthenticationException('Unauthenticated.');
    }
}
