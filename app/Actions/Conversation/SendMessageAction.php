<?php

namespace App\Actions\Conversation;

use App\Contracts\Repositories\ConversationRepositoryInterface;
use App\Exceptions\ApiResourceNotFoundException;
use App\Models\Message;
use App\Models\User;

class SendMessageAction
{
    public function __construct(
        private readonly ConversationRepositoryInterface $conversationRepository,
    ) {
    }

    public function __invoke(User $user, int $conversationId, string $body): Message
    {
        $conversation = $this->conversationRepository->findForUser($user, $conversationId);

        if (! $conversation) {
            throw new ApiResourceNotFoundException('Conversation');
        }

        return $this->conversationRepository->createMessage($conversation, $user, $body);
    }
}
