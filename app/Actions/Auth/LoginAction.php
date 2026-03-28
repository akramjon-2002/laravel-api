<?php

namespace App\Actions\Auth;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @return array{user: User, token: string}
     */
    public function __invoke(string $email, string $password, string $deviceName): array
    {
        $user = $this->userRepository->findByEmail($email);

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return [
            'user' => $user,
            'token' => $user->createToken($deviceName)->plainTextToken,
        ];
    }
}
