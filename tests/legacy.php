#!/usr/bin/env php
<?php

namespace Against\Psr\Hacks;

use Zend\Stratigility\MiddlewarePipe;
use Zend\Stratigility\NoopFinalHandler;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

require __DIR__ . '/../vendor/autoload.php';

$app = new MiddlewarePipe();

$app->pipe(new ContentNegotiationMiddleware());

$app->pipe('/', function ($req, $res, $next) {
    if ($res->getHeaderLine('Content-Type') === 'application/json') {
        $res->getBody()->write(json_encode(['message' => 'Hello world']));
    } else {
        $res->getBody()->write('Hello world!');
    }

    return $res;
});


// _test_

$request = (new ServerRequest())->withHeader('Accept', 'application/json');
$response = $app($request, new Response(), new NoopFinalHandler());
$responseBody = (string) $response->getBody();

echo $responseBody.PHP_EOL;
exit($responseBody === '{"message":"Hello world"}' ? 0 : 1);
