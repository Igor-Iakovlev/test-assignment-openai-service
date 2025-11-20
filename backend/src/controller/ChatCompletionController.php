<?php

namespace backend\controller;

use backend\dto\ChatCompletionResult;
use backend\dto\TokensUsage;
use backend\service\ChatCompletionsService;
use Symfony\Component\HttpFoundation\Response;

readonly class ChatCompletionController
{
    public function __construct(private ChatCompletionsService $service) {}

    /**
     * @param string[] $messages
     * @param string $model
     * @return Response
     */
    public function createChatCompletion(array $messages, string $model = 'gpt-4o-mini'): Response
    {
        $result = $this->service->createChatCompletion($messages, $model);

        $tokensUsage = new TokensUsage(
            $result->usage->promptTokens,
            $result->usage->completionTokens,
            $result->usage->totalTokens,
        );
        $chatCompletion = new ChatCompletionResult(
            $result->choices[0]->message->content,
            $tokensUsage,
        );

        $response = new Response(json_encode($chatCompletion), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
