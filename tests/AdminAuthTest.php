<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AdminAuthTest extends WebTestCase
{
    public function testLoginPageLoadsSuccessfully(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[action="/login"]');
        $this->assertSelectorExists('input[name="_username"]');
        $this->assertSelectorExists('input[name="_password"]');
        $this->assertSelectorExists('input[name="_csrf_token"]');
        $this->assertSelectorTextContains('h1', 'Iniciar sesión');
    }

    public function testAdminRedirectsToLoginWhenUnauthenticated(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin');

        $this->assertResponseRedirects('/login');
    }

    public function testInvalidCredentialsShowErrorMessage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Ingresar al panel')->form([
            '_username' => 'noexiste@softcorec.com',
            '_password' => 'WrongPassword123!',
        ]);
        $client->submit($form);
        $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.sc-login-alert');
        $this->assertSelectorTextContains('.sc-login-alert', 'Credenciales inválidas');
    }

    public function testAdminCanLoginAccessDashboardAndLogout(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var UserRepository $userRepo */
        $userRepo = $container->get(UserRepository::class);
        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $container->get(UserPasswordHasherInterface::class);

        $email = 'test-admin@softcorec.com';
        $existing = $userRepo->findOneByEmail($email);
        if (null !== $existing) {
            $em->remove($existing);
            $em->flush();
        }

        $admin = new User();
        $admin->setEmail($email);
        $admin->setFullName('Admin Prueba');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsActive(true);
        $admin->setPassword($hasher->hashPassword($admin, 'TestPass2026!'));
        $em->persist($admin);
        $em->flush();

        try {
            $crawler = $client->request('GET', '/login');
            $form = $crawler->selectButton('Ingresar al panel')->form([
                '_username' => $email,
                '_password' => 'TestPass2026!',
            ]);
            $client->submit($form);
            $this->assertResponseRedirects('/admin');

            $client->followRedirect();
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('h1', 'Dashboard');
            $this->assertSelectorTextContains('.sc-user-menu-email', $email);

            $client->request('GET', '/logout');
            $this->assertResponseRedirects('/login');

            $client->request('GET', '/admin');
            $this->assertResponseRedirects('/login');
        } finally {
            $cleanupUser = $userRepo->findOneByEmail($email);
            if (null !== $cleanupUser) {
                $em->remove($cleanupUser);
                $em->flush();
            }
        }
    }
}
