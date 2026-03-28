<?php

namespace App\Http\Controllers\Api;

use App\Actions\Conversation\GetConversationMessagesAction;
use App\Actions\Conversation\ListConversationsAction;
use App\Actions\Conversation\SendMessageAction;
use App\Actions\User\ResolveCurrentUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListConversationsRequest;
use App\Http\Requests\Api\SendMessageRequest;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ConversationController extends Controller
{
    public function __construct(
        private readonly ResolveCurrentUserAction $resolveCurrentUser,
        private readonly ListConversationsAction $listConversations,
        private readonly GetConversationMessagesAction $getConversationMessages,
        private readonly SendMessageAction $sendMessage,
    ) {
    }

    public function index(ListConversationsRequest $request): AnonymousResourceCollection
    {
        $user = ($this->resolveCurrentUser)($request->user());
        $request->attributes->set('current_user_id', $user->id);
        $conversations = ($this->listConversations)($user, $request->validated());

        return ConversationResource::collection($conversations);
    }

    public function messages(Request $request, int $conversation): AnonymousResourceCollection
    {
        $user = ($this->resolveCurrentUser)($request->user());
        $messages = ($this->getConversationMessages)($user, $conversation);

        abort_if($messages === null, 404);

        return MessageResource::collection($messages);
    }

    public function send(SendMessageRequest $request, int $conversation): MessageResource
    {
        $user = ($this->resolveCurrentUser)($request->user());
        $message = ($this->sendMessage)($user, $conversation, $request->validated('body'));

        abort_if(! $message, 404);

        return new MessageResource($message);
    }
}
