<?php

namespace App\Actions\Settings;

use App\Contracts\Repositories\SettingsRepositoryInterface;
use App\Models\User;
use App\Models\UserSetting;

class GetSettingsAction
{
    public function __construct(
        private readonly SettingsRepositoryInterface $settingsRepository,
    ) {
    }

    public function __invoke(User $user): UserSetting
    {
        return $this->settingsRepository->getForUser($user);
    }
}
