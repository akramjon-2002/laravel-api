<?php

namespace App\Repositories;

use App\Contracts\Repositories\SettingsRepositoryInterface;
use App\Models\User;
use App\Models\UserSetting;

class EloquentSettingsRepository implements SettingsRepositoryInterface
{
    public function getForUser(User $user): UserSetting
    {
        return $user->settings()->firstOrCreate(
            [],
            [
                'language' => 'en',
                'timezone' => 'UTC',
                'time_format' => '24h',
                'notifications_enabled' => true,
            ]
        );
    }

    public function updateForUser(User $user, array $attributes): UserSetting
    {
        $settings = $this->getForUser($user);
        $settings->fill($attributes);
        $settings->save();

        return $settings->refresh();
    }
}
