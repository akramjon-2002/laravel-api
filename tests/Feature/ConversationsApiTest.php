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

it('returns validation errors for invalid message payload', function (): void {
    $conversation = Conversation::query()->firstOrFail();

    $this->postJson('/api/conversations/'.$conversation->id.'/messages', [
        'body' => '',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['body']);
});

it('returns a JSON not found error for missing conversation messages', function (): void {
    $this->getJson('/api/conversations/999999/messages')
        ->assertNotFound()
        ->assertJsonPath('message', 'Conversation not found.');
});

it('returns a JSON not found error when sending to a missing conversation', function (): void {
    $this->postJson('/api/conversations/999999/messages', [
        'body' => 'Message to a missing conversation.',
    ])
        ->assertNotFound()
        ->assertJsonPath('message', 'Conversation not found.');
});

it('returns a bad request error for malformed conversation json', function (): void {
    $this->call(
        'POST',
        '/api/conversations/1/messages',
        [],
        [],
        [],
        [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
        ],
        <<<'JSON'
{
  "body":
}
JSON
    )
        ->assertBadRequest()
        ->assertJsonPath('message', 'Malformed JSON payload.');
});
