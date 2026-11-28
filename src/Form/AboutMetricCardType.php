<?php

namespace App\Form;

use App\Entity\AboutMetricCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AboutMetricCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', TextType::class, [
                'label' => 'Cifra / Valor',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. +50, 99.98%, 100%'],
            ])
            ->add('label', TextType::class, [
                'label' => 'Título de la métrica',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. Proyectos Desplegados'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 2],
            ])
            ->add('sortOrder', IntegerType::class, [
                'label' => 'Orden de aparición',
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
        $resolver->setDefaults([
            'data_class' => AboutMetricCard::class,
        ]);
    }
}
