<?php

declare(strict_types=1);

use App\Middleware\AuthMiddleware;
use App\Controllers\{AuthController, CarController, DriverController, EventController, TeamController, TrackController};
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

    // homePage
    $app->get('/', function ($request, $response) {
        ob_start();
        include __DIR__ . '/../public/mainPage.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);
        return $response;
    });

    // teamsPage
    $app->get('/teamsPage', function ($request, $response) {
        ob_start();
        include __DIR__ . '/../public/teamsPage.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);
        return $response;
    });
    // Team routes
    $app->group('/teams', function (RouteCollectorProxy $group) {
        $group->get('', TeamController::class . ':getAll');
        $group->get('/{id:\d+}', TeamController::class . ':getById');
        $group->post('', TeamController::class . ':create');
        $group->patch('/{id:\d+}', TeamController::class . ':update');
        $group->delete('/{id:\d+}', TeamController::class . ':delete');
    });

    // eventsPage
    $app->get('/eventsPage', function ($request, $response) {
        ob_start();
        include __DIR__ . '/../public/eventsPage.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);
        return $response;
    });
    // Event routes
    $app->group('/events', function (RouteCollectorProxy $group) {
        $group->get('', EventController::class . ':getAll');
        $group->get('/{id:\d+}', EventController::class . ':getById');
        $group->post('', EventController::class . ':create');
        $group->patch('/{id:\d+}', EventController::class . ':update');
        $group->delete('/{id:\d+}', EventController::class . ':delete');
    });

    // tracksPage
    $app->get('/tracksPage', function ($request, $response) {
        ob_start();
        include __DIR__ . '/../public/tracksPage.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);
        return $response;
    });
    // Track routes
    $app->group('/tracks', function (RouteCollectorProxy $group) {
        $group->get('', TrackController::class . ':getAllWithParams');
        $group->get('/{id:\d+}', TrackController::class . ':getById');
        $group->post('', TrackController::class . ':create');
        $group->patch('/{id:\d+}', TrackController::class . ':update');
        $group->delete('/{id:\d+}', TrackController::class . ':delete');
    });

    // driversPage
    $app->get('/driversPage', function ($request, $response) {
        ob_start();
        include __DIR__ . '/../public/driversPage.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);
        return $response;
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

    // carsPage
    $app->get('/carsPage', function ($request, $response) {
        ob_start();
        include __DIR__ . '/../public/carsPage.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);
        return $response;
    });
    // Car routes
    $app->group('/cars', function (RouteCollectorProxy $group) {
        $group->get('', CarController::class . ':getAll');
        $group->get('/{id:\d+}', CarController::class . ':getById');
        $group->post('', CarController::class . ':create');
        $group->patch('/{id:\d+}', CarController::class . ':update');
        $group->delete('/{id:\d+}', CarController::class . ':delete');
    });

    // Auth routes TODO need documentation
    $app->group('/auth', function (RouteCollectorProxy $group) {
        $group->post('/login', AuthController::class . ':login');
        $group->post('/register', AuthController::class . ':register');
        $group->post('/revoke', AuthController::class . ':revoke');
    });
};
