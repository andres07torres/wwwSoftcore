<?php

namespace App\Form;

use App\Entity\MethodologyPhase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class MethodologyPhaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('phaseBadge', TextType::class, [
                'label' => 'Etiqueta de fase',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'FASE 01'],
            ])
            ->add('duration', TextType::class, [
                'label' => 'Duración / Cadencia',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Semana 1 - 2'],
            ])
            ->add('title', TextType::class, [
                'label' => 'Título de la fase',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. Descubrimiento & Diagnóstico Estratégico'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 3],
            ])
            ->add('deliverable', TextType::class, [
                'label' => 'Entregable',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. Documento de Arquitectura (SAD) y backlog priorizado'],
            ])
            ->add('sortOrder', IntegerType::class, [
                'label' => 'Orden',
                'attr' => ['class' => 'form-control sc-form-control', 'min' => 0],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Mostrar en la página pública',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => MethodologyPhase::class]);
    }
}
