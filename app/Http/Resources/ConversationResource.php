<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $currentUserId = $request->attributes->get('current_user_id');
        $participants = $this->whenLoaded('participants');
        $counterparty = $participants instanceof \Illuminate\Support\Collection
            ? $participants->first(fn (User $user) => $user->id !== $currentUserId)
            : null;
        $lastMessage = $this->whenLoaded('messages');
        $lastMessageModel = $lastMessage instanceof \Illuminate\Support\Collection ? $lastMessage->first() : null;

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
