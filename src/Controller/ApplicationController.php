<?php
// src/Controller/ApplicationController.php

namespace App\Controller;

use App\Services\RequestHandler\ApplicationRequestHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationController extends AbstractController
{
    /**
     * @var ApplicationRequestHandler $requestHandler The request handler service for applications.
     */
    private ApplicationRequestHandler $requestHandler;

    /**
     * Constructor to inject the ApplicationRequestHandler service.
     *
     * @param ApplicationRequestHandler $requestHandler The request handler service for applications.
     */
    public function __construct(ApplicationRequestHandler $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    #[Route('/api/applications', name: 'api_applications_save', methods: ['POST'])]
    public function save(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Handle the application request using the ApplicationRequestHandler
        $result = $this->requestHandler->handleApplicationRequest($request);

        // Check for validation errors
        if (!empty($result['validationErrors'])) {
            return $this->json(['errors' => $result['validationErrors']], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Save the application entity to the database
        $application = $result['application'];
        var_dump($application);die;
        $entityManager->persist($application);
        $entityManager->flush();

        // Return a JSON response with the saved application data
        return $this->json(['message' => 'Application saved successfully', 'data' => $application->toArray()]);
    }
}
