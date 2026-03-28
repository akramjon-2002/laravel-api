<?php

namespace App\Actions\User;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class ResolveCurrentUserAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(?Authenticatable $authenticatedUser = null): User
    {
        if ($authenticatedUser instanceof User) {
            return $authenticatedUser;
        }

        return $this->userRepository->resolveDemoUser();
    }
}
