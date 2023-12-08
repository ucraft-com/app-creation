<?php

declare(strict_types=1);

namespace App\Services\AccessTokenRepository\AccessTokenProviders;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class CookieAccessTokenProvider defines methods for retrieving Access-Token through the request cookies.
 *
 * @package App\Services\SsoGateway\AccessTokenRepository\AccessTokenProviders
 */
class CookieAccessTokenProvider implements AccessTokenProviderInterface
{
    /**
     * Fetch Access Token from request cookies.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return string|null
     */
    public function fetchAccessTokenFromRequest(Request $request): ?string
    {
        $cookies = $request->cookies->all();

        return $cookies['Authorization'] ?? null;
    }
}
