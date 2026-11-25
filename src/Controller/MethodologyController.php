<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MethodologyController extends AbstractController
{
    #[Route('/methodology', name: 'app_methodology')]
    #[Route('/metodologia', name: 'app_methodology_es')]
    public function index(): Response
    {
        return $this->render('methodology/index.html.twig');
    }
}
