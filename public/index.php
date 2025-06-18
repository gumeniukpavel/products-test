<?php

require_once __DIR__ . '/../vendor/autoload.php';

use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Request;
use App\Router;

if (!function_exists('dd')) {
    #[NoReturn] function dd(mixed ...$vars): void
    {
        foreach ($vars as $var) {
            echo "<pre>";
            var_dump($var);
            echo "</pre>";
        }
        die(1);
    }
}

$request = Request::createFromGlobals();
$response = (new Router())->handle($request);
$response->send();