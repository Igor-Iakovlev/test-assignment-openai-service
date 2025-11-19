<?php

use backend\controller\ChatCompletionController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add(
    'create-chat-completion',
    (new Route(
        '/api/create-chat-completion',
        ['_controller' => [ChatCompletionController::class, 'createChatCompletion']],
    ))
);

return $routes;
