<?php

namespace App\Form;

use App\Entity\SocialLinksConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocialLinksConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('whatsappUrl', UrlType::class, [
                'label' => 'Enlace de WhatsApp',
                'default_protocol' => 'https',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'placeholder' => 'https://wa.me/593999999999',
                ],
            ])
            ->add('whatsappActive', CheckboxType::class, [
                'label' => 'Visible en el sitio',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
            ])
            ->add('instagramUrl', UrlType::class, [
                'label' => 'Enlace de Instagram',
                'default_protocol' => 'https',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'placeholder' => 'https://instagram.com/softcorec',
                ],
            ])
            ->add('instagramActive', CheckboxType::class, [
                'label' => 'Visible en el sitio',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
            ])
            ->add('facebookUrl', UrlType::class, [
                'label' => 'Enlace de Facebook',
                'default_protocol' => 'https',
                'attr' => [
                    'class' => 'form-control sc-form-control',
                    'placeholder' => 'https://facebook.com/softcorec',
                ],
            ])
            ->add('facebookActive', CheckboxType::class, [
                'label' => 'Visible en el sitio',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SocialLinksConfig::class,
        ]);
    }
}
