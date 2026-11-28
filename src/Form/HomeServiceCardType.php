<?php

namespace App\Form;

use App\Entity\HomeServiceCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class HomeServiceCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('iconKey', ChoiceType::class, [
                'label' => 'Ícono',
                'choices' => HomeServiceCard::ICONS,
                'attr' => [
                    'class' => 'form-select sc-form-control',
                ],
            ])
            ->add('title', TextType::class, [
                'label' => 'Título del servicio',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'placeholder' => 'Ej. Desarrollo Web & Móvil',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'rows' => 3,
                ],
            ])
            ->add('linkText', TextType::class, [
                'label' => 'Texto del enlace',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'placeholder' => 'Ver detalles del servicio',
                ],
            ])
            ->add('linkUrl', TextType::class, [
                'label' => 'Enlace de destino',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'placeholder' => '/servicios',
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
            'data_class' => HomeServiceCard::class,
        ]);
    }
}
