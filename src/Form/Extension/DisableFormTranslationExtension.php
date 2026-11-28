<?php

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class DisableFormTranslationExtension extends AbstractTypeExtension
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('translation_domain', false);

        if ($resolver->isDefined('choice_translation_domain')) {
            $resolver->setDefault('choice_translation_domain', false);
        }
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class, ChoiceType::class];
    }
}
