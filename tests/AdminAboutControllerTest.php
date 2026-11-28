<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\AboutMetricCardRepository;
use App\Repository\AboutPageConfigRepository;
use App\Repository\AboutValueCardRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AdminAboutControllerTest extends WebTestCase
{
    public function testAdminAboutRequiresAuthentication(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/quienes-somos');

        $this->assertResponseRedirects('/login');
    }

    public function testAdminCanEditAboutSectionsAndManageValuesAndMetrics(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var UserRepository $userRepo */
        $userRepo = $container->get(UserRepository::class);
        /** @var AboutPageConfigRepository $configRepo */
        $configRepo = $container->get(AboutPageConfigRepository::class);
        /** @var AboutValueCardRepository $valueRepo */
        $valueRepo = $container->get(AboutValueCardRepository::class);
        /** @var AboutMetricCardRepository $metricRepo */
        $metricRepo = $container->get(AboutMetricCardRepository::class);
        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $container->get(UserPasswordHasherInterface::class);

        $email = 'test-about-admin@softcorec.com';
        $existingUser = $userRepo->findOneByEmail($email);
        if (null !== $existingUser) {
            $em->remove($existingUser);
            $em->flush();
        }

        $admin = new User();
        $admin->setEmail($email);
        $admin->setFullName('Admin About');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsActive(true);
        $admin->setPassword($hasher->hashPassword($admin, 'AboutPass2026!'));
        $em->persist($admin);
        $em->flush();

        try {
            $client->loginUser($admin);

            // 1. Update Hero & Purpose
            $crawler = $client->request('GET', '/admin/quienes-somos');
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('h1', 'Quiénes Somos');

            $heroForm = $crawler->filter('form[name="about_hero"]')->form([
                'about_hero[heroTitlePrefix]' => 'Impulsando empresas con',
                'about_hero[heroTitleHighlight]' => 'arquitectura cloud',
                'about_hero[heroTitleSuffix]' => 'moderna',
                'about_hero[heroSubtitle]' => 'Descripción personalizada de Quiénes Somos.',
            ]);
            $client->submit($heroForm);
            $this->assertResponseRedirects('/admin/quienes-somos#sec-hero');

            $crawler = $client->request('GET', '/admin/quienes-somos');
            $purposeForm = $crawler->filter('form[name="about_purpose"]')->form([
                'about_purpose[missionTitle]' => 'Misión personalizada SoftCorec',
                'about_purpose[visionTitle]' => 'Visión personalizada SoftCorec',
            ]);
            $client->submit($purposeForm);
            $this->assertResponseRedirects('/admin/quienes-somos#sec-proposito');

            // 2. Create Value Card via modal form
            $crawler = $client->request('GET', '/admin/quienes-somos');
            $valueForm = $crawler->filter('#modalNewAboutValue form')->form([
                'about_value_card[iconKey]' => 'shield',
                'about_value_card[title]' => 'Calidad Continua',
                'about_value_card[description]' => 'Pruebas automatizadas en cada entrega.',
                'about_value_card[sortOrder]' => '1',
                'about_value_card[isActive]' => true,
            ]);
            $client->submit($valueForm);
            $this->assertResponseRedirects('/admin/quienes-somos#sec-cultura');

            // 3. Create Metric Card via modal form
            $crawler = $client->request('GET', '/admin/quienes-somos');
            $metricForm = $crawler->filter('#modalNewAboutMetric form')->form([
                'about_metric_card[value]' => '+80',
                'about_metric_card[label]' => 'Clientes Activos',
                'about_metric_card[description]' => 'Empresas operando con nuestra tecnología.',
                'about_metric_card[sortOrder]' => '1',
                'about_metric_card[isActive]' => true,
            ]);
            $client->submit($metricForm);
            $this->assertResponseRedirects('/admin/quienes-somos#sec-resultados');

            // Verify live rendering on /quienes-somos
            $client->request('GET', '/quienes-somos');
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('#about-hero-title', 'Impulsando empresas con');
            $this->assertSelectorTextContains('#proposito', 'Misión personalizada SoftCorec');
            $this->assertSelectorCount(1, '#valores .value-card');
            $this->assertSelectorTextContains('#valores', 'Calidad Continua');
            $this->assertSelectorCount(1, '#trayectoria .stat-box');
            $this->assertSelectorTextContains('#trayectoria', '+80');
        } finally {
            $em->clear();
            foreach ($valueRepo->findAll() as $v) {
                $em->remove($v);
            }
            foreach ($metricRepo->findAll() as $m) {
                $em->remove($m);
            }
            foreach ($configRepo->findAll() as $c) {
                $em->remove($c);
            }
            $cleanupUser = $userRepo->findOneByEmail($email);
            if (null !== $cleanupUser) {
                $em->remove($cleanupUser);
            }
            $em->flush();
        }
    }
}
