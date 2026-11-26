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
            $this->assertSelectorTextContains('h1', 'Estamos en mantenimiento');
            $this->assertSelectorExists('.progress');
            $this->assertSelectorExists('.tape.top');
            $this->assertSelectorNotExists('.main-header');
            $this->assertSelectorNotExists('.main-footer');

            $client->request('GET', '/services');
            $this->assertResponseStatusCodeSame(Response::HTTP_SERVICE_UNAVAILABLE);
            $this->assertSelectorTextContains('h1', 'Estamos en mantenimiento');
        } finally {
            @unlink($lockFile);
        }

        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.main-header');
    }
}
