<?php

declare(strict_types=1);

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder): void {
    // Global container configuration
    $containerBuilder->useAttributes(true); // Allows DI with Interfaces using #[Inject] attribute
    $containerBuilder->useAutowiring(true); // Enabled by default

    // Add services to the container
    $definitions = (array) require __DIR__ . '/dependencies.php';

    $containerBuilder->addDefinitions($definitions);
};
