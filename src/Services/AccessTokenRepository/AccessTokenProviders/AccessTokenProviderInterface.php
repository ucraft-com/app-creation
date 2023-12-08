<?php

declare(strict_types=1);

namespace App\Services\AccessTokenRepository\AccessTokenProviders;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface AccessTokenProviderInterface declares methods for Access-Token retrieval.
 *
 * @package App\Services\SsoGateway\AccessTokenRepository\AccessTokenProviders
 */
interface AccessTokenProviderInterface
{
    /**
     * Try to fetch Access-Token from given request.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return string|null
     */
    public function fetchAccessTokenFromRequest(Request $request): ?string;
}
