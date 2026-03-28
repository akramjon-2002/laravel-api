<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use App\Models\UserSetting;

interface SettingsRepositoryInterface
{
    public function getForUser(User $user): UserSetting;

    public function updateForUser(User $user, array $attributes): UserSetting;
}
