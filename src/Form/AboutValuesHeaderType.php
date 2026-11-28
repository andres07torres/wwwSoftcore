<?php

namespace App\Form;

use App\Entity\AboutPageConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AboutValuesHeaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('valuesEyebrow', TextType::class, [
                'label' => 'Etiqueta superior',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('valuesTitle', TextType::class, [
                'label' => 'Título de la sección',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('valuesSubtitle', TextareaType::class, [
                'label' => 'Subtítulo descriptivo',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 2],
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
