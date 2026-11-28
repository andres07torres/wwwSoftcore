<?php

namespace App\Controller;

use App\Repository\HomeHeroConfigRepository;
use App\Repository\HomeHeroSlideRepository;
use App\Repository\HomeMethodologyConfigRepository;
use App\Repository\HomeMethodologyStepRepository;
use App\Repository\HomeServiceCardRepository;
use App\Repository\HomeServicesConfigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    public function __construct(
        private readonly HomeHeroConfigRepository $heroConfigRepository,
        private readonly HomeHeroSlideRepository $heroSlideRepository,
        private readonly HomeServicesConfigRepository $servicesConfigRepository,
        private readonly HomeServiceCardRepository $serviceCardRepository,
        private readonly HomeMethodologyConfigRepository $methodologyConfigRepository,
        private readonly HomeMethodologyStepRepository $methodologyStepRepository,
    ) {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'hero_config' => $this->heroConfigRepository->findCurrent(),
            'hero_slides' => $this->heroSlideRepository->findActiveOrdered(),
            'services_config' => $this->servicesConfigRepository->findCurrent(),
            'service_cards' => $this->serviceCardRepository->findActiveOrdered(),
            'methodology_config' => $this->methodologyConfigRepository->findCurrent(),
            'methodology_steps' => $this->methodologyStepRepository->findActiveOrdered(),
        ]);
    }
}
