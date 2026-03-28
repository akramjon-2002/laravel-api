<?php

namespace App\Repositories;

use App\Contracts\Repositories\ConversationRepositoryInterface;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EloquentConversationRepository implements ConversationRepositoryInterface
{
    public function paginateForUser(User $user, array $filters = []): LengthAwarePaginator
    {
        return $user->conversations()
            ->with([
                'participants',
                'messages' => fn ($query) => $query->latest('sent_at')->limit(1),
            ])
            ->when(
                $filters['search'] ?? null,
                function (Builder $builder, string $search): void {
                    $builder->whereHas('participants', function (Builder $participantQuery) use ($search): void {
                        $participantQuery->where('name', 'like', '%'.$search.'%');
                    });
                }
            )
            ->orderByDesc('last_message_at')
            ->paginate((int) ($filters['per_page'] ?? 10));
    }

    public function findForUser(User $user, int $conversationId): ?Conversation
    {
        return $user->conversations()
            ->with('participants')
            ->whereKey($conversationId)
            ->first();
    }

    public function getMessages(Conversation $conversation): Collection
    {
        return $conversation->messages()
            ->with('sender')
            ->orderBy('sent_at')
            ->get();
    }

    public function createMessage(Conversation $conversation, User $sender, string $body): Message
    {
        $message = $conversation->messages()->create([
            'sender_id' => $sender->id,
            'body' => $body,
            'sent_at' => now(),
            'read_at' => null,
        ]);

        $conversation->forceFill([
            'last_message_at' => $message->sent_at,
        ])->save();

        return $message->load('sender');
    }
}
