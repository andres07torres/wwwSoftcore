<?php

namespace App\Controller;

use App\Entity\ServiceProject;
use App\Repository\ServiceCatalogItemRepository;
use App\Repository\ServiceProjectRepository;
use App\Repository\ServicesPageConfigRepository;
use App\Repository\ServiceWorkflowStepRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServicesController extends AbstractController
{
    public function __construct(
        private readonly ServicesPageConfigRepository $pageConfigRepository,
        private readonly ServiceCatalogItemRepository $catalogRepository,
        private readonly ServiceProjectRepository $projectRepository,
        private readonly ServiceWorkflowStepRepository $workflowRepository,
    ) {
    }

    #[Route('/servicios', name: 'app_services', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $name = trim((string) $request->request->get('name'));
            $email = trim((string) $request->request->get('email'));

            if (!empty($name) && !empty($email) && filter_var($email, \FILTER_VALIDATE_EMAIL)) {
                $this->addFlash('success', '¡Gracias por escribirnos! Tu solicitud ha sido recibida correctamente. Un arquitecto de soluciones de SoftCorec te responderá en menos de 24 horas.');
            } else {
                $this->addFlash('error', 'Por favor completa tu nombre y un correo electrónico corporativo válido.');
            }

            return $this->redirectToRoute('app_services', ['_fragment' => 'formulario-contacto']);
        }

        $activeProjects = $this->projectRepository->findActiveOrdered();
        $params = [
            'services_config' => $this->pageConfigRepository->findCurrent(),
            'catalog_items' => $this->catalogRepository->findActiveOrdered(),
            'workflow_steps' => $this->workflowRepository->findActiveOrdered(),
        ];

        if ([] !== $activeProjects) {
            $params['projects'] = array_map(
                static fn (ServiceProject $p): array => $p->toTemplateArray(),
                $activeProjects
            );
        }

        return $this->render('services/index.html.twig', $params);
    }

    #[Route('/services', name: 'app_services_legacy', methods: ['GET'])]
    public function legacyRedirect(): Response
    {
        return $this->redirectToRoute('app_services', [], Response::HTTP_MOVED_PERMANENTLY);
    }
}
