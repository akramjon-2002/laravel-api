<?php

namespace App\Contracts\Repositories;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ConversationRepositoryInterface
{
    public function paginateForUser(User $user, array $filters = []): LengthAwarePaginator;

    public function findForUser(User $user, int $conversationId): ?Conversation;

    public function getMessages(Conversation $conversation): Collection;

    public function createMessage(Conversation $conversation, User $sender, string $body): Message;
}
