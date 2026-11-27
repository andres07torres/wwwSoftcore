<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MethodologyController extends AbstractController
{
    #[Route('/metodologia', name: 'app_methodology')]
    public function index(): Response
    {
        return $this->render('methodology/index.html.twig');
    }

    #[Route('/methodology', name: 'app_methodology_legacy', methods: ['GET'])]
    public function legacyRedirect(): Response
    {
        return $this->redirectToRoute('app_methodology', [], Response::HTTP_MOVED_PERMANENTLY);
    }
}
