<?php

namespace App\Actions\Conversation;

use App\Contracts\Repositories\ConversationRepositoryInterface;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ListConversationsAction
{
    public function __construct(
        private readonly ConversationRepositoryInterface $conversationRepository,
    ) {
    }

    public function __invoke(User $user, array $filters = []): LengthAwarePaginator
    {
        $conversations = $this->conversationRepository->paginateForUser($user, $filters);

        $conversations->setCollection(
            $conversations->getCollection()->map(
                fn (Conversation $conversation) => $this->prepareSummary($conversation, $user)
            )
        );

        return $conversations;
    }

    private function prepareSummary(Conversation $conversation, User $user): Conversation
    {
        $participants = $conversation->getRelation('participants');
        $messages = $conversation->getRelation('messages');

        $counterparty = $participants instanceof Collection
            ? $participants->first(fn (User $participant) => $participant->id !== $user->id)
            : null;

        $lastMessage = $messages instanceof Collection
            ? $messages->first()
            : null;

        $conversation->setAttribute('counterparty_user', $counterparty);
        $conversation->setAttribute('last_message_model', $lastMessage);

        return $conversation;
    }
}
