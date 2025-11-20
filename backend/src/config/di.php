<?php

use backend\controller\ChatCompletionController;
use backend\service\ChatCompletionsService;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use OpenAI\Client;
use Psr\Log\LoggerInterface;
use function DI\autowire;
use function DI\create;
use function DI\get;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    Client::class => function() {
        return OpenAI::factory()
            ->withApiKey(getenv('OPENAI_API_KEY'))
            ->make();
    },
    ChatCompletionsService::class => create(ChatCompletionsService::class)
        ->constructor(get(Client::class)),
    ChatCompletionController::class => autowire(ChatCompletionController::class),
    LoggerInterface::class => function() {
        $logger = new Logger('openai_api');
        $handler = new StreamHandler('php://stdout', Level::Debug);
        $logger->pushHandler($handler);
        return $logger;
    }
]);

try {
    return $containerBuilder->build();
} catch (Exception $e) {
    error_log("DI container build failed: " . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());
    throw new Error("DI container build failed: " . $e->getMessage());
}
