<?php

namespace App\Services\RequestHandler;

use App\Entity\Application;
use App\Dto\ApplicationDto;
use App\Form\ApplicationDtoType;
use App\Traits\EntityPropertyTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApplicationRequestHandler extends RequestHandler
{
    use EntityPropertyTrait;

    private FormFactoryInterface $formFactory;

    /**
     * Constructor to inject the FormFactoryInterface service and ValidatorInterface service.
     *
     * @param FormFactoryInterface $formFactory The Symfony form factory service.
     * @param ValidatorInterface $validator The Symfony validator service.
     */
    public function __construct(FormFactoryInterface $formFactory, ValidatorInterface $validator)
    {
        parent::__construct($validator);
        $this->formFactory = $formFactory;
    }

    /**
     * Handles the application request, validates the data, and maps it to an entity.
     *
     * @param Request $request The Symfony request object.
     *
     * @return array An associative array containing the DTO, application entity, and validation errors.
     */
    public function handleApplicationRequest(Request $request): array
    {
        $data = json_decode($request->getContent(), true);
        $dto = new ApplicationDto();
        $this->setPropertiesFromObj($dto, $data);
//var_dump($dto);die;
        $form = $this->formFactory->create(ApplicationDtoType::class, $dto);

        // Check if the form is not valid and collect validation errors
        if ($form->isSubmitted() && $form->isValid()) {
            $validationErrors = $this->getValidationErrors($form);
die("aaa");
            return ['dto' => $dto, 'validationErrors' => $validationErrors];
        }

        // Map the DTO to an Application entity
        $application = $this->mapDtoToEntity($dto);

        // Return an array containing the application entity and an empty array for validation errors
        return ['application' => $application, 'validationErrors' => []];
    }

    /**
     * Extracts validation errors from a Symfony form.
     *
     * @param \Symfony\Component\Form\FormInterface $form The Symfony form.
     *
     * @return array An associative array of validation errors.
     */
    private function getValidationErrors(\Symfony\Component\Form\FormInterface $form): array
    {
        $validationErrors = [];
        foreach ($form->getErrors(true, true) as $error) {
            $validationErrors[$error->getOrigin()->getName()] = $error->getMessage();
        }

        return $validationErrors;
    }

    /**
     * Map an ApplicationDto to an Application entity.
     *
     * @param ApplicationDto $dto The data transfer object.
     *
     * @return Application The mapped Application entity.
     */
    private function mapDtoToEntity(ApplicationDto $dto): Application
    {
        // Create a new Application entity and set its properties from the DTO
        $application = new Application();
        $this->setPropertiesFromObj($application, $dto->getProperties());
var_dump($application);

        return $application;
    }
}
