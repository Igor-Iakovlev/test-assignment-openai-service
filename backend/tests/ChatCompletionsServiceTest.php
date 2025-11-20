<?php

namespace backend\tests\Service;

use backend\service\ChatCompletionsService;
use Monolog\Logger;
use OpenAI\Responses\Chat\CreateResponse;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RuntimeException;
use OpenAI\Testing\ClientFake;

class ChatCompletionsServiceTest extends TestCase
{
    private LoggerInterface $logger;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logger = $this->createMock(Logger::class);
    }

    public function testCreateChatCompletionSuccess(): void
    {
        $messages = [['role' => 'user', 'content' => 'Hello']];
        $fakeData = [
            'choices' => [
                [
                    'index' => 0,
                    'message' => ['role' => 'assistant', 'content' => 'Hi!'],
                    'finish_reason' => 'stop'
                ]
            ],
            'usage' => [
                'prompt_tokens' => 10,
                'completion_tokens' => 20,
                'total_tokens' => 30
            ]
        ];

        $mockResponse = CreateResponse::fake($fakeData);
        $client = new ClientFake([$mockResponse]);
        $service = new ChatCompletionsService($client, $this->logger);

        $result = $service->createChatCompletion($messages);
        $this->assertEquals(10, $result->usage->promptTokens);
        $this->assertEquals('Hi!', $result->choices[0]->message->content);
    }

    public function testCreateChatCompletionThrowsExceptionOnInvalidResponse(): void
    {
        $messages = [['role' => 'user', 'content' => 'Hello']];

        $fakeData = [
            'choices' => [
                [
                    'index' => 0,
                    'message' => ['role' => 'assistant', 'content' => ''],
                    'finish_reason' => 'stop'
                ]
            ],
            'usage' => [
                'prompt_tokens' => 0,
                'completion_tokens' => 0,
                'total_tokens' => 0
            ]
        ];
        $mockResponse = CreateResponse::fake($fakeData);
        $client = new ClientFake([$mockResponse]);
        $service = new ChatCompletionsService($client, $this->logger);

        $this->expectException(RuntimeException::class);
        $service->createChatCompletion($messages);
    }
}
