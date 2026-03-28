<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'sent_at' => optional($this->sent_at)?->toIso8601String(),
            'read_at' => optional($this->read_at)?->toIso8601String(),
            'sender' => new UserSummaryResource($this->whenLoaded('sender')),
        ];
    }
}
