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
        $this->assertSelectorExists('.btn-lang');
    }
}
