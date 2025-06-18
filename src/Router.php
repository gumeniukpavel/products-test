<?php

namespace App;

use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    public function handle(Request $request): Response
    {
        $dispatcher = \FastRoute\simpleDispatcher(require __DIR__ . '/../routes/api.php');

        $httpMethod = $request->getMethod();
        $uri = rawurldecode($request->getPathInfo());

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                return new Response('Not Found', 404);
            case Dispatcher::METHOD_NOT_ALLOWED:
                return new Response('Method Not Allowed', 405);
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                [$class, $method] = $handler;
                return (new $class)->$method($request, $vars);
        }
    }
}