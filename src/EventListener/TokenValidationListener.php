<?php

namespace App\EventListener;

use App\Services\UserGateway\UserProvider;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpFoundation\Response;
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
     *
     * @return \Symfony\Component\HttpFoundation\Response  // This line provides the return type information
     */
    public function onKernelRequest(RequestEvent $event): Response
    {
        try {
            $this->userProvider->getUser();
        } catch (UnauthorizedResponseException $exception) {
            throw new SymfonyUnauthorizedHttpException('Unauthorized', $exception);
        }

        $ev = $event->getResponse();
        // Check if $event->getResponse() is not null before creating the PSR response
        if ($ev !== null) {
            return  (new HttpFoundationFactory())->createResponse($ev);
        }

        // Handle the case where $event->getResponse() is null (modify as needed)
        return new Response('Null', Response::HTTP_OK);
    }

}
