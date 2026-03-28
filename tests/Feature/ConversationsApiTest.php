<?php

use App\Models\Conversation;

it('lists conversations and their last message summary', function (): void {
    $this->getJson('/api/conversations')
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'counterparty', 'last_message_at', 'last_message'],
            ],
            'links',
            'meta',
        ]);
});

it('returns messages for a conversation', function (): void {
    $conversation = Conversation::query()->firstOrFail();

    $this->getJson('/api/conversations/'.$conversation->id.'/messages')
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'body', 'sent_at', 'sender'],
            ],
        ]);
});

it('sends a new message to a conversation', function (): void {
    $conversation = Conversation::query()->firstOrFail();

    $this->postJson('/api/conversations/'.$conversation->id.'/messages', [
        'body' => 'This is a test message from Pest.',
    ])
        ->assertCreated()
        ->assertJsonPath('data.body', 'This is a test message from Pest.');
});
