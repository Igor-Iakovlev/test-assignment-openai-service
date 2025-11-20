<?php

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require __DIR__ . '/vendor/autoload.php';

$routes = include __DIR__ . '/src/config/routes.php';

$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routes, $context);

$di = include __DIR__ . '/src/config/di.php';

try {
    $parameters = $matcher->matchRequest($request);
    $controllerClass = $parameters['_controller'][0];
    $methodName = $parameters['_controller'][1];
    $controller = $di->get($controllerClass);

    $content = json_decode($request->getContent(), true);
    $response = call_user_func_array([$controller, $methodName], $content);
    $response->send();
} catch (ResourceNotFoundException $e) {
    $response = new Response('Not Found', Response::HTTP_NOT_FOUND);
    $response->send();
} catch (Exception $e) {
    $di->get(LoggerInterface::class)->critical($e->getMessage(), ['trace' => $e->getTrace()]);
    $response = new Response(sprintf('An error occurred: %s', $e->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
    $response->send();
}
