<?php

declare(strict_types=1);

use App\Application\Actions\Conway\DeleteCache;
use App\Application\Actions\Conway\RenderBoard;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\Twig;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response, $args) {
        return (Twig::fromRequest($request))->render($response, 'index.html');
    });

    $app->group('/api', function (Group $group) {
        $group->get('/board', RenderBoard::class);
        $group->post('/cache-delete', DeleteCache::class);
    });
};
