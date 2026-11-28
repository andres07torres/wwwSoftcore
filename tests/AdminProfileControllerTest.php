<?php

namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AdminProfileControllerTest extends WebTestCase
{
    public function testAnonymousUserIsRedirectedToLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/perfil');

        self::assertResponseRedirects('/login');
    }

    public function testAdminCanUpdateProfileAvatarAndPassword(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $container->get(UserPasswordHasherInterface::class);

        $email = 'profile-admin-'.bin2hex(random_bytes(4)).'@softcorec.test';
        $updatedEmail = 'profile-updated-'.bin2hex(random_bytes(4)).'@softcorec.test';
        $user = (new User())
            ->setEmail($email)
            ->setFullName('Admin Inicial')
            ->setRoles(['ROLE_ADMIN'])
            ->setIsActive(true);
        $user->setPassword($hasher->hashPassword($user, 'InitialPass2026!'));
        $em->persist($user);
        $em->flush();

        $tmpPng = sys_get_temp_dir().\DIRECTORY_SEPARATOR.'sc-avatar-'.bin2hex(random_bytes(4)).'.png';
        // Minimal valid 1x1 PNG
        file_put_contents($tmpPng, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII='));

        try {
            $client->loginUser($user);

            // 1. Update profile info
            $crawler = $client->request('GET', '/admin/perfil');
            self::assertResponseIsSuccessful();

            $profileForm = $crawler->filter('#perfil form')->form([
                'full_name' => 'Carlos Administrador',
                'email' => $updatedEmail,
            ]);
            $client->submit($profileForm);
            self::assertResponseRedirects('/admin/perfil#perfil');

            $em->clear();
            $reloaded = $em->getRepository(User::class)->findOneBy(['email' => $updatedEmail]);
            self::assertNotNull($reloaded);
            self::assertSame('Carlos Administrador', $reloaded->getFullName());

            // Re-login with refreshed user identifier
            $client->loginUser($reloaded);

            // 2. Upload avatar
            $crawler = $client->request('GET', '/admin/perfil');
            $uploaded = new UploadedFile($tmpPng, 'avatar.png', 'image/png', null, true);
            $avatarForm = $crawler->filter('#foto form[enctype="multipart/form-data"]')->form();
            $avatarForm['avatar']->upload($uploaded->getPathname());
            $client->submit($avatarForm);
            self::assertResponseRedirects('/admin/perfil#foto');

            $em->clear();
            $reloaded = $em->getRepository(User::class)->findOneBy(['email' => $updatedEmail]);
            self::assertNotNull($reloaded?->getAvatarPath());
            self::assertStringStartsWith('/uploads/avatars/', (string) $reloaded->getAvatarPath());

            // Delete avatar
            $client->loginUser($reloaded);
            $crawler = $client->request('GET', '/admin/perfil');
            $deleteForm = $crawler->filter('#foto form:not([enctype])')->form();
            $client->submit($deleteForm);
            self::assertResponseRedirects('/admin/perfil#foto');

            $em->clear();
            $reloaded = $em->getRepository(User::class)->findOneBy(['email' => $updatedEmail]);
            self::assertNull($reloaded?->getAvatarPath());

            // 3. Change password
            $client->loginUser($reloaded);
            $crawler = $client->request('GET', '/admin/perfil');
            $passwordForm = $crawler->filter('#contrasena form')->form([
                'current_password' => 'InitialPass2026!',
                'new_password' => 'NewSecurePass2026!',
                'confirm_password' => 'NewSecurePass2026!',
            ]);
            $client->submit($passwordForm);
            self::assertResponseRedirects('/admin/perfil#contrasena');

            $em->clear();
            $reloaded = $em->getRepository(User::class)->findOneBy(['email' => $updatedEmail]);
            self::assertNotNull($reloaded);
            self::assertTrue($hasher->isPasswordValid($reloaded, 'NewSecurePass2026!'));
        } finally {
            if (is_file($tmpPng)) {
                @unlink($tmpPng);
            }
            $em->clear();
            foreach ([$email, $updatedEmail] as $candidate) {
                $managed = $em->getRepository(User::class)->findOneBy(['email' => $candidate]);
                if (null !== $managed) {
                    $em->remove($managed);
                }
            }
            $em->flush();
        }
    }
}
