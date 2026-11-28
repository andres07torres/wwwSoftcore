<?php

namespace App\Form;

use App\Entity\TechnologyPageConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnologyHeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('heroTitlePrefix', TextType::class, [
                'label' => 'Título principal (inicio)',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('heroTitleHighlight', TextType::class, [
                'label' => 'Frase destacada (con degradado)',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('heroSubtitle', TextareaType::class, [
                'label' => 'Descripción del Hero',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 3],
            ])
            ->add('specLabel', TextType::class, [
                'label' => 'Nombre de consola (spec)',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'stack-architecture.spec'],
            ])
            ->add('specStatus', TextType::class, [
                'label' => 'Estado en consola',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'verified'],
            ])
            ->add('stackLayer1Label', TextType::class, [
                'label' => 'Capa 1 — Etiqueta',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('stackLayer1Value', TextType::class, [
                'label' => 'Capa 1 — Tecnologías',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('stackLayer2Label', TextType::class, [
                'label' => 'Capa 2 — Etiqueta',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('stackLayer2Value', TextType::class, [
                'label' => 'Capa 2 — Tecnologías',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('stackLayer3Label', TextType::class, [
                'label' => 'Capa 3 — Etiqueta',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('stackLayer3Value', TextType::class, [
                'label' => 'Capa 3 — Tecnologías',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('stackLayer4Label', TextType::class, [
                'label' => 'Capa 4 — Etiqueta',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('stackLayer4Value', TextType::class, [
                'label' => 'Capa 4 — Tecnologías',
                'attr' => ['class' => 'form-control sc-form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TechnologyPageConfig::class,
        ]);
    }
}
