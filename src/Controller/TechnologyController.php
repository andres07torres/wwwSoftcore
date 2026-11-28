<?php

namespace App\Controller;

use App\Repository\TechnologyCriterionRepository;
use App\Repository\TechnologyDomainRepository;
use App\Repository\TechnologyPageConfigRepository;
use App\Repository\TechnologyPracticeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TechnologyController extends AbstractController
{
    public function __construct(
        private readonly TechnologyPageConfigRepository $pageConfigRepository,
        private readonly TechnologyCriterionRepository $criterionRepository,
        private readonly TechnologyDomainRepository $domainRepository,
        private readonly TechnologyPracticeRepository $practiceRepository,
    ) {
    }

    #[Route('/tecnologias', name: 'app_technology')]
    public function index(): Response
    {
        return $this->render('technology/index.html.twig', [
            'tech_config' => $this->pageConfigRepository->findCurrent(),
            'tech_criteria' => $this->criterionRepository->findActiveOrdered(),
            'tech_domains' => $this->domainRepository->findActiveOrdered(),
            'tech_practices' => $this->practiceRepository->findActiveOrdered(),
        ]);
    }

    #[Route('/technology', name: 'app_technology_legacy', methods: ['GET'])]
    public function legacyRedirect(): Response
    {
        return $this->redirectToRoute('app_technology', [], Response::HTTP_MOVED_PERMANENTLY);
    }
}
