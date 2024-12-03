<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Enum HTTPStatus
 *
 * This enum represents HTTP status codes.
 * Each case corresponds to a specific HTTP status code.
 */
enum HTTPStatusCode: int
{
    /**
     * The request has succeeded.
     */
    case OK = 200;

    /**
     * The request has been fulfilled and has resulted in one or more new resources being created.
     */
    case CREATED = 201;

    /**
     * The server has successfully fulfilled the request and that there is no additional content to send in the response payload body.
     */
    case NO_CONTENT = 204;

    /**
     * The server cannot or will not process the request due to something that is perceived to be a client error.
     */
    case BAD_REQUEST = 400;

    /**
     * The request has not been applied because it lacks valid authentication credentials for the target resource.
     */
    case UNAUTHORIZED = 401;

    /**
     * The server understood the request but refuses to authorize it.
     */
    case FORBIDDEN = 403;

    /**
     * The origin server did not find a current representation for the target resource or is not willing to disclose that one exists.
     */
    case NOT_FOUND = 404;

    /**
     * The server encountered an unexpected condition that prevented it from fulfilling the request.
     */
    case INTERNAL_SERVER_ERROR = 500;
}
