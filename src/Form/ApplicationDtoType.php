<?php
// src/Form/ApplicationDtoType.php

namespace App\Form;

use App\Dto\ApplicationDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationDtoType extends AbstractType
{
    /**
     * Build the form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('type', TextType::class)
            ->add('status', TextType::class)
            ->add('alias', TextType::class)
            ->add('description', TextType::class)
            ->add('logo', TextType::class);
    }

    /**
     * Configure options for the form.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApplicationDto::class,
        ]);
    }
}
