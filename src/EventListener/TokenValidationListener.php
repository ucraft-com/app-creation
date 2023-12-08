<?php


namespace App\EventListener;

use App\Services\UserGateway\UserProvider;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use App\Services\UserGateway\Exceptions\UnauthorizedResponseException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException as SymfonyUnauthorizedHttpException;


class TokenValidationListener
{

    /**
     * Reference to the user provider instance.
     *
     * @var \App\Services\UserGateway\UserProvider
     */
    protected UserProvider $userProvider;

    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * Validates the user token on each request.
     *
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     *
     * @throws UnauthorizedHttpException If the user is not authorized
     * @throws SymfonyUnauthorizedHttpException If a Symfony unauthorized exception occurs
     */
    public function onKernelRequest(RequestEvent $event): ResponseInterface
    {
        try {
            $this->userProvider->getUser();
        } catch (UnauthorizedResponseException $exception) {
            throw new SymfonyUnauthorizedHttpException('Unauthorized', $exception);
        }
        die("a");
        $psrResponse = (new HttpFoundationFactory())->createResponse($event->getResponse());
        return $psrResponse;

       // return $event->getResponse();
    }
}



