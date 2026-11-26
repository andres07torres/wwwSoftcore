<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AboutControllerTest extends WebTestCase
{
    public function testAboutPageLoadsSuccessfully(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/about');

        $this->assertResponseIsSuccessful();

        // 1. Navbar y elementos globales
        $this->assertSelectorExists('.main-header.fixed-top');
        $this->assertSelectorExists('.navbar-brand');
        $this->assertSelectorExists('img.navbar-logo[src*="softcore-logo"]');
        $this->assertSelectorExists('.btn-lang[data-controller="language-switcher"]');
        $this->assertSelectorExists('.nav-link.active');
        $this->assertSelectorTextContains('.nav-link.active', 'Quiénes Somos');

        // 2. Hero de Quiénes Somos
        $this->assertSelectorExists('.about-hero-section');
        $this->assertSelectorExists('#about-hero-title');
        $this->assertSelectorTextContains('#about-hero-title', 'Construyendo el futuro digital');
        $this->assertSelectorExists('.about-hero-card');

        // 3. Propósito (Misión & Visión)
        $this->assertSelectorExists('#proposito');
        $this->assertSelectorCount(2, '.purpose-card');
        $this->assertSelectorTextContains('#proposito', 'Nuestra Misión');
        $this->assertSelectorTextContains('#proposito', 'Nuestra Visión');

        // 4. Valores & Cultura
        $this->assertSelectorExists('#valores');
        $this->assertSelectorCount(4, '.value-card');
        $this->assertSelectorTextContains('#valores', 'Excelencia Técnica');
        $this->assertSelectorTextContains('#valores', 'Orientación a Negocio');
        $this->assertSelectorTextContains('#valores', 'Transparencia Radical');
        $this->assertSelectorTextContains('#valores', 'Innovación Pragmática');

        // 5. Métricas & Trayectoria
        $this->assertSelectorExists('#trayectoria');
        $this->assertSelectorCount(4, '.stat-box');
        $this->assertSelectorTextContains('#trayectoria', '+50');
        $this->assertSelectorTextContains('#trayectoria', '99.98%');
        $this->assertSelectorTextContains('#trayectoria', '100%');
        $this->assertSelectorTextContains('#trayectoria', '+7');

        // 6. Footer heredado
        $this->assertSelectorExists('.main-footer#consultoria');
        $this->assertSelectorExists('.footer-logo');
        $this->assertSelectorTextContains('.footer-bottom', 'SoftCorec');
    }

    public function testAboutSpanishAliasRouteWorks(): void
    {
        $client = static::createClient();
        $client->request('GET', '/quienes-somos');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.about-hero-section');
        $this->assertSelectorExists('#about-hero-title');
    }
}
