<?php

namespace App\Form;

use App\Entity\ServicesPageConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ServicesContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contactTitle', TextType::class, [
                'label' => 'Título principal del bloque',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('contactSubtitle', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 2],
            ])
            ->add('contactBenefit1', TextType::class, [
                'label' => 'Beneficio 1',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('contactBenefit2', TextType::class, [
                'label' => 'Beneficio 2',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('contactBenefit3', TextType::class, [
                'label' => 'Beneficio 3',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('contactWhatsappUrl', TextType::class, [
                'label' => 'Enlace de WhatsApp',
                'help' => 'Ingresa solo tu enlace (ej. https://wa.me/593999999999). El mensaje "Hola SoftCorec, quiero una consultoría" se agrega automáticamente.',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'placeholder' => 'https://wa.me/593999999999',
                ],
            ])
            ->add('contactFormTitle', TextType::class, [
                'label' => 'Título de la tarjeta del formulario',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('contactFormSubtitle', TextType::class, [
                'label' => 'Subtítulo de la tarjeta del formulario',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => ServicesPageConfig::class]);
    }
}
