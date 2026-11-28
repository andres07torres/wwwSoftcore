<?php

namespace App\Tests;

use App\Entity\SocialLinksConfig;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AdminSocialLinksControllerTest extends WebTestCase
{
    public function testAnonymousUserIsRedirectedToLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/redes-sociales');

        self::assertResponseRedirects('/login');
    }

    public function testAdminCanUpdateSocialLinksAndReflectsOnPublicPages(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $container->get(UserPasswordHasherInterface::class);

        $email = 'social-admin-'.bin2hex(random_bytes(4)).'@softcorec.test';
        $user = (new User())
            ->setEmail($email)
            ->setFullName('Social Admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setIsActive(true);
        $user->setPassword($hasher->hashPassword($user, 'AdminPass2026!'));
        $em->persist($user);
        $em->flush();

        try {
            $client->loginUser($user);

            $crawler = $client->request('GET', '/admin/redes-sociales');
            self::assertResponseIsSuccessful();

            $form = $crawler->filter('form[name="social_links_config"]')->form([
                'social_links_config[whatsappUrl]' => 'https://wa.me/593999111222',
                'social_links_config[whatsappActive]' => 1,
                'social_links_config[instagramUrl]' => 'https://instagram.com/softcorec_oficial',
                'social_links_config[instagramActive]' => 1,
                'social_links_config[facebookUrl]' => 'https://facebook.com/softcorec_oculto',
            ]);
            $form['social_links_config[facebookActive]']->untick();
            $client->submit($form);
            self::assertResponseRedirects('/admin/redes-sociales');

            $client->request('GET', '/');
            self::assertResponseIsSuccessful();
            $html = (string) $client->getResponse()->getContent();
            self::assertStringContainsString('https://wa.me/593999111222', $html);
            self::assertStringContainsString('https://instagram.com/softcorec_oficial', $html);
            self::assertStringNotContainsString('https://facebook.com/softcorec_oculto', $html);
        } finally {
            $em->clear();
            foreach ($em->getRepository(SocialLinksConfig::class)->findAll() as $row) {
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
