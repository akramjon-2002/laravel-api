<?php

namespace App\Http\Controllers\Api;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\User\ResolveCurrentUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\UserSummaryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private readonly LoginAction $login,
        private readonly LogoutAction $logout,
        private readonly ResolveCurrentUserAction $resolveCurrentUser,
    ) {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $payload = ($this->login)(
            $request->validated('email'),
            $request->validated('password'),
            $request->validated('device_name', 'postman'),
        );

        return response()->json([
            'data' => [
                'token' => $payload['token'],
                'token_type' => 'Bearer',
                'user' => new UserSummaryResource($payload['user']),
            ],
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'data' => new UserSummaryResource(($this->resolveCurrentUser)($request->user())),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        ($this->logout)(($this->resolveCurrentUser)($request->user()));

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}
