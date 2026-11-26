<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class MaintenanceListenerTest extends WebTestCase
{
    public function testMaintenanceModeDisplaysOnlyMaintenanceTemplateWhenLockFileExists(): void
    {
        $client = static::createClient();
        $lockFile = static::getContainer()->getParameter('kernel.project_dir').'/var/maintenance.lock';

        touch($lockFile);

        try {
            $client->request('GET', '/');
            $this->assertResponseStatusCodeSame(Response::HTTP_SERVICE_UNAVAILABLE);
            $this->assertResponseHeaderSame('Retry-After', '3600');
            $this->assertSelectorExists('main.maintenance-screen');
            $this->assertSelectorExists('img.maintenance-gif[src*="mantenimiento-animado"]');
            $this->assertSelectorNotExists('.main-header');
            $this->assertSelectorNotExists('.main-footer');

            $client->request('GET', '/services');
            $this->assertResponseStatusCodeSame(Response::HTTP_SERVICE_UNAVAILABLE);
            $this->assertSelectorExists('img.maintenance-gif[src*="mantenimiento-animado"]');
        } finally {
            @unlink($lockFile);
        }

        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.main-header');
    }
}
