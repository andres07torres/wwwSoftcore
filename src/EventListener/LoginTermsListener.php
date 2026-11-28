<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

#[AsEventListener(event: CheckPassportEvent::class, priority: 256)]
final readonly class LoginTermsListener
{
    public const ERROR_MESSAGE = 'Debes aceptar los términos y condiciones para iniciar sesión.';

    public function __construct(
        private RequestStack $requestStack,
    ) {
    }

    public function __invoke(CheckPassportEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request || !$request->isMethod('POST')) {
            return;
        }

        if ('app_login' !== $request->attributes->get('_route')) {
            return;
        }

        if ('1' !== (string) $request->request->get('_accept_terms', '')) {
            throw new CustomUserMessageAuthenticationException(self::ERROR_MESSAGE);
        }
    }
}
