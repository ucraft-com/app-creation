<?php

declare(strict_types=1);

namespace App\Services\UserGateway\Gateways;

use App\Entity\User;
use App\Services\UserGateway\Exceptions\UnauthorizedResponseException;

/**
 * Interface UserAndSiteGatewayInterface.
 * The UserGateway interface declares method for getting logged-in user.
 *
 * @package App\Services\SsoGatewayFactory\Gateways
 */
interface UserGatewayInterface
{
    /**
     * Get logged in user.
     *
     * @return \App\Entity\User|null
     * @throws UnauthorizedResponseException
     */
    public function getUser(): ?User;
}
