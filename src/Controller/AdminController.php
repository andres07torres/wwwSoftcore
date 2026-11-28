<?php

namespace App\Controller;

use App\Repository\AboutMetricCardRepository;
use App\Repository\AboutPageConfigRepository;
use App\Repository\AboutValueCardRepository;
use App\Repository\HomeHeroConfigRepository;
use App\Repository\HomeHeroSlideRepository;
use App\Repository\HomeMethodologyConfigRepository;
use App\Repository\HomeMethodologyStepRepository;
use App\Repository\HomeServiceCardRepository;
use App\Repository\HomeServicesConfigRepository;
use App\Repository\MethodologyPageConfigRepository;
use App\Repository\MethodologyPhaseRepository;
use App\Repository\MethodologyPillarRepository;
use App\Repository\MethodologyStandardRepository;
use App\Repository\ServiceCatalogItemRepository;
use App\Repository\ServiceProjectRepository;
use App\Repository\ServicesPageConfigRepository;
use App\Repository\ServiceWorkflowStepRepository;
use App\Repository\TechnologyCriterionRepository;
use App\Repository\TechnologyDomainRepository;
use App\Repository\TechnologyPageConfigRepository;
use App\Repository\TechnologyPracticeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly HomeHeroConfigRepository $homeHeroConfigRepository,
        private readonly HomeHeroSlideRepository $homeHeroSlideRepository,
        private readonly HomeServicesConfigRepository $homeServicesConfigRepository,
        private readonly HomeServiceCardRepository $homeServiceCardRepository,
        private readonly HomeMethodologyConfigRepository $homeMethodologyConfigRepository,
        private readonly HomeMethodologyStepRepository $homeMethodologyStepRepository,
        private readonly AboutPageConfigRepository $aboutPageConfigRepository,
        private readonly AboutValueCardRepository $aboutValueCardRepository,
        private readonly AboutMetricCardRepository $aboutMetricCardRepository,
        private readonly ServicesPageConfigRepository $servicesPageConfigRepository,
        private readonly ServiceCatalogItemRepository $serviceCatalogItemRepository,
        private readonly ServiceProjectRepository $serviceProjectRepository,
        private readonly ServiceWorkflowStepRepository $serviceWorkflowStepRepository,
        private readonly MethodologyPageConfigRepository $methodologyPageConfigRepository,
        private readonly MethodologyPillarRepository $methodologyPillarRepository,
        private readonly MethodologyPhaseRepository $methodologyPhaseRepository,
        private readonly MethodologyStandardRepository $methodologyStandardRepository,
        private readonly TechnologyPageConfigRepository $technologyPageConfigRepository,
        private readonly TechnologyCriterionRepository $technologyCriterionRepository,
        private readonly TechnologyDomainRepository $technologyDomainRepository,
        private readonly TechnologyPracticeRepository $technologyPracticeRepository,
        #[Autowire('%env(bool:APP_MAINTENANCE)%')]
        private readonly bool $maintenanceEnabled,
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
        #[Autowire('%kernel.environment%')]
        private readonly string $appEnv,
    ) {
    }

    #[Route('/admin', name: 'app_admin_dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        $users = $this->userRepository->findBy([], ['createdAt' => 'DESC']);
        $activeUsersCount = count(array_filter($users, static fn ($u) => $u->isActive()));
        $adminsCount = count(array_filter($users, static fn ($u) => in_array('ROLE_ADMIN', $u->getRoles(), true)));
        $lockFileExists = is_file($this->getMaintenanceLockPath());
        $maintenanceActive = $this->maintenanceEnabled || $lockFileExists;

        $homeHeroCfg = $this->homeHeroConfigRepository->findCurrent();
        $homeServicesCfg = $this->homeServicesConfigRepository->findCurrent();
        $homeMethodCfg = $this->homeMethodologyConfigRepository->findCurrent();
        $aboutCfg = $this->aboutPageConfigRepository->findCurrent();
        $servicesCfg = $this->servicesPageConfigRepository->findCurrent();
        $methodologyCfg = $this->methodologyPageConfigRepository->findCurrent();
        $technologyCfg = $this->technologyPageConfigRepository->findCurrent();

        $homeActive = $this->homeHeroSlideRepository->count(['isActive' => true])
            + $this->homeServiceCardRepository->count(['isActive' => true])
            + $this->homeMethodologyStepRepository->count(['isActive' => true]);
        $homeTotal = $this->homeHeroSlideRepository->count([])
            + $this->homeServiceCardRepository->count([])
            + $this->homeMethodologyStepRepository->count([]);

        $aboutActive = $this->aboutValueCardRepository->count(['isActive' => true])
            + $this->aboutMetricCardRepository->count(['isActive' => true]);
        $aboutTotal = $this->aboutValueCardRepository->count([])
            + $this->aboutMetricCardRepository->count([]);

        $servicesActive = $this->serviceCatalogItemRepository->count(['isActive' => true])
            + $this->serviceProjectRepository->count(['isActive' => true])
            + $this->serviceWorkflowStepRepository->count(['isActive' => true]);
        $servicesTotal = $this->serviceCatalogItemRepository->count([])
            + $this->serviceProjectRepository->count([])
            + $this->serviceWorkflowStepRepository->count([]);

        $methodologyActive = $this->methodologyPillarRepository->count(['isActive' => true])
            + $this->methodologyPhaseRepository->count(['isActive' => true])
            + $this->methodologyStandardRepository->count(['isActive' => true]);
        $methodologyTotal = $this->methodologyPillarRepository->count([])
            + $this->methodologyPhaseRepository->count([])
            + $this->methodologyStandardRepository->count([]);

        $technologyActive = $this->technologyCriterionRepository->count(['isActive' => true])
            + $this->technologyDomainRepository->count(['isActive' => true])
            + $this->technologyPracticeRepository->count(['isActive' => true]);
        $technologyTotal = $this->technologyCriterionRepository->count([])
            + $this->technologyDomainRepository->count([])
            + $this->technologyPracticeRepository->count([]);

        $pagesOverview = [
            [
                'name' => 'Inicio',
                'active_items' => $homeActive,
                'total_items' => $homeTotal,
                'customized' => null !== $homeHeroCfg || null !== $homeServicesCfg || null !== $homeMethodCfg || $homeTotal > 0,
                'updated_at' => $this->latestDate([
                    $homeHeroCfg?->getUpdatedAt(),
                    $homeServicesCfg?->getUpdatedAt(),
                    $homeMethodCfg?->getUpdatedAt(),
                ]),
                'edit_route' => 'app_admin_home',
                'public_route' => 'app_home',
            ],
            [
                'name' => 'Quiénes Somos',
                'active_items' => $aboutActive,
                'total_items' => $aboutTotal,
                'customized' => null !== $aboutCfg || $aboutTotal > 0,
                'updated_at' => $aboutCfg?->getUpdatedAt(),
                'edit_route' => 'app_admin_about',
                'public_route' => 'app_about',
            ],
            [
                'name' => 'Servicios',
                'active_items' => $servicesActive,
                'total_items' => $servicesTotal,
                'customized' => null !== $servicesCfg || $servicesTotal > 0,
                'updated_at' => $servicesCfg?->getUpdatedAt(),
                'edit_route' => 'app_admin_services',
                'public_route' => 'app_services',
            ],
            [
                'name' => 'Metodología',
                'active_items' => $methodologyActive,
                'total_items' => $methodologyTotal,
                'customized' => null !== $methodologyCfg || $methodologyTotal > 0,
                'updated_at' => $methodologyCfg?->getUpdatedAt(),
                'edit_route' => 'app_admin_methodology',
                'public_route' => 'app_methodology',
            ],
            [
                'name' => 'Tecnologías',
                'active_items' => $technologyActive,
                'total_items' => $technologyTotal,
                'customized' => null !== $technologyCfg || $technologyTotal > 0,
                'updated_at' => $technologyCfg?->getUpdatedAt(),
                'edit_route' => 'app_admin_technology',
                'public_route' => 'app_technology',
            ],
        ];

        $customizedPagesCount = count(array_filter($pagesOverview, static fn (array $p): bool => $p['customized']));
        $publishedItemsCount = array_sum(array_column($pagesOverview, 'active_items'));
        $totalItemsCount = array_sum(array_column($pagesOverview, 'total_items'));
        $maxActiveItems = max(1, max(array_column($pagesOverview, 'active_items')));

        foreach ($pagesOverview as &$page) {
            $page['bar_pct'] = $page['active_items'] > 0
                ? (int) round(($page['active_items'] / $maxActiveItems) * 100)
                : 0;
        }
        unset($page);

        return $this->render('admin/dashboard.html.twig', [
            'total_pages' => count($pagesOverview),
            'customized_pages' => $customizedPagesCount,
            'published_items' => $publishedItemsCount,
            'total_items' => $totalItemsCount,
            'total_users' => count($users),
            'active_users' => $activeUsersCount,
            'admins_count' => $adminsCount,
            'maintenance_active' => $maintenanceActive,
            'maintenance_env_forced' => $this->maintenanceEnabled,
            'pages_overview' => $pagesOverview,
            'app_env' => $this->appEnv,
            'php_version' => \PHP_VERSION,
        ]);
    }

    #[Route('/admin/mantenimiento', name: 'app_admin_maintenance_toggle', methods: ['POST'])]
    public function toggleMaintenance(Request $request): Response
    {
        if (!$this->isCsrfTokenValid('admin_toggle_maintenance', (string) $request->request->get('_token', ''))) {
            $this->addFlash('error', 'Token de seguridad inválido.');

            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($this->maintenanceEnabled) {
            $this->addFlash('error', 'El modo mantenimiento está forzado por la variable de entorno APP_MAINTENANCE.');

            return $this->redirectToRoute('app_admin_dashboard');
        }

        $lockPath = $this->getMaintenanceLockPath();
        if (is_file($lockPath)) {
            @unlink($lockPath);
            $this->addFlash('success', 'Modo mantenimiento desactivado. El portal vuelve a estar operativo.');
        } else {
            $dir = \dirname($lockPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }
            file_put_contents($lockPath, (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM));
            $this->addFlash('success', 'Modo mantenimiento activado. Los visitantes verán la pantalla de mantenimiento.');
        }

        return $this->redirectToRoute('app_admin_dashboard');
    }

    private function getMaintenanceLockPath(): string
    {
        return $this->projectDir.'/var/maintenance.lock';
    }

    /**
     * @param list<\DateTimeImmutable|null> $dates
     */
    private function latestDate(array $dates): ?\DateTimeImmutable
    {
        $valid = array_values(array_filter($dates, static fn (?\DateTimeImmutable $d): bool => null !== $d));
        if ([] === $valid) {
            return null;
        }
        usort($valid, static fn (\DateTimeImmutable $a, \DateTimeImmutable $b): int => $b <=> $a);

        return $valid[0];
    }
}
