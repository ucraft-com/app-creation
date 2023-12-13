<?php

declare(strict_types=1);

namespace App\Services\HttpCaller;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface MakesHttpRequest
 *
 * Describes a service for making HTTP requests.
 */
interface MakesHttpRequest
{
    /**
     * Initializes the HTTP caller with configuration options.
     *
     * @param array $config An array of configuration options.
     *
     * @return MakesHttpRequest An instance of the HTTP caller.
     */
    public function init(array $config = []): MakesHttpRequest;

    /**
     * Executes an HTTP request.
     *
     * @param string $method The HTTP method (e.g., GET, POST).
     * @param string $url The URL to send the request to.
     * @param array $options An array of additional options for the request.
     *
     * @return ResponseInterface The response from the HTTP request.
     */
    public function exec(string $method, string $url, array $options = []): ResponseInterface;
}
