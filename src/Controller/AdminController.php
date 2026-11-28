<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        #[Autowire('%env(bool:APP_MAINTENANCE)%')]
        private readonly bool $maintenanceEnabled,
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
    ) {
    }

    #[Route('/admin', name: 'app_admin_dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        $users = $this->userRepository->findBy([], ['createdAt' => 'DESC']);
        $activeUsersCount = count(array_filter($users, static fn ($u) => $u->isActive()));
        $adminsCount = count(array_filter($users, static fn ($u) => in_array('ROLE_ADMIN', $u->getRoles(), true)));
        $maintenanceActive = $this->maintenanceEnabled || is_file($this->projectDir.'/var/maintenance.lock');

        return $this->render('admin/dashboard.html.twig', [
            'users' => $users,
            'total_users' => count($users),
            'active_users' => $activeUsersCount,
            'admins_count' => $adminsCount,
            'maintenance_active' => $maintenanceActive,
        ]);
    }
}
