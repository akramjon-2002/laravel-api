<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $participants = $this->whenLoaded('participants');
        $counterparty = $this->resource->getAttribute('counterparty_user');
        $lastMessageModel = $this->resource->getAttribute('last_message_model');

        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'last_message_at' => optional($this->last_message_at)?->toIso8601String(),
            'counterparty' => $counterparty ? new UserSummaryResource($counterparty) : null,
            'participants' => UserSummaryResource::collection($participants),
            'last_message' => $lastMessageModel ? new MessageResource($lastMessageModel) : null,
        ];
    }
}
