<?php

namespace App\EventListener;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

#[AsEventListener(event: KernelEvents::REQUEST, priority: 200)]
final readonly class MaintenanceListener
{
    public function __construct(
        private Environment $twig,
        #[Autowire('%env(bool:APP_MAINTENANCE)%')]
        private bool $maintenanceEnabled,
        #[Autowire('%kernel.project_dir%')]
        private string $projectDir,
    ) {
    }

    public function __invoke(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        if (!$this->isMaintenanceActive()) {
            return;
        }

        $path = $event->getRequest()->getPathInfo();
        if (
            str_starts_with($path, '/_profiler')
            || str_starts_with($path, '/_wdt')
            || str_starts_with($path, '/admin')
            || '/login' === $path
            || '/logout' === $path
        ) {
            return;
        }

        $html = $this->twig->render('maintenance.html.twig');

        $event->setResponse(new Response($html, Response::HTTP_SERVICE_UNAVAILABLE, [
            'Retry-After' => '3600',
            'X-Robots-Tag' => 'noindex, nofollow',
        ]));
    }

    private function isMaintenanceActive(): bool
    {
        return $this->maintenanceEnabled || is_file($this->projectDir.'/var/maintenance.lock');
    }
}
