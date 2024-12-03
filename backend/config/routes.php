<?php

declare(strict_types=1);

use App\Middleware\AuthMiddleware;
use App\Controllers\{CarController, DriverController, EventController, TeamController, TrackController, UserController};
use App\Middleware\JWTAuthMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/**
 * Register application routes.
 *
 * @param App $app The Slim application instance.
 *
 * @return void
 */
return function (App $app): void {
    // Greet route
    $app->get('/hello/{name}', function (Response $response, string $name) {
        $response->getBody()->write("Hello, $name");
        return $response;
    });

    // Team routes
    $app->group('/teams', function (RouteCollectorProxy $group) {
        $group->get('', TeamController::class . ':getAll');
        $group->get('/{id:\d+}', TeamController::class . ':getById');
        $group->post('', TeamController::class . ':create');
        $group->patch('/{id:\d+}', TeamController::class . ':update');
        $group->delete('/{id:\d+}', TeamController::class . ':delete');
    })->add(AuthMiddleware::class);

    // Event routes
    $app->group('/events', function (RouteCollectorProxy $group) {
        $group->get('', EventController::class . ':getAll');
        $group->get('/{id:\d+}', EventController::class . ':getById');
        $group->post('', EventController::class . ':create');
        $group->patch('/{id:\d+}', EventController::class . ':update');
        $group->delete('/{id:\d+}', EventController::class . ':delete');
    });  // TODO Enable JWT middleware

    // Track routes
    $app->group('/tracks', function (RouteCollectorProxy $group) {
        $group->get('', TrackController::class . ':getAllWithParams');
        $group->get('/{id:\d+}', TrackController::class . ':getById');
        $group->post('', TrackController::class . ':create');
        $group->patch('/{id:\d+}', TrackController::class . ':update');
        $group->delete('/{id:\d+}', TrackController::class . ':delete');
    });

    // Driver routes
    $app->group('/drivers', function (RouteCollectorProxy $group) {
        $group->get('', DriverController::class . ':getAll');
        $group->get('/{id:\d+}', DriverController::class . ':getById');
        $group->post('', DriverController::class . ':create');
        $group->patch('/{id:\d+}', DriverController::class . ':update');
        $group->delete('/{id:\d+}', DriverController::class . ':delete');
        $group->get('/search', DriverController::class . ':search');
    });

    // Car routes
    $app->group('/cars', function (RouteCollectorProxy $group) {
        $group->get('', CarController::class . ':getAll');
        $group->get('/{id:\d+}', CarController::class . ':getById');
        $group->post('', CarController::class . ':create');
        $group->patch('/{id:\d+}', CarController::class . ':update');
        $group->delete('/{id:\d+}', CarController::class . ':delete');
    });

    // User routes
    $app->group('/users', function (RouteCollectorProxy $group) {
        $group->post('/authJWT', UserController::class . ':signin');
    });  // TODO Add test or something IDC
};
