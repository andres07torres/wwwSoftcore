<?php

namespace App\Form;

use App\Entity\ServiceCatalogItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ServiceCatalogItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('iconKey', ChoiceType::class, [
                'label' => 'Ícono',
                'choices' => ServiceCatalogItem::ICONS,
                'attr' => ['class' => 'form-select sc-form-control'],
            ])
            ->add('category', TextType::class, [
                'label' => 'Categoría',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. Desarrollo Core'],
            ])
            ->add('title', TextType::class, [
                'label' => 'Título del servicio',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. Software a Medida & APIs'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 2],
            ])
            ->add('capabilities', TextareaType::class, [
                'label' => 'Capacidades (una por línea)',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'rows' => 3,
                    'placeholder' => "Arquitecturas limpias (Hexagonal / DDD)\nAPIs RESTful y GraphQL escalables",
                ],
            ])
            ->add('techTags', TextType::class, [
                'label' => 'Tecnologías (separadas por coma)',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Symfony, PHP, Node.js, PostgreSQL'],
            ])
            ->add('sortOrder', IntegerType::class, [
                'label' => 'Orden',
                'attr' => ['class' => 'form-control sc-form-control', 'min' => 0],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Mostrar en el catálogo público',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => ServiceCatalogItem::class]);
    }
}
