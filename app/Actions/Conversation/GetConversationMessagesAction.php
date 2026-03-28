<?php

namespace App\Actions\Conversation;

use App\Contracts\Repositories\ConversationRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class GetConversationMessagesAction
{
    public function __construct(
        private readonly ConversationRepositoryInterface $conversationRepository,
    ) {
    }

    public function __invoke(User $user, int $conversationId): Collection
    {
        $conversation = $this->conversationRepository->findForUser($user, $conversationId);

        if (! $conversation) {
            return collect();
        }

        return $this->conversationRepository->getMessages($conversation);
    }
}
