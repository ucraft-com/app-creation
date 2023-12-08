<?php

declare(strict_types=1);

namespace App\Services\AccessTokenRepository;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Repository for Access-Token retrieval.
 *
 * @package App\Services\SsoGateway\AccessTokenRepository
 */
class AccessTokenRepository
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack|null
     */
    protected ?RequestStack $requestStack;

    /**
     * List of AccessTokenProvider instances.
     *
     * @var \App\Services\AccessTokenRepository\AccessTokenProviders\AccessTokenProviderInterface[]
     */
    protected array $providers;

    /**
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param array                                          $providers
     */
    public function __construct(RequestStack $requestStack, array $providers = [])
    {
        $this->requestStack = $requestStack;
        $this->providers    = $providers;
    }

    /**
     * Retrieve Access-Token through available providers.
     *
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request !== null) {
            foreach ($this->providers as $provider) {
                $token = $provider->fetchAccessTokenFromRequest($request);
                if ($token !== null) {
                    return $token;
                }
            }
        }

        return null;
    }
}
