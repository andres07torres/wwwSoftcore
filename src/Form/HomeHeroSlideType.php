<?php

namespace App\Form;

use App\Entity\HomeHeroSlide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

final class HomeHeroSlideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $requireImage = (bool) $options['require_image'];
        $imageConstraints = [
            new Image(
                maxSize: '5M',
                mimeTypes: ['image/webp', 'image/jpeg', 'image/png'],
                mimeTypesMessage: 'Sube una imagen válida en formato WebP, JPG o PNG (máx. 5 MB).',
            ),
        ];

        if ($requireImage) {
            $imageConstraints[] = new NotNull(message: 'Debes seleccionar una imagen para la diapositiva.');
        }

        $builder
            ->add('imageFile', FileType::class, [
                'label' => $requireImage ? 'Imagen del carrusel' : 'Reemplazar imagen (opcional)',
                'mapped' => false,
                'required' => $requireImage,
                'constraints' => $imageConstraints,
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'accept' => 'image/webp,image/jpeg,image/png',
                ],
            ])
            ->add('altText', TextType::class, [
                'label' => 'Descripción alternativa (SEO / Accesibilidad)',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'placeholder' => 'Ej. Colaboración y arquitectura de software',
                ],
            ])
            ->add('sortOrder', IntegerType::class, [
                'label' => 'Orden de aparición',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'min' => 0,
                ],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Mostrar en el carrusel público',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HomeHeroSlide::class,
            'require_image' => true,
        ]);
        $resolver->setAllowedTypes('require_image', 'bool');
    }
}
