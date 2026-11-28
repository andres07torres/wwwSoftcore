<?php

namespace App\Form;

use App\Entity\TechnologyDomain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnologyDomainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('iconKey', ChoiceType::class, [
                'label' => 'Icono',
                'choices' => [
                    'Código (Backend / APIs)' => 'code',
                    'Monitor (Frontend Web)' => 'desktop',
                    'Móvil (Android / iOS)' => 'mobile',
                    'Capas (Cloud / DevOps)' => 'layers',
                    'Base de datos (Datos / Caché)' => 'database',
                    'Escudo (QA / Seguridad)' => 'shield',
                ],
                'attr' => ['class' => 'form-select sc-form-control'],
            ])
            ->add('title', TextType::class, [
                'label' => 'Título del dominio',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. Backend & Microservicios'],
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'Subtítulo breve',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. Lógica de negocio, APIs REST/GraphQL y arquitectura limpia'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 3],
            ])
            ->add('techTags', TextType::class, [
                'label' => 'Tecnologías (separadas por coma)',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Symfony (PHP), FastAPI (Python), Django, Node.js, Go'],
            ])
            ->add('sortOrder', IntegerType::class, [
                'label' => 'Orden',
                'attr' => ['class' => 'form-control sc-form-control', 'min' => 0],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Visible en la página pública',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TechnologyDomain::class,
        ]);
    }
}
