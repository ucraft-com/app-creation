<?php
// src/Service/RequestHandler/RequestHandler.php

namespace App\Services\RequestHandler;  // Updated namespace to match directory structure

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Abstract class for handling common logic related to request processing.
 */
abstract class RequestHandler
{
    protected ValidatorInterface $validator;

    /**
     * Constructor to inject the Symfony Validator service.
     *
     * @param ValidatorInterface $validator The Symfony Validator service.
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle request data, validate, and extract required fields.
     *
     * @param Request $request       The Symfony Request object.
     * @param array   $requiredFields An array of required fields.
     *
     * @return array The processed request data.
     */
    protected function handleRequestData(Request $request, array $requiredFields): array
    {
        $data = json_decode($request->getContent(), true);

        // Validate and handle the request data
        $requestData = [];
        foreach ($requiredFields as $field) {
            $requestData[$field] = $data[$field] ?? null;
        }

        return $requestData;
    }

    /**
     * Validate an entity and retrieve validation errors.
     *
     * @param object $entity The entity to be validated.
     *
     * @return array Validation errors, if any.
     */
    protected function validateEntity(object $entity): array
    {
        $violations = $this->validator->validate($entity);
        $errors = [];

        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}
