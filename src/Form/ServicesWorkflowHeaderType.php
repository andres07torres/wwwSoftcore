<?php

namespace App\Form;

use App\Entity\ServicesPageConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ServicesWorkflowHeaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('workflowEyebrow', TextType::class, [
                'label' => 'Etiqueta superior',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('workflowTitle', TextType::class, [
                'label' => 'Título de la sección',
                'attr' => ['class' => 'form-control sc-form-control'],
            ])
            ->add('workflowSubtitle', TextareaType::class, [
                'label' => 'Subtítulo descriptivo',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 2],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => ServicesPageConfig::class]);
    }
}
