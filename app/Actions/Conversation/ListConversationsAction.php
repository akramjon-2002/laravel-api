<?php

namespace App\Actions\Conversation;

use App\Contracts\Repositories\ConversationRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListConversationsAction
{
    public function __construct(
        private readonly ConversationRepositoryInterface $conversationRepository,
    ) {
    }

    public function __invoke(User $user, array $filters = []): LengthAwarePaginator
    {
        return $this->conversationRepository->paginateForUser($user, $filters);
    }
}
