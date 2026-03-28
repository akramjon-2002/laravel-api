<?php

namespace App\Services;

use App\Contracts\Services\AvatarServiceInterface;

class DiceBearAvatarService implements AvatarServiceInterface
{
    public function makeAvatarUrl(string $seed): string
    {
        return sprintf(
            'https://api.dicebear.com/7.x/avataaars/svg?seed=%s',
            urlencode($seed)
        );
    }
}
