<?php

namespace backend\service;

use backend\exception\OpenAiResponseException;
use OpenAI\Contracts\ClientContract;
use OpenAI\Responses\Chat\CreateResponse;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

class ChatCompletionsService
{
    use LoggerAwareTrait;

    public function __construct(private readonly ClientContract $client, LoggerInterface $logger) {
        $this->setLogger($logger);
    }

    public function createChatCompletion($messages, $model = 'gpt-4o-mini'): CreateResponse
    {
        $result = $this->client->chat()->create([
            'model' => $model,
            'messages' => $messages,
        ]);

        if (
            !$result->usage->promptTokens
            || !$result->usage->completionTokens
            || !$result->usage->totalTokens
            || !$result->choices[0]->message->content
        ) {
            $errorMessage = sprintf(
                "Unable to create chat completion response: missing message and/or tokens info. Model: %s, Messages count: %d, Response: %s",
                $model,
                count($messages),
                json_encode($result)
            );
            throw new OpenAiResponseException($errorMessage);
        }

        return $result;
    }
}
