<?php

declare(strict_types=1);

namespace App\Services\HttpCaller;

use Fig\Http\Message\StatusCodeInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * HTTP Client service for managing HTTP API calls
 *
 * @package App\Services\HttpCaller
 *
 * @method ResponseInterface get(string $uri, array $options = [])
 * @method ResponseInterface head(string $uri, array $options = [])
 * @method ResponseInterface put(string $uri, array $options = [])
 * @method ResponseInterface post(string $uri, array $options = [])
 * @method ResponseInterface patch(string $uri, array $options = [])
 * @method ResponseInterface delete(string $uri, array $options = [])
 */
class HttpCaller implements MakesHttpRequest
{
    /**
     * Available HTTP methods
     *
     * @var array
     */
    protected array $availableMethods = [
        'get',
        'post',
        'put',
        'patch',
        'delete',
        'head'
    ];

    /**
     * Instance of GuzzleHttp\Client
     *
     * @var \GuzzleHttp\Client
     */
    protected Client $client;

    /**
     * Initialize GuzzleHttp\Client instance
     *
     * @param array $config
     *
     * @return \App\Services\HttpCaller\MakesHttpRequest
     */
    public function init(array $config = []): MakesHttpRequest
    {
        //var_dump($config);die;
        $this->client = new Client($config);
        return $this;
    }

    public function getHttpClient(): ?Client
    {
        return $this->client ?? null;
    }

    /**
     * Magic method for making available HTTP calls
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return ResponseInterface
     *
     * @throws InvalidArgumentException
     */
    public function __call(string $name, array $arguments): ResponseInterface
    {
        //var_dump($name, $arguments, $this->client);die;
        if (count($arguments) < 1) {
            throw new InvalidArgumentException('Magic request methods require a URI and optional options array');
        }

        $name = strtolower($name);

        if (!in_array($name, $this->availableMethods, true)) {
            throw new InvalidArgumentException('HTTP method call does not implemented.');
        }

        try {
            $response = call_user_func_array([$this->client, $name], $arguments);
        } catch (ClientException $ex) {
            $response = new Response($ex->getResponse()->getStatusCode(), [], $ex->getResponse()->getReasonPhrase());
        } catch (Throwable $ex) {
            $response = new Response(StatusCodeInterface::STATUS_SERVICE_UNAVAILABLE, [], $ex->getMessage());
        }

        return $response;
    }

    /**
     * Creates CookieJar object with particular parameters
     *
     * @param array  $cookies
     * @param string $domain
     *
     * @return CookieJar
     */
    public static function createCookieJar(array $cookies, string $domain): CookieJar
    {
        return CookieJar::fromArray($cookies, $domain);
    }

    /**
     * Executes particular method with particular arguments
     *
     * @param string $method
     * @param string $url
     * @param array  $options [optional]
     *
     * @return ResponseInterface
     */
    public function exec(string $method, string $url, array $options = []): ResponseInterface
    {
        return $this->$method($url, $options);
    }
}
