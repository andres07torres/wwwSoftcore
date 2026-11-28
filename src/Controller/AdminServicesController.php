<?php

namespace App\Controller;

use App\Entity\ServiceCatalogItem;
use App\Entity\ServiceProject;
use App\Entity\ServicesPageConfig;
use App\Entity\ServiceWorkflowStep;
use App\Form\ServiceCatalogItemType;
use App\Form\ServiceProjectType;
use App\Form\ServicesCatalogHeaderType;
use App\Form\ServicesContactType;
use App\Form\ServicesHeroType;
use App\Form\ServicesProjectsHeaderType;
use App\Form\ServicesWorkflowHeaderType;
use App\Form\ServiceWorkflowStepType;
use App\Repository\ServiceCatalogItemRepository;
use App\Repository\ServiceProjectRepository;
use App\Repository\ServicesPageConfigRepository;
use App\Repository\ServiceWorkflowStepRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/servicios')]
final class AdminServicesController extends AbstractController
{
    private const IMAGE_PREFIX = '/uploads/services/';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ServicesPageConfigRepository $pageConfigRepository,
        private readonly ServiceCatalogItemRepository $catalogRepository,
        private readonly ServiceProjectRepository $projectRepository,
        private readonly ServiceWorkflowStepRepository $workflowRepository,
        private readonly SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/public/uploads/services')]
        private readonly string $uploadDir,
    ) {
    }

    #[Route('', name: 'app_admin_services', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $config = $this->pageConfigRepository->findCurrent() ?? new ServicesPageConfig();

        $heroForm = $this->createForm(ServicesHeroType::class, $config);
        $heroForm->handleRequest($request);
        if ($heroForm->isSubmitted() && $heroForm->isValid()) {
            /** @var UploadedFile|null $imageFile */
            $imageFile = $heroForm->get('heroImageFile')->getData();
            if ($imageFile instanceof UploadedFile) {
                $oldPath = $config->getHeroImagePath();
                $config->setHeroImagePath($this->uploadImage($imageFile, 'services-hero'));
                $this->deleteManagedImage($oldPath);
            }

            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'El Hero de Servicios se guardó correctamente.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-hero']);
        }

        $catalogHeaderForm = $this->createForm(ServicesCatalogHeaderType::class, $config);
        $catalogHeaderForm->handleRequest($request);
        if ($catalogHeaderForm->isSubmitted() && $catalogHeaderForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'El encabezado de Nuestro Portafolio se guardó correctamente.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-portafolio']);
        }

        $projectsHeaderForm = $this->createForm(ServicesProjectsHeaderType::class, $config);
        $projectsHeaderForm->handleRequest($request);
        if ($projectsHeaderForm->isSubmitted() && $projectsHeaderForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'El encabezado de Proyectos Realizados se guardó correctamente.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-proyectos']);
        }

        $workflowHeaderForm = $this->createForm(ServicesWorkflowHeaderType::class, $config);
        $workflowHeaderForm->handleRequest($request);
        if ($workflowHeaderForm->isSubmitted() && $workflowHeaderForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'El encabezado de Cómo Trabajamos se guardó correctamente.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-workflow']);
        }

        $contactForm = $this->createForm(ServicesContactType::class, $config);
        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'La sección de Contacto & Asesoría se guardó correctamente.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-contacto']);
        }

        $catalogItems = $this->catalogRepository->findAllOrdered();
        $projects = $this->projectRepository->findAllOrdered();
        $workflowSteps = $this->workflowRepository->findAllOrdered();

        $newCatalogForm = $this->createForm(
            ServiceCatalogItemType::class,
            (new ServiceCatalogItem())->setSortOrder(count($catalogItems) + 1),
            ['action' => $this->generateUrl('app_admin_services_catalog_new')]
        );

        $newProjectForm = $this->createForm(
            ServiceProjectType::class,
            (new ServiceProject())->setSortOrder(count($projects) + 1),
            ['action' => $this->generateUrl('app_admin_services_project_new')]
        );

        $nextStepOrder = count($workflowSteps) + 1;
        $newWorkflowForm = $this->createForm(
            ServiceWorkflowStepType::class,
            (new ServiceWorkflowStep())
                ->setSortOrder($nextStepOrder)
                ->setStepNumber(str_pad((string) $nextStepOrder, 2, '0', \STR_PAD_LEFT)),
            ['action' => $this->generateUrl('app_admin_services_workflow_new')]
        );

        return $this->render('admin/services/index.html.twig', [
            'config' => $config,
            'hero_form' => $heroForm,
            'catalog_header_form' => $catalogHeaderForm,
            'projects_header_form' => $projectsHeaderForm,
            'workflow_header_form' => $workflowHeaderForm,
            'contact_form' => $contactForm,
            'catalog_items' => $catalogItems,
            'new_catalog_form' => $newCatalogForm,
            'projects' => $projects,
            'new_project_form' => $newProjectForm,
            'workflow_steps' => $workflowSteps,
            'new_workflow_form' => $newWorkflowForm,
        ]);
    }

    #[Route('/portafolio/nuevo', name: 'app_admin_services_catalog_new', methods: ['GET', 'POST'])]
    public function newCatalogItem(Request $request): Response
    {
        $item = (new ServiceCatalogItem())->setSortOrder(count($this->catalogRepository->findAll()) + 1);
        $form = $this->createForm(ServiceCatalogItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($item);
            $this->entityManager->flush();
            $this->addFlash('success', 'Servicio agregado al portafolio.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-portafolio']);
        }

        return $this->render('admin/services/catalog_form.html.twig', [
            'form' => $form,
            'item' => $item,
            'is_edit' => false,
        ]);
    }

    #[Route('/portafolio/{id}/editar', name: 'app_admin_services_catalog_edit', methods: ['GET', 'POST'])]
    public function editCatalogItem(ServiceCatalogItem $item, Request $request): Response
    {
        $form = $this->createForm(ServiceCatalogItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Servicio actualizado correctamente.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-portafolio']);
        }

        return $this->render('admin/services/catalog_form.html.twig', [
            'form' => $form,
            'item' => $item,
            'is_edit' => true,
        ]);
    }

    #[Route('/portafolio/{id}/eliminar', name: 'app_admin_services_catalog_delete', methods: ['POST'])]
    public function deleteCatalogItem(ServiceCatalogItem $item, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('delete_service_catalog_'.$item->getId(), (string) $request->request->get('_token', ''))) {
            $this->addFlash('error', 'Token de seguridad inválido.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-portafolio']);
        }

        $this->entityManager->remove($item);
        $this->entityManager->flush();
        $this->addFlash('success', 'Servicio eliminado del portafolio.');

        return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-portafolio']);
    }

    #[Route('/proyectos/nuevo', name: 'app_admin_services_project_new', methods: ['GET', 'POST'])]
    public function newProject(Request $request): Response
    {
        $project = (new ServiceProject())->setSortOrder(count($this->projectRepository->findAll()) + 1);
        $form = $this->createForm(ServiceProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $imageFile */
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile instanceof UploadedFile) {
                $project->setImagePath($this->uploadImage($imageFile, 'project'));
            }

            $this->entityManager->persist($project);
            $this->entityManager->flush();
            $this->addFlash('success', 'Proyecto agregado al carrusel.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-proyectos']);
        }

        return $this->render('admin/services/project_form.html.twig', [
            'form' => $form,
            'project' => $project,
            'is_edit' => false,
        ]);
    }

    #[Route('/proyectos/{id}/editar', name: 'app_admin_services_project_edit', methods: ['GET', 'POST'])]
    public function editProject(ServiceProject $project, Request $request): Response
    {
        $form = $this->createForm(ServiceProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $imageFile */
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile instanceof UploadedFile) {
                $oldPath = $project->getImagePath();
                $project->setImagePath($this->uploadImage($imageFile, 'project'));
                $this->deleteManagedImage($oldPath);
            }

            $this->entityManager->flush();
            $this->addFlash('success', 'Proyecto actualizado correctamente.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-proyectos']);
        }

        return $this->render('admin/services/project_form.html.twig', [
            'form' => $form,
            'project' => $project,
            'is_edit' => true,
        ]);
    }

    #[Route('/proyectos/{id}/eliminar', name: 'app_admin_services_project_delete', methods: ['POST'])]
    public function deleteProject(ServiceProject $project, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('delete_service_project_'.$project->getId(), (string) $request->request->get('_token', ''))) {
            $this->addFlash('error', 'Token de seguridad inválido.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-proyectos']);
        }

        $oldPath = $project->getImagePath();
        $this->entityManager->remove($project);
        $this->entityManager->flush();
        $this->deleteManagedImage($oldPath);
        $this->addFlash('success', 'Proyecto eliminado del carrusel.');

        return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-proyectos']);
    }

    #[Route('/workflow/nuevo', name: 'app_admin_services_workflow_new', methods: ['GET', 'POST'])]
    public function newWorkflowStep(Request $request): Response
    {
        $nextOrder = count($this->workflowRepository->findAll()) + 1;
        $step = (new ServiceWorkflowStep())
            ->setSortOrder($nextOrder)
            ->setStepNumber(str_pad((string) $nextOrder, 2, '0', \STR_PAD_LEFT));
        $form = $this->createForm(ServiceWorkflowStepType::class, $step);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($step);
            $this->entityManager->flush();
            $this->addFlash('success', 'Paso agregado correctamente.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-workflow']);
        }

        return $this->render('admin/services/workflow_form.html.twig', [
            'form' => $form,
            'step' => $step,
            'is_edit' => false,
        ]);
    }

    #[Route('/workflow/{id}/editar', name: 'app_admin_services_workflow_edit', methods: ['GET', 'POST'])]
    public function editWorkflowStep(ServiceWorkflowStep $step, Request $request): Response
    {
        $form = $this->createForm(ServiceWorkflowStepType::class, $step);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Paso actualizado correctamente.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-workflow']);
        }

        return $this->render('admin/services/workflow_form.html.twig', [
            'form' => $form,
            'step' => $step,
            'is_edit' => true,
        ]);
    }

    #[Route('/workflow/{id}/eliminar', name: 'app_admin_services_workflow_delete', methods: ['POST'])]
    public function deleteWorkflowStep(ServiceWorkflowStep $step, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('delete_service_workflow_'.$step->getId(), (string) $request->request->get('_token', ''))) {
            $this->addFlash('error', 'Token de seguridad inválido.');

            return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-workflow']);
        }

        $this->entityManager->remove($step);
        $this->entityManager->flush();
        $this->addFlash('success', 'Paso eliminado correctamente.');

        return $this->redirectToRoute('app_admin_services', ['_fragment' => 'sec-workflow']);
    }

    private function uploadImage(UploadedFile $file, string $prefix): string
    {
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0775, true);
        }

        $originalName = pathinfo($file->getClientOriginalName(), \PATHINFO_FILENAME);
        $safeName = (string) $this->slugger->slug($originalName)->lower();
        if ('' === $safeName) {
            $safeName = $prefix;
        }

        $ext = $file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'webp';
        $fileName = sprintf('%s-%s.%s', $safeName, bin2hex(random_bytes(4)), $ext);
        $file->move($this->uploadDir, $fileName);

        return self::IMAGE_PREFIX.$fileName;
    }

    private function deleteManagedImage(?string $path): void
    {
        if (null === $path || !str_starts_with($path, self::IMAGE_PREFIX)) {
            return;
        }

        $fullPath = $this->uploadDir.\DIRECTORY_SEPARATOR.basename($path);
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
