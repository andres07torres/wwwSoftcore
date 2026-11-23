<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HomeControllerTest extends WebTestCase
{
    public function testHomePageLoadsSuccessfully(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.navbar-brand');
        $this->assertSelectorExists('img.navbar-logo[src*="softcore-logo"]');
        $this->assertSelectorExists('.navbar-toggler');
        $this->assertSelectorExists('#navbarMainCollapse');
        $this->assertSelectorExists('.btn-consultoria');
        $this->assertSelectorExists('.btn-whatsapp');
        $this->assertSelectorExists('.btn-instagram');
        $this->assertSelectorExists('.btn-facebook');
        $this->assertSelectorExists('.btn-lang[data-controller="language-switcher"]');
        $this->assertSelectorExists('.btn-lang img.flag-round-icon[src*="flags/es"]');
        $this->assertSelectorTextContains('.btn-lang .lang-code', 'ES');

        // 1. Hero Section con Carrusel Full-Width
        $this->assertSelectorExists('h1.hero-title');
        $this->assertSelectorTextContains('h1.hero-title', 'Arquitectura de software a medida');
        $this->assertSelectorExists('.btn-hero-primary');
        $this->assertSelectorExists('.btn-hero-secondary');
        $this->assertSelectorExists('#heroCarousel');
        $this->assertSelectorCount(4, '.hero-carousel-fullscreen .carousel-item');
        $this->assertSelectorCount(4, 'img.hero-fullscreen-img');

        // 2. Barra de Confianza / Métricas Clave
        $this->assertSelectorExists('.trust-bar');
        $this->assertSelectorCount(4, '.metric-card');
        $this->assertSelectorTextContains('.trust-bar', '+99.9%');
        $this->assertSelectorTextContains('.trust-bar', 'Cloud-Native');

        // 3. Resumen de Servicios
        $this->assertSelectorExists('#servicios');
        $this->assertSelectorCount(3, '.bento-card');

        // 4. Metodología Preview
        $this->assertSelectorExists('#metodologia');
        $this->assertSelectorCount(4, '.step-card');

        // 5. Stack Tecnológico con Carruseles de Iconos Reales
        $this->assertSelectorExists('#tecnologias');
        $this->assertSelectorExists('.tech-marquee-wrapper');
        $this->assertSelectorExists('.tech-card');

        // 6. Footer heredado desde base.html.twig (con ancla de consultoría)
        $this->assertSelectorExists('.main-footer#consultoria');
        $this->assertSelectorExists('.footer-logo');
        $this->assertSelectorExists('.footer-bottom');
        $this->assertSelectorTextContains('.footer-bottom', 'SoftCore');
    }
}
