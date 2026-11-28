<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/perfil')]
final class AdminProfileController extends AbstractController
{
    private const AVATAR_PREFIX = '/uploads/avatars/';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        #[Autowire('%kernel.project_dir%/public/uploads/avatars')]
        private readonly string $avatarDir,
    ) {
    }

    #[Route('', name: 'app_admin_profile', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        if ($request->isMethod('POST')) {
            $action = (string) $request->request->get('_action', '');
            $token = (string) $request->request->get('_token', '');

            if (!$this->isCsrfTokenValid('admin_profile_'.$action, $token)) {
                $this->addFlash('error', 'Token de seguridad inválido. Intenta nuevamente.');

                return $this->redirectToRoute('app_admin_profile');
            }

            if ('profile' === $action) {
                $fullName = trim((string) $request->request->get('full_name', ''));
                $email = mb_strtolower(trim((string) $request->request->get('email', '')));

                if ('' === $fullName || !filter_var($email, \FILTER_VALIDATE_EMAIL)) {
                    $this->addFlash('error', 'Ingresa un nombre y correo electrónico válidos.');
                } else {
                    $user->setFullName($fullName);
                    $user->setEmail($email);
                    $this->entityManager->flush();
                    $this->addFlash('success', 'Datos de perfil actualizados correctamente.');
                }

                return $this->redirectToRoute('app_admin_profile');
            }

            if ('avatar' === $action) {
                /** @var UploadedFile|null $file */
                $file = $request->files->get('avatar');
                if (!$file instanceof UploadedFile || !$file->isValid()) {
                    $this->addFlash('error', 'Selecciona una imagen válida (WebP, JPG o PNG).');

                    return $this->redirectToRoute('app_admin_profile', ['_fragment' => 'foto']);
                }

                $mime = $file->getMimeType() ?? '';
                if (!in_array($mime, ['image/webp', 'image/jpeg', 'image/png'], true) || $file->getSize() > 3 * 1024 * 1024) {
                    $this->addFlash('error', 'La foto debe ser WebP, JPG o PNG y pesar máximo 3 MB.');

                    return $this->redirectToRoute('app_admin_profile', ['_fragment' => 'foto']);
                }

                if (!is_dir($this->avatarDir)) {
                    mkdir($this->avatarDir, 0775, true);
                }

                $oldAvatar = $user->getAvatarPath();
                $ext = $file->guessExtension() ?: 'png';
                $fileName = sprintf('avatar-%d-%s.%s', $user->getId() ?? 0, bin2hex(random_bytes(4)), $ext);
                $file->move($this->avatarDir, $fileName);

                $user->setAvatarPath(self::AVATAR_PREFIX.$fileName);
                $this->entityManager->flush();

                if (null !== $oldAvatar && str_starts_with($oldAvatar, self::AVATAR_PREFIX)) {
                    $oldFullPath = $this->avatarDir.\DIRECTORY_SEPARATOR.basename($oldAvatar);
                    if (is_file($oldFullPath)) {
                        @unlink($oldFullPath);
                    }
                }

                $this->addFlash('success', 'Foto de perfil actualizada correctamente.');

                return $this->redirectToRoute('app_admin_profile', ['_fragment' => 'foto']);
            }

            if ('password' === $action) {
                $currentPassword = (string) $request->request->get('current_password', '');
                $newPassword = (string) $request->request->get('new_password', '');
                $confirmPassword = (string) $request->request->get('confirm_password', '');

                if (!$this->passwordHasher->isPasswordValid($user, $currentPassword)) {
                    $this->addFlash('error', 'La contraseña actual no es correcta.');
                } elseif (mb_strlen($newPassword) < 8) {
                    $this->addFlash('error', 'La nueva contraseña debe tener al menos 8 caracteres.');
                } elseif ($newPassword !== $confirmPassword) {
                    $this->addFlash('error', 'La confirmación de contraseña no coincide.');
                } else {
                    $user->setPassword($this->passwordHasher->hashPassword($user, $newPassword));
                    $this->entityManager->flush();
                    $this->addFlash('success', 'Contraseña actualizada correctamente.');
                }

                return $this->redirectToRoute('app_admin_profile', ['_fragment' => 'contrasena']);
            }
        }

        return $this->render('admin/profile/index.html.twig', [
            'user' => $user,
        ]);
    }
}
