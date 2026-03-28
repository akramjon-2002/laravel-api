<?php

namespace App\Actions\Settings;

use App\Contracts\Repositories\SettingsRepositoryInterface;
use App\Models\User;
use App\Models\UserSetting;

class UpdateSettingsAction
{
    public function __construct(
        private readonly SettingsRepositoryInterface $settingsRepository,
    ) {
    }

    public function __invoke(User $user, array $attributes): UserSetting
    {
        return $this->settingsRepository->updateForUser($user, $attributes);
    }
}
