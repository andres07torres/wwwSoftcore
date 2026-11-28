<?php

namespace App\Form;

use App\Entity\AboutPageConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

final class AboutHeroType extends AbstractType
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
            ->add('heroImageFile', FileType::class, [
                'label' => 'Imagen lateral (opcional, WebP/JPG/PNG máx. 5 MB)',
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
            ->add('heroCaption', TextType::class, [
                'label' => 'Pie de imagen',
                'required' => false,
                'attr' => ['class' => 'form-control sc-form-control'],
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
