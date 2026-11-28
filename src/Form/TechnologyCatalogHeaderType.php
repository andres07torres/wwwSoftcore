<?php

namespace App\Form;

use App\Entity\TechnologyPageConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnologyCatalogHeaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('catalogEyebrow', TextType::class, [
                'label' => 'Etiqueta superior',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('catalogTitle', TextType::class, [
                'label' => 'Título de la sección',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('catalogSubtitle', TextareaType::class, [
                'label' => 'Subtítulo',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 2],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TechnologyPageConfig::class,
        ]);
    }
}
