<?php

namespace App\Contracts\Services;

interface AvatarServiceInterface
{
    public function makeAvatarUrl(string $seed): string;
}
