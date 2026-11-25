<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MethodologyControllerTest extends WebTestCase
{
    public function testMethodologyPageLoadsSuccessfully(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/methodology');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1#methodology-hero-title');
        $this->assertSelectorTextContains('h1#methodology-hero-title', 'Metodología diseñada para');
    }

    public function testMethodologySpanishAliasLoadsSuccessfully(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/metodologia');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.methodology-hero-section');
    }

    public function testHeroButtonsConformToDesignSystem(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/methodology');

        // Botón primario corporativo: btn-hero-primary (Iniciar Proyecto)
        $this->assertSelectorExists('.methodology-hero-section .btn-hero-primary');
        $this->assertSelectorTextContains('.methodology-hero-section .btn-hero-primary', 'Iniciar Proyecto');

        // Botón secundario outline: btn-hero-outline-light (Explorar las Fases)
        $this->assertSelectorExists('.methodology-hero-section .btn-hero-outline-light');
        $this->assertSelectorTextContains('.methodology-hero-section .btn-hero-outline-light', 'Explorar las Fases');
    }

    public function testMethodologySectionsArePresent(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/methodology');

        // 4 Pilares
        $this->assertCount(4, $crawler->filter('.pillar-card'));

        // 5 Fases del Ciclo de Vida
        $this->assertCount(5, $crawler->filter('.phase-item'));

        // 4 Estándares de Ingeniería
        $this->assertCount(4, $crawler->filter('.standard-box'));
    }

    public function testNavbarMetodologiaLinkIsActive(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/methodology');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.navbar-nav .nav-link.active');
        $this->assertSelectorTextContains('.navbar-nav .nav-link.active', 'Metodología');
    }
}
