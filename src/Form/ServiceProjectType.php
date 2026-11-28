<?php

namespace App\Form;

use App\Entity\ServiceProject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

final class ServiceProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nombre del proyecto',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. Plataforma de Gestión Operativa'],
            ])
            ->add('category', TextType::class, [
                'label' => 'Categoría',
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. Software a Medida'],
            ])
            ->add('client', TextType::class, [
                'label' => 'Sector / Cliente',
                'required' => false,
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. Sector Logística'],
            ])
            ->add('year', TextType::class, [
                'label' => 'Año',
                'required' => false,
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => '2025'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => ['class' => 'form-control sc-form-control', 'rows' => 2],
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Imagen del proyecto (opcional, WebP/JPG/PNG máx. 5 MB)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image(
                        maxSize: '5M',
                        mimeTypes: ['image/webp', 'image/jpeg', 'image/png'],
                        mimeTypesMessage: 'Sube una imagen válida en formato WebP, JPG o PNG (máx. 5 MB).',
                    ),
                ],
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'accept' => 'image/webp,image/jpeg,image/png',
                ],
            ])
            ->add('metric', TextType::class, [
                'label' => 'Resultado destacado',
                'required' => false,
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Ej. -45% en tiempos de despacho'],
            ])
            ->add('techTags', TextType::class, [
                'label' => 'Tecnologías (separadas por coma)',
                'required' => false,
                'attr' => ['class' => 'form-control sc-form-control', 'placeholder' => 'Symfony, PostgreSQL, Docker'],
            ])
            ->add('sortOrder', IntegerType::class, [
                'label' => 'Orden',
                'attr' => ['class' => 'form-control sc-form-control', 'min' => 0],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Mostrar en el carrusel público',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => ServiceProject::class]);
    }
}
