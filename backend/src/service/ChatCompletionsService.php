<?php

namespace backend\service;

use OpenAI\Client;
use OpenAI\Responses\Chat\CreateResponse;

class ChatCompletionsService
{
    public function __construct(private Client $client) {}

    public function createChatCompletion($messages, $model = 'gpt-4o-mini'): CreateResponse
    {
        return $this->client->chat()->create([
            'model' => $model,
            'messages' => $messages,
        ]);
    }
}
