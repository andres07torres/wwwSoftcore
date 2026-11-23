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
        $this->assertSelectorTextContains('.navbar-brand', 'Softcore');
        $this->assertSelectorExists('.navbar-toggler');
        $this->assertSelectorExists('#navbarSupportedContent');
    }
}
