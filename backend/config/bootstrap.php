<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Create a new DI\ContainerBuilder instance and configure it with the container settings.
 *
 * @var ContainerBuilder<DI\Container> $containerBuilder The container builder instance.
 * @var ContainerInterface $container The built container instance.
 */
$containerBuilder = new ContainerBuilder();
/** @var callable $containerConfig */
$containerConfig = require __DIR__ . '/../config/container.php';
$containerConfig($containerBuilder);
$container = $containerBuilder->build();

/**
 * Initialize the Eloquent ORM Capsule manager and configure the database connection.\
 *
 * @var Manager $capsule The Eloquent ORM Capsule manager instance.
 */
$capsule = $container->get('db');

/**
 * Instantiate App
 *
 * In order for the factory to work you need to ensure you have installed
 * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported
 * ServerRequest creator (included with Slim PSR-7)
 */
$app = Bridge::create($container);

/**
 * Register middleware
 *
 * @var callable $middlewareConfig
 */
$middlewareConfig = require __DIR__ . '/../config/middleware.php';
$middlewareConfig($app, $container->get(LoggerInterface::class));

/**
 * Register routes
 *
 * @var callable $routesConfig
 */
$routesConfig = require __DIR__ . '/../config/routes.php';
$routesConfig($app);
// Run app
$app->run();
