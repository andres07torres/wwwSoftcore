<?php

namespace App\Form;

use App\Entity\AboutPageConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AboutPurposeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('purposeEyebrow', TextType::class, [
                'label' => 'Etiqueta superior',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('purposeTitle', TextType::class, [
                'label' => 'Título de la sección',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('purposeSubtitle', TextareaType::class, [
                'label' => 'Subtítulo descriptivo',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 2],
            ])
            ->add('missionBadge', TextType::class, [
                'label' => 'Etiqueta de Misión',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('missionTitle', TextType::class, [
                'label' => 'Título de Misión',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('missionDescription', TextareaType::class, [
                'label' => 'Descripción de Misión',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 3],
            ])
            ->add('visionBadge', TextType::class, [
                'label' => 'Etiqueta de Visión',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('visionTitle', TextType::class, [
                'label' => 'Título de Visión',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('visionDescription', TextareaType::class, [
                'label' => 'Descripción de Visión',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 3],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AboutPageConfig::class,
        ]);
    }
}
