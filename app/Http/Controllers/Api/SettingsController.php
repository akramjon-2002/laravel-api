<?php

namespace App\Http\Controllers\Api;

use App\Actions\Settings\GetSettingsAction;
use App\Actions\Settings\UpdateSettingsAction;
use App\Actions\User\ResolveCurrentUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateSettingsRequest;
use App\Http\Resources\SettingsResource;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct(
        private readonly ResolveCurrentUserAction $resolveCurrentUser,
        private readonly GetSettingsAction $getSettings,
        private readonly UpdateSettingsAction $updateSettings,
    ) {
    }

    public function show(Request $request): SettingsResource
    {
        $user = ($this->resolveCurrentUser)($request->user());

        return new SettingsResource(($this->getSettings)($user));
    }

    public function update(UpdateSettingsRequest $request): SettingsResource
    {
        $user = ($this->resolveCurrentUser)($request->user());

        return new SettingsResource(($this->updateSettings)($user, $request->validated()));
    }
}
