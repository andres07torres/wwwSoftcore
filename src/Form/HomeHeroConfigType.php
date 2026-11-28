<?php

namespace App\Form;

use App\Entity\HomeHeroConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class HomeHeroConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titlePrefix', TextType::class, [
                'label' => 'Título principal (parte inicial)',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'placeholder' => 'Arquitectura de software a medida que',
                ],
            ])
            ->add('titleHighlight', TextType::class, [
                'label' => 'Texto destacado (con degradado)',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'placeholder' => 'escala con tu negocio',
                ],
            ])
            ->add('subtitle', TextareaType::class, [
                'label' => 'Subtítulo descriptivo',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'rows' => 3,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HomeHeroConfig::class,
        ]);
    }
}
