<?php

namespace App\Controller;

use App\Repository\MethodologyPageConfigRepository;
use App\Repository\MethodologyPhaseRepository;
use App\Repository\MethodologyPillarRepository;
use App\Repository\MethodologyStandardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MethodologyController extends AbstractController
{
    public function __construct(
        private readonly MethodologyPageConfigRepository $pageConfigRepository,
        private readonly MethodologyPillarRepository $pillarRepository,
        private readonly MethodologyPhaseRepository $phaseRepository,
        private readonly MethodologyStandardRepository $standardRepository,
    ) {
    }

    #[Route('/metodologia', name: 'app_methodology')]
    public function index(): Response
    {
        return $this->render('methodology/index.html.twig', [
            'methodology_config' => $this->pageConfigRepository->findCurrent(),
            'pillars' => $this->pillarRepository->findActiveOrdered(),
            'phases' => $this->phaseRepository->findActiveOrdered(),
            'standards' => $this->standardRepository->findActiveOrdered(),
        ]);
    }

    #[Route('/methodology', name: 'app_methodology_legacy', methods: ['GET'])]
    public function legacyRedirect(): Response
    {
        return $this->redirectToRoute('app_methodology', [], Response::HTTP_MOVED_PERMANENTLY);
    }
}
