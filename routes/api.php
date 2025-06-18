<?php

use App\Controller\ProductController;

return function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/products', [ProductController::class, 'index']);
    $r->addRoute('POST', '/products', [ProductController::class, 'store']);
    $r->addRoute('GET', '/products/{id}', [ProductController::class, 'show']);
    $r->addRoute('PATCH', '/products/{id}', [ProductController::class, 'update']);
    $r->addRoute('DELETE', '/products/{id}', [ProductController::class, 'delete']);
};