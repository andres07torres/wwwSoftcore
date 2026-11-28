<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\MethodologyPageConfigRepository;
use App\Repository\MethodologyPhaseRepository;
use App\Repository\MethodologyPillarRepository;
use App\Repository\MethodologyStandardRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AdminMethodologyControllerTest extends WebTestCase
{
    public function testAdminMethodologyRequiresAuthentication(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/metodologia');

        $this->assertResponseRedirects('/login');
    }

    public function testAdminCanEditMethodologySectionsAndManageModals(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var UserRepository $userRepo */
        $userRepo = $container->get(UserRepository::class);
        /** @var MethodologyPageConfigRepository $configRepo */
        $configRepo = $container->get(MethodologyPageConfigRepository::class);
        /** @var MethodologyPillarRepository $pillarRepo */
        $pillarRepo = $container->get(MethodologyPillarRepository::class);
        /** @var MethodologyPhaseRepository $phaseRepo */
        $phaseRepo = $container->get(MethodologyPhaseRepository::class);
        /** @var MethodologyStandardRepository $standardRepo */
        $standardRepo = $container->get(MethodologyStandardRepository::class);
        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $container->get(UserPasswordHasherInterface::class);

        $email = 'test-method-page-admin@softcorec.com';
        $existingUser = $userRepo->findOneByEmail($email);
        if (null !== $existingUser) {
            $em->remove($existingUser);
            $em->flush();
        }

        $admin = new User();
        $admin->setEmail($email);
        $admin->setFullName('Admin Metodología');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsActive(true);
        $admin->setPassword($hasher->hashPassword($admin, 'MethodPage2026!'));
        $em->persist($admin);
        $em->flush();

        try {
            $client->loginUser($admin);

            // 1. Update Hero
            $crawler = $client->request('GET', '/admin/metodologia');
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('h1', 'Metodología');

            $heroForm = $crawler->filter('form[name="methodology_hero"]')->form([
                'methodology_hero[heroTitlePrefix]' => 'Proceso ágil para',
                'methodology_hero[heroTitleHighlight]' => 'resultados reales',
                'methodology_hero[heroTitleSuffix]' => 'en producción',
            ]);
            $client->submit($heroForm);
            $this->assertResponseRedirects('/admin/metodologia#sec-hero');

            // 2. Create Pillar via Modal
            $crawler = $client->request('GET', '/admin/metodologia');
            $pillarForm = $crawler->filter('#modalNewPillar form')->form([
                'methodology_pillar[iconKey]' => 'bolt',
                'methodology_pillar[title]' => 'Entregas Semanales',
                'methodology_pillar[description]' => 'Iteraciones cortas y demostrables.',
                'methodology_pillar[sortOrder]' => '1',
                'methodology_pillar[isActive]' => true,
            ]);
            $client->submit($pillarForm);
            $this->assertResponseRedirects('/admin/metodologia#sec-filosofia');

            // 3. Create Phase via Modal
            $crawler = $client->request('GET', '/admin/metodologia');
            $phaseForm = $crawler->filter('#modalNewPhase form')->form([
                'methodology_phase[phaseBadge]' => 'FASE 01',
                'methodology_phase[duration]' => 'Semana 1',
                'methodology_phase[title]' => 'Kickoff Estratégico',
                'methodology_phase[description]' => 'Alineación de objetivos y alcance.',
                'methodology_phase[deliverable]' => 'Roadmap técnico validado',
                'methodology_phase[sortOrder]' => '1',
                'methodology_phase[isActive]' => true,
            ]);
            $client->submit($phaseForm);
            $this->assertResponseRedirects('/admin/metodologia#sec-fases');

            // 4. Create Standard via Modal
            $crawler = $client->request('GET', '/admin/metodologia');
            $stdForm = $crawler->filter('#modalNewStandard form')->form([
                'methodology_standard[iconKey]' => 'lock',
                'methodology_standard[title]' => 'Zero Trust',
                'methodology_standard[description]' => 'Seguridad desde el diseño.',
                'methodology_standard[sortOrder]' => '1',
                'methodology_standard[isActive]' => true,
            ]);
            $client->submit($stdForm);
            $this->assertResponseRedirects('/admin/metodologia#sec-estandares');

            // Verify live rendering on /metodologia
            $client->request('GET', '/metodologia');
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('#methodology-hero-title', 'Proceso ágil para');
            $this->assertSelectorTextContains('#pilares', 'Entregas Semanales');
            $this->assertSelectorTextContains('#fases', 'Kickoff Estratégico');
            $this->assertSelectorTextContains('.methodology-standards-section', 'Zero Trust');
        } finally {
            $em->clear();
            foreach ($pillarRepo->findAll() as $p) {
                $em->remove($p);
            }
            foreach ($phaseRepo->findAll() as $ph) {
                $em->remove($ph);
            }
            foreach ($standardRepo->findAll() as $s) {
                $em->remove($s);
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
