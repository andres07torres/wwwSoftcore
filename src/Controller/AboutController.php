<?php

namespace App\Controller;

use App\Repository\AboutMetricCardRepository;
use App\Repository\AboutPageConfigRepository;
use App\Repository\AboutValueCardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AboutController extends AbstractController
{
    public function __construct(
        private readonly AboutPageConfigRepository $pageConfigRepository,
        private readonly AboutValueCardRepository $valueCardRepository,
        private readonly AboutMetricCardRepository $metricCardRepository,
    ) {
    }

    #[Route('/quienes-somos', name: 'app_about')]
    public function index(): Response
    {
        return $this->render('about/index.html.twig', [
            'about_config' => $this->pageConfigRepository->findCurrent(),
            'value_cards' => $this->valueCardRepository->findActiveOrdered(),
            'metric_cards' => $this->metricCardRepository->findActiveOrdered(),
        ]);
    }

    #[Route('/about', name: 'app_about_legacy', methods: ['GET'])]
    public function legacyRedirect(): Response
    {
        return $this->redirectToRoute('app_about', [], Response::HTTP_MOVED_PERMANENTLY);
    }
}
