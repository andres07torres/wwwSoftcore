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
    ) {
    }

    #[Route('/admin', name: 'app_admin_dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        $users = $this->userRepository->findBy([], ['createdAt' => 'DESC']);
        $activeUsersCount = count(array_filter($users, static fn ($u) => $u->isActive()));
        $adminsCount = count(array_filter($users, static fn ($u) => in_array('ROLE_ADMIN', $u->getRoles(), true)));
        $maintenanceActive = $this->maintenanceEnabled || is_file($this->projectDir.'/var/maintenance.lock');

        $homeCustomized = null !== $this->homeHeroConfigRepository->findCurrent()
            || null !== $this->homeServicesConfigRepository->findCurrent()
            || null !== $this->homeMethodologyConfigRepository->findCurrent()
            || $this->homeHeroSlideRepository->count([]) > 0
            || $this->homeServiceCardRepository->count([]) > 0
            || $this->homeMethodologyStepRepository->count([]) > 0;

        $aboutCustomized = null !== $this->aboutPageConfigRepository->findCurrent()
            || $this->aboutValueCardRepository->count([]) > 0
            || $this->aboutMetricCardRepository->count([]) > 0;

        $servicesCustomized = null !== $this->servicesPageConfigRepository->findCurrent()
            || $this->serviceCatalogItemRepository->count([]) > 0
            || $this->serviceProjectRepository->count([]) > 0
            || $this->serviceWorkflowStepRepository->count([]) > 0;

        $methodologyCustomized = null !== $this->methodologyPageConfigRepository->findCurrent()
            || $this->methodologyPillarRepository->count([]) > 0
            || $this->methodologyPhaseRepository->count([]) > 0
            || $this->methodologyStandardRepository->count([]) > 0;

        $technologyCustomized = null !== $this->technologyPageConfigRepository->findCurrent()
            || $this->technologyCriterionRepository->count([]) > 0
            || $this->technologyDomainRepository->count([]) > 0
            || $this->technologyPracticeRepository->count([]) > 0;

        $customizedPagesCount = count(array_filter([
            $homeCustomized,
            $aboutCustomized,
            $servicesCustomized,
            $methodologyCustomized,
            $technologyCustomized,
        ]));

        $itemRepositories = [
            $this->homeHeroSlideRepository,
            $this->homeServiceCardRepository,
            $this->homeMethodologyStepRepository,
            $this->aboutValueCardRepository,
            $this->aboutMetricCardRepository,
            $this->serviceCatalogItemRepository,
            $this->serviceProjectRepository,
            $this->serviceWorkflowStepRepository,
            $this->methodologyPillarRepository,
            $this->methodologyPhaseRepository,
            $this->methodologyStandardRepository,
            $this->technologyCriterionRepository,
            $this->technologyDomainRepository,
            $this->technologyPracticeRepository,
        ];

        $publishedItemsCount = 0;
        $totalItemsCount = 0;
        foreach ($itemRepositories as $repo) {
            $publishedItemsCount += $repo->count(['isActive' => true]);
            $totalItemsCount += $repo->count([]);
        }

        return $this->render('admin/dashboard.html.twig', [
            'total_pages' => 5,
            'customized_pages' => $customizedPagesCount,
            'published_items' => $publishedItemsCount,
            'total_items' => $totalItemsCount,
            'total_users' => count($users),
            'active_users' => $activeUsersCount,
            'admins_count' => $adminsCount,
            'maintenance_active' => $maintenanceActive,
        ]);
    }
}
