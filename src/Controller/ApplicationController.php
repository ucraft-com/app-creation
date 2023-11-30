<?php

namespace App\Controller;

use App\Entity\Application;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ApplicationController extends AbstractController
{
    #[Route('/application', name: 'app_application')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApplicationController.php',
        ]);
    }
    #[Route('/application/{id}', name: 'update_application', methods: ['PUT'])]
    public function update(int $id): JsonResponse
    {
        // Fetch the application from the database
       //composer require symfony/validator $application = $this->getDoctrine()->getRepository(Application::class)->find($id);



        return $this->json(['message' => 'Application updated successfully']);
    }

    #[Route('/api/applications', name: 'api_applications_save', methods: ['Post'])]
    public function save(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate and handle the request data
        $name = $data['name'] ?? null;
        $type = $data['type'] ?? null;
        $status = $data['status'] ?? null;
        $alias = $data['alias'] ?? null;
        $description = $data['description'] ?? null;
        $logo = $data['logo'] ?? null;


        // Create a new Application entity
        $application = new Application();
        $application->setName($name);
        $application->setType($type);
        $application->setStatus($status);
        $application->setAlias($alias);
        $application->setDescription($description);
        $application->setLogo($logo);

        $violations = $validator->validate($application);
        // Check for validation errors
        if (count($violations) > 0) {
            $errors = [];
            /** @var \Symfony\Component\Validator\ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }

            return $this->json(['errors' => $errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Persist the entity to the database
        $entityManager->persist($application);
        $entityManager->flush();

        // Return a JSON response with the saved application data
        return $this->json(['message' => 'Application saved successfully', 'data' => $application->toArray()]);
    }
}
