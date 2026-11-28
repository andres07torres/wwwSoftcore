<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\ServiceCatalogItemRepository;
use App\Repository\ServiceProjectRepository;
use App\Repository\ServicesPageConfigRepository;
use App\Repository\ServiceWorkflowStepRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AdminServicesControllerTest extends WebTestCase
{
    public function testAdminServicesRequiresAuthentication(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/servicios');

        $this->assertResponseRedirects('/login');
    }

    public function testAdminCanEditServicesSectionsAndManageModals(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var UserRepository $userRepo */
        $userRepo = $container->get(UserRepository::class);
        /** @var ServicesPageConfigRepository $configRepo */
        $configRepo = $container->get(ServicesPageConfigRepository::class);
        /** @var ServiceCatalogItemRepository $catalogRepo */
        $catalogRepo = $container->get(ServiceCatalogItemRepository::class);
        /** @var ServiceProjectRepository $projectRepo */
        $projectRepo = $container->get(ServiceProjectRepository::class);
        /** @var ServiceWorkflowStepRepository $workflowRepo */
        $workflowRepo = $container->get(ServiceWorkflowStepRepository::class);
        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $container->get(UserPasswordHasherInterface::class);

        $email = 'test-services-page-admin@softcorec.com';
        $existingUser = $userRepo->findOneByEmail($email);
        if (null !== $existingUser) {
            $em->remove($existingUser);
            $em->flush();
        }

        $admin = new User();
        $admin->setEmail($email);
        $admin->setFullName('Admin Servicios');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsActive(true);
        $admin->setPassword($hasher->hashPassword($admin, 'ServPass2026!'));
        $em->persist($admin);
        $em->flush();

        try {
            $client->loginUser($admin);

            // 1. Update Hero & Contact
            $crawler = $client->request('GET', '/admin/servicios');
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('h1', 'Servicios');

            $heroForm = $crawler->filter('form[name="services_hero"]')->form([
                'services_hero[heroTitlePrefix]' => 'Soluciones cloud para',
                'services_hero[heroTitleHighlight]' => 'acelerar tu empresa',
            ]);
            $client->submit($heroForm);
            $this->assertResponseRedirects('/admin/servicios#sec-hero');

            $crawler = $client->request('GET', '/admin/servicios');
            $contactForm = $crawler->filter('form[name="services_contact"]')->form([
                'services_contact[contactTitle]' => '¿Listo para tu próximo proyecto?',
            ]);
            $client->submit($contactForm);
            $this->assertResponseRedirects('/admin/servicios#sec-contacto');

            // 2. Create Catalog Item via Modal
            $crawler = $client->request('GET', '/admin/servicios');
            $catForm = $crawler->filter('#modalNewCatalogItem form')->form([
                'service_catalog_item[iconKey]' => 'cloud',
                'service_catalog_item[category]' => 'Cloud',
                'service_catalog_item[title]' => 'Kubernetes Gestionado',
                'service_catalog_item[description]' => 'Orquestación segura en producción.',
                'service_catalog_item[capabilities]' => "Alta disponibilidad\nEscalamiento automático",
                'service_catalog_item[techTags]' => 'Kubernetes, Docker, AWS',
                'service_catalog_item[sortOrder]' => '1',
                'service_catalog_item[isActive]' => true,
            ]);
            $client->submit($catForm);
            $this->assertResponseRedirects('/admin/servicios#sec-portafolio');

            // 3. Create Project via Modal
            $crawler = $client->request('GET', '/admin/servicios');
            $projForm = $crawler->filter('#modalNewProject form')->form([
                'service_project[title]' => 'ERP Logístico Cloud',
                'service_project[category]' => 'Software',
                'service_project[client]' => 'Sector Logística',
                'service_project[year]' => '2026',
                'service_project[description]' => 'Gestión en tiempo real.',
                'service_project[metric]' => '-50% tiempos',
                'service_project[techTags]' => 'Symfony, PostgreSQL',
                'service_project[sortOrder]' => '1',
                'service_project[isActive]' => true,
            ]);
            $client->submit($projForm);
            $this->assertResponseRedirects('/admin/servicios#sec-proyectos');

            // 4. Create Workflow Step via Modal
            $crawler = $client->request('GET', '/admin/servicios');
            $wfForm = $crawler->filter('#modalNewWorkflowStep form')->form([
                'service_workflow_step[stepNumber]' => '01',
                'service_workflow_step[title]' => 'Auditoría Inicial',
                'service_workflow_step[description]' => 'Revisión completa de requerimientos.',
                'service_workflow_step[sortOrder]' => '1',
                'service_workflow_step[isActive]' => true,
            ]);
            $client->submit($wfForm);
            $this->assertResponseRedirects('/admin/servicios#sec-workflow');

            // Verify live rendering on /servicios
            $client->request('GET', '/servicios');
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('#services-hero-title', 'Soluciones cloud para');
            $this->assertSelectorTextContains('#catalogo', 'Kubernetes Gestionado');
            $this->assertSelectorTextContains('#proyectos', 'ERP Logístico Cloud');
            $this->assertSelectorTextContains('#metodologia-servicio', 'Auditoría Inicial');
            $this->assertSelectorTextContains('#services-form-title', '¿Listo para tu próximo proyecto?');
        } finally {
            $em->clear();
            foreach ($catalogRepo->findAll() as $i) {
                $em->remove($i);
            }
            foreach ($projectRepo->findAll() as $p) {
                $em->remove($p);
            }
            foreach ($workflowRepo->findAll() as $w) {
                $em->remove($w);
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
