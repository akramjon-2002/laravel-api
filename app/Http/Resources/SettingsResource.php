<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'language' => $this->language,
            'timezone' => $this->timezone,
            'time_format' => $this->time_format,
            'notifications_enabled' => $this->notifications_enabled,
        ];
    }
}
