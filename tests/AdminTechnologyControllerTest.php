<?php

namespace App\Tests;

use App\Entity\TechnologyCriterion;
use App\Entity\TechnologyDomain;
use App\Entity\TechnologyPageConfig;
use App\Entity\TechnologyPractice;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AdminTechnologyControllerTest extends WebTestCase
{
    public function testAnonymousUserIsRedirectedToLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/tecnologias');

        self::assertResponseRedirects('/login');
    }

    public function testAdminCanManageTechnologySectionsAndReflectsOnPublicPage(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $container->get(UserPasswordHasherInterface::class);

        $email = 'tech-admin-'.bin2hex(random_bytes(4)).'@softcorec.test';
        $user = (new User())
            ->setEmail($email)
            ->setFullName('Tech Admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setIsActive(true);
        $user->setPassword($hasher->hashPassword($user, 'AdminPass2026!'));
        $em->persist($user);
        $em->flush();

        try {
            $client->loginUser($user);

            // 1. Update Hero & spec console
            $crawler = $client->request('GET', '/admin/tecnologias');
            self::assertResponseIsSuccessful();

            $heroForm = $crawler->filter('form[name="technology_hero"]')->form([
                'technology_hero[heroTitlePrefix]' => 'Stack empresarial para',
                'technology_hero[heroTitleHighlight]' => 'sistemas de misión crítica',
                'technology_hero[heroSubtitle]' => 'Tecnologías probadas en producción con soporte extendido.',
                'technology_hero[specLabel]' => 'softcorec-stack.spec',
                'technology_hero[specStatus]' => 'production',
                'technology_hero[stackLayer1Label]' => 'Backend Core',
                'technology_hero[stackLayer1Value]' => 'PHP 8.5 · Symfony 8.1 · Go',
            ]);
            $client->submit($heroForm);
            self::assertResponseRedirects('/admin/tecnologias#sec-hero');

            // 2. Add Criterion via modal
            $crawler = $client->request('GET', '/admin/tecnologias');
            $criterionForm = $crawler->filter('#modalNewCriterion form')->form([
                'technology_criterion[iconKey]' => 'bolt',
                'technology_criterion[title]' => 'Latencia Subsegundo',
                'technology_criterion[description]' => 'Perfilado continuo para tiempos de respuesta óptimos.',
                'technology_criterion[sortOrder]' => 1,
                'technology_criterion[isActive]' => 1,
            ]);
            $client->submit($criterionForm);
            self::assertResponseRedirects('/admin/tecnologias#sec-criterios');

            // 3. Add Domain via modal
            $crawler = $client->request('GET', '/admin/tecnologias');
            $domainForm = $crawler->filter('#modalNewDomain form')->form([
                'technology_domain[iconKey]' => 'code',
                'technology_domain[title]' => 'APIs & Microservicios',
                'technology_domain[subtitle]' => 'Servicios de alta concurrencia',
                'technology_domain[description]' => 'Núcleos desacoplados con arquitectura hexagonal.',
                'technology_domain[techTags]' => 'Symfony 8, Rust, gRPC',
                'technology_domain[sortOrder]' => 1,
                'technology_domain[isActive]' => 1,
            ]);
            $client->submit($domainForm);
            self::assertResponseRedirects('/admin/tecnologias#sec-ecosistema');

            // 4. Add Practice via modal
            $crawler = $client->request('GET', '/admin/tecnologias');
            $practiceForm = $crawler->filter('#modalNewPractice form')->form([
                'technology_practice[stepNumber]' => '01',
                'technology_practice[title]' => 'Infraestructura Inmutable',
                'technology_practice[description]' => 'Entornos reproducibles versionados en Git.',
                'technology_practice[sortOrder]' => 1,
                'technology_practice[isActive]' => 1,
            ]);
            $client->submit($practiceForm);
            self::assertResponseRedirects('/admin/tecnologias#sec-practicas');

            // Verify public /tecnologias renders all changes and keeps fixed Hero buttons
            $client->request('GET', '/tecnologias');
            self::assertResponseIsSuccessful();
            $html = (string) $client->getResponse()->getContent();
            self::assertStringContainsString('Stack empresarial para', $html);
            self::assertStringContainsString('sistemas de misión crítica', $html);
            self::assertStringContainsString('softcorec-stack.spec', $html);
            self::assertStringContainsString('Backend Core', $html);
            self::assertStringContainsString('Iniciar Proyecto', $html);
            self::assertStringContainsString('Explorar Ecosistema', $html);
            self::assertStringContainsString('Latencia Subsegundo', $html);
            self::assertStringContainsString('APIs &amp; Microservicios', $html);
            self::assertStringContainsString('Symfony 8', $html);
            self::assertStringContainsString('Infraestructura Inmutable', $html);
        } finally {
            $em->clear();
            foreach ($em->getRepository(TechnologyPageConfig::class)->findAll() as $row) {
                $em->remove($row);
            }
            foreach ($em->getRepository(TechnologyCriterion::class)->findAll() as $row) {
                $em->remove($row);
            }
            foreach ($em->getRepository(TechnologyDomain::class)->findAll() as $row) {
                $em->remove($row);
            }
            foreach ($em->getRepository(TechnologyPractice::class)->findAll() as $row) {
                $em->remove($row);
            }
            $managedUser = $em->getRepository(User::class)->findOneBy(['email' => $email]);
            if (null !== $managedUser) {
                $em->remove($managedUser);
            }
            $em->flush();
        }
    }
}
