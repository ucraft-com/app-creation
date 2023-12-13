<?php

namespace App\Controller;

use App\Services\RequestHandler\ApplicationRequestHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class ApplicationController extends AbstractController
{
    private ApplicationRequestHandler $requestHandler;

    public function __construct(ApplicationRequestHandler $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    #[Route('/api/applications', name: 'api_applications_save', methods: ['POST'])]
    public function save(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            // Handle the application request using the ApplicationRequestHandler
            $result = $this->requestHandler->handleApplicationRequest($request);

            // Check for validation errors
            if (!empty($result['validationErrors'])) {
                return $this->json(['errors' => $result['validationErrors']], Response::HTTP_BAD_REQUEST);
            }

            // Save the application entity to the database
            $application = $result['application'];
            $entityManager->persist($application);
            $entityManager->flush();

            // Return a JSON response with the saved application data
            return $this->json(['message' => 'Application saved successfully', 'data' => $application->toArray()]);

        } catch (UniqueConstraintViolationException) {
            // Handle the duplicate entry violation
            return $this->json(['error' => 'Duplicate entry for application name'], Response::HTTP_CONFLICT);
        } catch (\Exception) {
            // Handle other exceptions
            return $this->json(['error' => 'Handle other exceptions'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
