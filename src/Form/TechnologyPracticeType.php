<?php

namespace App\Form;

use App\Entity\TechnologyPractice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnologyPracticeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stepNumber', TextType::class, [
                'label' => 'Número',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => '01'],
            ])
            ->add('title', TextType::class, [
                'label' => 'Título',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. Arquitectura Hexagonal & DDD'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 3],
            ])
            ->add('sortOrder', IntegerType::class, [
                'label' => 'Orden',
                'attr' => ['class' => 'form-control sc-form-control', 'min' => 0],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Visible en la página pública',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TechnologyPractice::class,
        ]);
    }
}
