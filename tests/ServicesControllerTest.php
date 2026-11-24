<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ServicesControllerTest extends WebTestCase
{
    public function testServicesPageLoadsSuccessfully(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/services');

        $this->assertResponseIsSuccessful();

        // 1. Navbar y elementos globales
        $this->assertSelectorExists('.main-header.fixed-top');
        $this->assertSelectorExists('.navbar-brand');
        $this->assertSelectorExists('.btn-lang[data-controller="language-switcher"]');
        $this->assertSelectorExists('.nav-link.active');
        $this->assertSelectorTextContains('.nav-link.active', 'Servicios');

        // 2. Hero de Servicios
        $this->assertSelectorExists('.services-hero-section');
        $this->assertSelectorExists('#services-hero-title');
        $this->assertSelectorTextContains('#services-hero-title', 'Servicios de ingeniería diseñados');
        $this->assertSelectorExists('.services-img-frame img');

        // 3. Catálogo de Servicios (6 tarjetas)
        $this->assertSelectorExists('#catalogo');
        $this->assertSelectorCount(6, '.service-detail-card');
        $this->assertSelectorTextContains('#software', 'Software a Medida & APIs');
        $this->assertSelectorTextContains('#cloud', 'Cloud Architecture & DevOps');
        $this->assertSelectorTextContains('#web-mobile', 'Aplicaciones Web & Móviles');
        $this->assertSelectorTextContains('#consultoria-it', 'Consultoría & Auditoría IT');
        $this->assertSelectorTextContains('#databases', 'Bases de Datos & Rendimiento');
        $this->assertSelectorTextContains('#seguridad', 'Ciberseguridad & Hardening');

        // 4. Proceso de Trabajo (4 pasos)
        $this->assertSelectorExists('#metodologia-servicio');
        $this->assertSelectorCount(4, '.workflow-card');
        $this->assertSelectorTextContains('#metodologia-servicio', 'Diagnóstico & Estrategia');
        $this->assertSelectorTextContains('#metodologia-servicio', 'Desarrollo Iterativo');
        $this->assertSelectorTextContains('#metodologia-servicio', 'QA & Seguridad CI/CD');
        $this->assertSelectorTextContains('#metodologia-servicio', 'Despliegue & Soporte');

        // 5. Formulario de Consultoría & Contacto
        $this->assertSelectorExists('#formulario-contacto');
        $this->assertSelectorExists('.services-form-card');
        $this->assertSelectorExists('#servicesInquiryForm');
        $this->assertSelectorExists('input#contact_name');
        $this->assertSelectorExists('input#contact_email');
        $this->assertSelectorExists('input#contact_company');
        $this->assertSelectorExists('select#contact_service');
        $this->assertSelectorExists('textarea#contact_message');
        $this->assertSelectorExists('button.btn-submit-service');

        // 6. Footer heredado
        $this->assertSelectorExists('.main-footer#consultoria');
        $this->assertSelectorExists('.footer-logo');
        $this->assertSelectorTextContains('.footer-bottom', 'SoftCore');
    }

    public function testServicesContactFormSubmission(): void
    {
        $client = static::createClient();
        $client->request('POST', '/services', [
            'name' => 'Carlos Torres',
            'email' => 'carlos@empresa.com',
            'company' => 'Tech Corp',
            'service' => 'cloud',
            'message' => 'Necesitamos migrar nuestra arquitectura a Kubernetes y optimizar pipelines CI/CD.'
        ]);

        $this->assertResponseRedirects('/services#formulario-contacto');
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.alert-success');
        $this->assertSelectorTextContains('.alert-success', '¡Gracias por escribirnos!');
    }

    public function testServicesSpanishAliasRouteWorks(): void
    {
        $client = static::createClient();
        $client->request('GET', '/servicios');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.services-hero-section');
        $this->assertSelectorExists('#services-hero-title');
    }
}
