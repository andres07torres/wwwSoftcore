<?php

namespace App\Tests;

use App\Entity\HomeHeroConfig;
use App\Entity\HomeHeroSlide;
use App\Entity\User;
use App\Repository\HomeHeroConfigRepository;
use App\Repository\HomeHeroSlideRepository;
use App\Repository\HomeMethodologyConfigRepository;
use App\Repository\HomeMethodologyStepRepository;
use App\Repository\HomeServiceCardRepository;
use App\Repository\HomeServicesConfigRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AdminHomeControllerTest extends WebTestCase
{
    public function testAdminHomeRequiresAuthentication(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/inicio');

        $this->assertResponseRedirects('/login');
    }

    public function testAdminCanEditHeroConfigAndManageSlides(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var UserRepository $userRepo */
        $userRepo = $container->get(UserRepository::class);
        /** @var HomeHeroConfigRepository $heroConfigRepo */
        $heroConfigRepo = $container->get(HomeHeroConfigRepository::class);
        /** @var HomeHeroSlideRepository $heroSlideRepo */
        $heroSlideRepo = $container->get(HomeHeroSlideRepository::class);
        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $container->get(UserPasswordHasherInterface::class);

        $email = 'test-home-admin@softcorec.com';
        $existingUser = $userRepo->findOneByEmail($email);
        if (null !== $existingUser) {
            $em->remove($existingUser);
            $em->flush();
        }

        $admin = new User();
        $admin->setEmail($email);
        $admin->setFullName('Admin Inicio');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsActive(true);
        $admin->setPassword($hasher->hashPassword($admin, 'HomePass2026!'));
        $em->persist($admin);
        $em->flush();

        $tempPng = tempnam(sys_get_temp_dir(), 'hero_test_');
        // Minimal valid 1x1 PNG
        file_put_contents($tempPng, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+X2dIAAAAASUVORK5CYII='));

        try {
            $client->loginUser($admin);

            // 1. Update Hero Texts & Buttons
            $crawler = $client->request('GET', '/admin/inicio');
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('h1', 'Inicio');

            $form = $crawler->filter('form[name="home_hero_config"]')->form([
                'home_hero_config[titlePrefix]' => 'Ingeniería moderna que',
                'home_hero_config[titleHighlight]' => 'impulsa tu crecimiento',
                'home_hero_config[subtitle]' => 'Subtítulo personalizado desde el panel.',
            ]);
            $client->submit($form);
            $this->assertResponseRedirects('/admin/inicio');

            // Verify updated hero renders on public homepage
            $client->request('GET', '/');
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('h1.hero-title', 'Ingeniería moderna que');
            $this->assertSelectorTextContains('.hero-subtitle', 'Subtítulo personalizado desde el panel.');

            // 2. Create a Hero Slide
            $crawler = $client->request('GET', '/admin/inicio/slides/nuevo');
            $this->assertResponseIsSuccessful();

            $uploaded = new UploadedFile($tempPng, 'slide-prueba.png', 'image/png', null, true);
            $slideForm = $crawler->selectButton('Crear diapositiva')->form([
                'home_hero_slide[altText]' => 'Slide de prueba CRUD',
                'home_hero_slide[sortOrder]' => '1',
                'home_hero_slide[isActive]' => true,
            ]);
            $slideForm['home_hero_slide[imageFile]']->upload($uploaded);
            $client->submit($slideForm);
            $this->assertResponseRedirects('/admin/inicio');

            $crawler = $client->followRedirect();
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('.sc-admin-table', 'Slide de prueba CRUD');

            // Verify custom slide appears on public homepage
            $client->request('GET', '/');
            $this->assertResponseIsSuccessful();
            $this->assertSelectorCount(1, '.hero-carousel-fullscreen .carousel-item');
            $this->assertSelectorExists('img.hero-fullscreen-img[alt="Slide de prueba CRUD"]');

            // 3. Edit the Slide
            $slides = $heroSlideRepo->findAllOrdered();
            $this->assertCount(1, $slides);
            $slide = $slides[0];

            $crawler = $client->request('GET', '/admin/inicio/slides/'.$slide->getId().'/editar');
            $this->assertResponseIsSuccessful();

            $editForm = $crawler->selectButton('Guardar cambios')->form([
                'home_hero_slide[altText]' => 'Slide editado CRUD',
                'home_hero_slide[sortOrder]' => '2',
                'home_hero_slide[isActive]' => true,
            ]);
            $client->submit($editForm);
            $this->assertResponseRedirects('/admin/inicio');

            $crawler = $client->followRedirect();
            $this->assertSelectorTextContains('.sc-admin-table', 'Slide editado CRUD');

            // 4. Delete the Slide
            $deleteForm = $crawler->filter('form[action="/admin/inicio/slides/'.$slide->getId().'/eliminar"]')->form();
            $client->submit($deleteForm);
            $this->assertResponseRedirects('/admin/inicio');

            $em->clear();
            $this->assertCount(0, $heroSlideRepo->findAll());
        } finally {
            if (is_file($tempPng)) {
                @unlink($tempPng);
            }
            $em->clear();
            foreach ($heroSlideRepo->findAll() as $s) {
                $em->remove($s);
            }
            foreach ($heroConfigRepo->findAll() as $c) {
                $em->remove($c);
            }
            $cleanupUser = $userRepo->findOneByEmail($email);
            if (null !== $cleanupUser) {
                $em->remove($cleanupUser);
            }
            $em->flush();
        }
    }

    public function testAdminCanEditServicesHeaderAndManageCards(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var UserRepository $userRepo */
        $userRepo = $container->get(UserRepository::class);
        /** @var HomeServicesConfigRepository $servicesConfigRepo */
        $servicesConfigRepo = $container->get(HomeServicesConfigRepository::class);
        /** @var HomeServiceCardRepository $serviceCardRepo */
        $serviceCardRepo = $container->get(HomeServiceCardRepository::class);
        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $container->get(UserPasswordHasherInterface::class);

        $email = 'test-services-admin@softcorec.com';
        $existingUser = $userRepo->findOneByEmail($email);
        if (null !== $existingUser) {
            $em->remove($existingUser);
            $em->flush();
        }

        $admin = new User();
        $admin->setEmail($email);
        $admin->setFullName('Admin Pilares');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsActive(true);
        $admin->setPassword($hasher->hashPassword($admin, 'PilaresPass2026!'));
        $em->persist($admin);
        $em->flush();

        try {
            $client->loginUser($admin);

            // 1. Update Services Header
            $crawler = $client->request('GET', '/admin/inicio');
            $this->assertResponseIsSuccessful();

            $headerForm = $crawler->filter('form[name="home_services_config"]')->form([
                'home_services_config[eyebrow]' => 'Pilares SoftCorec',
                'home_services_config[title]' => 'Ingeniería hecha a medida',
                'home_services_config[subtitle]' => 'Acompañamos cada fase de tu producto.',
            ]);
            $client->submit($headerForm);
            $this->assertResponseRedirects('/admin/inicio');

            // 2. Create Service Card
            $crawler = $client->request('GET', '/admin/inicio/pilares/nuevo');
            $this->assertResponseIsSuccessful();

            $cardForm = $crawler->selectButton('Crear tarjeta')->form([
                'home_service_card[iconKey]' => 'shield',
                'home_service_card[title]' => 'Ciberseguridad Cloud',
                'home_service_card[description]' => 'Protección integral para tus aplicaciones.',
                'home_service_card[linkText]' => 'Conocer más',
                'home_service_card[linkUrl]' => '/servicios',
                'home_service_card[sortOrder]' => '1',
                'home_service_card[isActive]' => true,
            ]);
            $client->submit($cardForm);
            $this->assertResponseRedirects('/admin/inicio');

            // Verify on public homepage
            $client->request('GET', '/');
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('#servicios .section-eyebrow', 'Pilares SoftCorec');
            $this->assertSelectorTextContains('#services-title', 'Ingeniería hecha a medida');
            $this->assertSelectorCount(1, '#servicios .bento-card');
            $this->assertSelectorTextContains('#servicios .service-card-title', 'Ciberseguridad Cloud');

            // 3. Edit & Delete Service Card
            $cards = $serviceCardRepo->findAllOrdered();
            $this->assertCount(1, $cards);
            $card = $cards[0];

            $crawler = $client->request('GET', '/admin/inicio/pilares/'.$card->getId().'/editar');
            $this->assertResponseIsSuccessful();

            $editForm = $crawler->selectButton('Guardar cambios')->form([
                'home_service_card[title]' => 'Seguridad Avanzada',
            ]);
            $client->submit($editForm);
            $this->assertResponseRedirects('/admin/inicio');

            $crawler = $client->followRedirect();
            $this->assertSelectorTextContains('body', 'Seguridad Avanzada');

            $deleteForm = $crawler->filter('form[action="/admin/inicio/pilares/'.$card->getId().'/eliminar"]')->form();
            $client->submit($deleteForm);
            $this->assertResponseRedirects('/admin/inicio');

            $em->clear();
            $this->assertCount(0, $serviceCardRepo->findAll());
        } finally {
            $em->clear();
            foreach ($serviceCardRepo->findAll() as $c) {
                $em->remove($c);
            }
            foreach ($servicesConfigRepo->findAll() as $cfg) {
                $em->remove($cfg);
            }
            $cleanupUser = $userRepo->findOneByEmail($email);
            if (null !== $cleanupUser) {
                $em->remove($cleanupUser);
            }
            $em->flush();
        }
    }

    public function testAdminCanEditMethodologyHeaderAndManageSteps(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var UserRepository $userRepo */
        $userRepo = $container->get(UserRepository::class);
        /** @var HomeMethodologyConfigRepository $methodologyConfigRepo */
        $methodologyConfigRepo = $container->get(HomeMethodologyConfigRepository::class);
        /** @var HomeMethodologyStepRepository $methodologyStepRepo */
        $methodologyStepRepo = $container->get(HomeMethodologyStepRepository::class);
        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $container->get(UserPasswordHasherInterface::class);

        $email = 'test-methodology-admin@softcorec.com';
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
        $admin->setPassword($hasher->hashPassword($admin, 'MethodPass2026!'));
        $em->persist($admin);
        $em->flush();

        try {
            $client->loginUser($admin);

            // 1. Update Methodology Header
            $crawler = $client->request('GET', '/admin/inicio');
            $this->assertResponseIsSuccessful();

            $headerForm = $crawler->filter('form[name="home_methodology_config"]')->form([
                'home_methodology_config[eyebrow]' => 'Proceso Ágil',
                'home_methodology_config[title]' => 'Entregas rápidas y medibles',
                'home_methodology_config[subtitle]' => 'Acompañamiento continuo en cada iteración.',
            ]);
            $client->submit($headerForm);
            $this->assertResponseRedirects('/admin/inicio');

            // 2. Create Methodology Step
            $crawler = $client->request('GET', '/admin/inicio/metodologia/nuevo');
            $this->assertResponseIsSuccessful();

            $stepForm = $crawler->selectButton('Crear paso')->form([
                'home_methodology_step[stepNumber]' => '01',
                'home_methodology_step[title]' => 'Descubrimiento Inicial',
                'home_methodology_step[description]' => 'Definimos objetivos y arquitectura base.',
                'home_methodology_step[sortOrder]' => '1',
                'home_methodology_step[isActive]' => true,
            ]);
            $client->submit($stepForm);
            $this->assertResponseRedirects('/admin/inicio');

            // Verify on public homepage
            $client->request('GET', '/');
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('#metodologia .section-eyebrow', 'Proceso Ágil');
            $this->assertSelectorTextContains('#methodology-title', 'Entregas rápidas y medibles');
            $this->assertSelectorCount(1, '#metodologia .step-card');
            $this->assertSelectorTextContains('#metodologia .step-title', 'Descubrimiento Inicial');

            // 3. Edit & Delete Step
            $steps = $methodologyStepRepo->findAllOrdered();
            $this->assertCount(1, $steps);
            $step = $steps[0];

            $crawler = $client->request('GET', '/admin/inicio/metodologia/'.$step->getId().'/editar');
            $this->assertResponseIsSuccessful();

            $editForm = $crawler->selectButton('Guardar cambios')->form([
                'home_methodology_step[title]' => 'Arquitectura Estratégica',
            ]);
            $client->submit($editForm);
            $this->assertResponseRedirects('/admin/inicio');

            $crawler = $client->followRedirect();
            $this->assertSelectorTextContains('body', 'Arquitectura Estratégica');

            $deleteForm = $crawler->filter('form[action="/admin/inicio/metodologia/'.$step->getId().'/eliminar"]')->form();
            $client->submit($deleteForm);
            $this->assertResponseRedirects('/admin/inicio');

            $em->clear();
            $this->assertCount(0, $methodologyStepRepo->findAll());
        } finally {
            $em->clear();
            foreach ($methodologyStepRepo->findAll() as $s) {
                $em->remove($s);
            }
            foreach ($methodologyConfigRepo->findAll() as $cfg) {
                $em->remove($cfg);
            }
            $cleanupUser = $userRepo->findOneByEmail($email);
            if (null !== $cleanupUser) {
                $em->remove($cleanupUser);
            }
            $em->flush();
        }
    }
}
