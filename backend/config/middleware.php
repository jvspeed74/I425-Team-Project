<?php

declare(strict_types=1);

use Psr\Log\LoggerInterface;
use Slim\App;

return function (App $app, LoggerInterface $logger): void {
    /**
     * The routing middleware should be added earlier than the ErrorMiddleware
     * Otherwise exceptions thrown from it will not be handled by the middleware
     */
    $app->addRoutingMiddleware();

    $app->addBodyParsingMiddleware();

    /**
     * Add Error Middleware
     *
     * @param bool $displayErrorDetails -> Should be set to false in production
     * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
     * @param bool $logErrorDetails -> Display error details in error log
     * @param LoggerInterface|null $logger -> Optional PSR-3 Logger
     *
     * Note: This middleware should be added last. It will not handle any exceptions/errors
     * for middleware added after it.
     */
    $app->addErrorMiddleware(true, true, true, $logger);
};
