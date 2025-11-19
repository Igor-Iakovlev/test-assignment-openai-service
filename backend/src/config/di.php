<?php

use backend\controller\ChatCompletionController;
use backend\service\ChatCompletionsService;
use DI\ContainerBuilder;
use OpenAI\Client;
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
]);
return $containerBuilder->build();
