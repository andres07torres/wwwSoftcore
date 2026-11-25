<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TechnologyControllerTest extends WebTestCase
{
    public function testTechnologyPageLoadsSuccessfully(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tecnologias');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1#technology-hero-title');
        $this->assertSelectorTextContains('h1#technology-hero-title', 'Stack tecnológico seleccionado para');
        $this->assertSelectorExists('.technology-hero-section');
        $this->assertSelectorExists('#criterios');
        $this->assertSelectorExists('#ecosistema');
        $this->assertSelectorExists('#estandares');
        $this->assertSelectorTextContains('#ecosistema', 'Kotlin (Android)');
    }

    public function testTechnologyEnglishRouteLoadsSuccessfully(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/technology');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1#technology-hero-title');
    }

    public function testTechnologyHeroActionsExist(): void
    {
        $client = static::createClient();
        $client->request('GET', '/tecnologias');

        $this->assertSelectorExists('.technology-hero-section .btn-hero-primary');
        $this->assertSelectorTextContains('.technology-hero-section .btn-hero-primary', 'Iniciar Proyecto');
        $this->assertSelectorExists('.technology-hero-section .btn-hero-outline-light');
        $this->assertSelectorTextContains('.technology-hero-section .btn-hero-outline-light', 'Explorar Ecosistema');
    }
}
