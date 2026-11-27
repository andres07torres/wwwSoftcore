<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AboutController extends AbstractController
{
    #[Route('/quienes-somos', name: 'app_about')]
    public function index(): Response
    {
        return $this->render('about/index.html.twig');
    }

    #[Route('/about', name: 'app_about_legacy', methods: ['GET'])]
    public function legacyRedirect(): Response
    {
        return $this->redirectToRoute('app_about', [], Response::HTTP_MOVED_PERMANENTLY);
    }
}
