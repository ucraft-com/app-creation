<?php

declare(strict_types=1);

namespace App\Services\UserGateway\Gateways;

use App\Entity\User;
use App\Services\AccessTokenRepository\AccessTokenRepository;
use App\Services\HttpCaller\MakesHttpRequest;
use App\Services\UserGateway\Exceptions\BadGatewayException;
use App\Services\UserGateway\Exceptions\UnauthorizedResponseException;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class SsoUserGateway implements UserGatewayInterface
{
    /**
     * @var MakesHttpRequest
     */
    protected MakesHttpRequest $client;

    /**
     * @var AccessTokenRepository
     */
    protected AccessTokenRepository $tokenRepository;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var CacheItemPoolInterface
     * @see FilesystemAdapter
     */
    protected CacheItemPoolInterface $cache;

    /**
     * @param MakesHttpRequest $caller
     * @param AccessTokenRepository $tokenRepository
     * @param CacheItemPoolInterface $cache
     * @param LoggerInterface $logger
     * @param array $options
     */
    public function __construct(
        MakesHttpRequest $caller,
        AccessTokenRepository $tokenRepository,
        CacheItemPoolInterface $cache,
        LoggerInterface $logger,
        array $options
    ) {
        $this->client = $caller->init([
            'base_uri'        => $options['ssoApiUrl'],
            'connect_timeout' => 5,
            'timeout'         => 5,
            'allow_redirects' => true,
            'return_transfer' => true,
            'synchronous'     => true,
            'headers'         => [
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer '.$tokenRepository->getAccessToken(),
                'X-CLIENT-NAME' => $options['clientNameHeader'],
            ],
        ]);

        $this->tokenRepository = $tokenRepository;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    /**
     * @return User|null
     * @throws BadGatewayException
     * @throws UnauthorizedResponseException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getUser(): ?User
    {
        $accessToken = $this->tokenRepository->getAccessToken();
        if (null === $accessToken) {
            return null;
        }

        $item = $this->cache->getItem($accessToken);
        if (!$item->isHit()) {
            $response = $this->validateResponse(
                $this->ssoRequest('user')
            );

            $user = $this->createUserFromSsoResponse($response['data']);
            $item->set($user);
            $this->cache->save($item);
            return $user;
        }

        return $item->get();
    }

    /**
     * @param array $data
     * @return User
     */
    protected function createUserFromSsoResponse(array $data): User
    {
        $user = new User();

        $user->setId($data['id']);
        $user->setFirstName((string)$data['firstName']);
        $user->setLastName((string)$data['lastName']);
        $user->setEmail($data['email']);
        $user->setEmailVerifiedAt((string)$data['emailVerifiedAt']);

        return $user;
    }

    /**
     * Make http call to accounts.
     *
     * @param string $uri
     * @param string $method
     * @param array $options
     * @return ResponseInterface
     */
    protected function ssoRequest(string $uri, string $method = 'get', array $options = []): ResponseInterface
    {
        $this->logger->info('ssoRequest called with arguments', [
            'uri' => $uri,
            'method' => $method,
            'options' => $options,
        ]);

        return $this->client->exec($method, $uri, $options);
    }

    /**
     * Validate remote SSO response.
     *
     * @param ResponseInterface $response
     * @return array
     * @throws BadGatewayException
     * @throws UnauthorizedResponseException
     */
    protected function validateResponse(ResponseInterface $response): array
    {
        if ($response->getStatusCode() === StatusCodeInterface::STATUS_OK) {
            return json_decode((string)$response->getBody(), true);
        }

        if ($response->getStatusCode() === StatusCodeInterface::STATUS_UNAUTHORIZED) {
            throw new UnauthorizedResponseException(
                'Unauthorized',
                StatusCodeInterface::STATUS_UNAUTHORIZED
            );
        }

        throw new BadGatewayException(
            'Bad gateway',
            StatusCodeInterface::STATUS_BAD_GATEWAY
        );
    }
}
