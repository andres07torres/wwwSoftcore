<?php

namespace App\Form;

use App\Entity\HomeMethodologyStep;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class HomeMethodologyStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stepNumber', TextType::class, [
                'label' => 'Número de paso',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'placeholder' => '01',
                ],
            ])
            ->add('title', TextType::class, [
                'label' => 'Título del paso',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'placeholder' => 'Ej. Diagnóstico & Estrategia',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'rows' => 3,
                ],
            ])
            ->add('sortOrder', IntegerType::class, [
                'label' => 'Orden de aparición',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'min' => 0,
                ],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Mostrar en la portada pública',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HomeMethodologyStep::class,
        ]);
    }
}
