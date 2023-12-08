<?php

declare(strict_types=1);

namespace App\Services\UserGateway;

use App\Entity\User;
use App\Services\UserGateway\Exceptions\UnauthorizedResponseException;
use App\Services\UserGateway\Gateways\UserGatewayInterface;

class UserProvider
{
    /**
     * Reference on user gateway interface implementation instance.
     *
     * @var \App\Services\UserGateway\Gateways\UserGatewayInterface
     */
    protected UserGatewayInterface $userGateway;

    /**
     * @var \App\Entity\User|null
     */
    protected ?User $user = null;

    /**
     * @param \App\Services\UserGateway\Gateways\UserGatewayInterface $userGateway
     */
    public function __construct(UserGatewayInterface $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    /**
     * @return \App\Entity\User|null
     * @throws UnauthorizedResponseException
     */
    public function getUser(): ?User
    {
        if (!$this->user) {
            $this->user = $this->userGateway->getUser();
        }
        return $this->user;
    }
}
