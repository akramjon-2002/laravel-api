<?php

namespace App\Actions\Conversation;

use App\Contracts\Repositories\ConversationRepositoryInterface;
use App\Models\Message;
use App\Models\User;

class SendMessageAction
{
    public function __construct(
        private readonly ConversationRepositoryInterface $conversationRepository,
    ) {
    }

    public function __invoke(User $user, int $conversationId, string $body): ?Message
    {
        $conversation = $this->conversationRepository->findForUser($user, $conversationId);

        if (! $conversation) {
            return null;
        }

        return $this->conversationRepository->createMessage($conversation, $user, $body);
    }
}
