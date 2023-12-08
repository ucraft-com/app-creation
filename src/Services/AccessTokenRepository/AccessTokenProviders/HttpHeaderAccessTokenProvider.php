<?php

declare(strict_types=1);

namespace App\Services\AccessTokenRepository\AccessTokenProviders;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class HttpHeaderAccessTokenProvider defines methods for retrieving Access-Token through the HTTP headers.
 *
 * @package App\Services\SsoGateway\AccessTokenRepository\AccessTokenProviders
 */
class HttpHeaderAccessTokenProvider implements AccessTokenProviderInterface
{
    /**
     * Fetch Access Token from request headers.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return string|null
     */
    public function fetchAccessTokenFromRequest(Request $request): ?string
    {
        $headers = $request->headers;
        return $this->getHeaders($headers);
    }

    /**
     * Get Access Token from Authorization header.
     *
     * @param \Symfony\Component\HttpFoundation\HeaderBag $headers
     *
     * @return string|null
     */
    private function getHeaders($headers): ?string
    {
        if ($headers->has('Authorization')) {
            $header = $headers->get('Authorization');

            if (str_starts_with($header, 'Bearer ')) {
                return str_replace('Bearer ', '', $header);
            }
        }

        return null;
    }
}
