<?php

namespace App\Form;

use App\Entity\MethodologyPageConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class MethodologyHeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('heroTitlePrefix', TextType::class, [
                'label' => 'Título (parte inicial)',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('heroTitleHighlight', TextType::class, [
                'label' => 'Texto destacado (degradado)',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('heroTitleSuffix', TextType::class, [
                'label' => 'Título (parte final)',
                'required' => false,
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('heroSubtitle', TextareaType::class, [
                'label' => 'Descripción principal',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 3],
            ])
            ->add('heroFlowNote', TextType::class, [
                'label' => 'Nota inferior del flujo',
                'required' => false,
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('pipelineLabel', TextType::class, [
                'label' => 'Etiqueta del panel pipeline',
                'required' => false,
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => MethodologyPageConfig::class]);
    }
}
