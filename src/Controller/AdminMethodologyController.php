<?php

namespace App\Controller;

use App\Entity\MethodologyPageConfig;
use App\Entity\MethodologyPhase;
use App\Entity\MethodologyPillar;
use App\Entity\MethodologyStandard;
use App\Form\MethodologyHeroType;
use App\Form\MethodologyPhasesHeaderType;
use App\Form\MethodologyPhaseType;
use App\Form\MethodologyPillarsHeaderType;
use App\Form\MethodologyPillarType;
use App\Form\MethodologyStandardsHeaderType;
use App\Form\MethodologyStandardType;
use App\Repository\MethodologyPageConfigRepository;
use App\Repository\MethodologyPhaseRepository;
use App\Repository\MethodologyPillarRepository;
use App\Repository\MethodologyStandardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/metodologia')]
final class AdminMethodologyController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly MethodologyPageConfigRepository $pageConfigRepository,
        private readonly MethodologyPillarRepository $pillarRepository,
        private readonly MethodologyPhaseRepository $phaseRepository,
        private readonly MethodologyStandardRepository $standardRepository,
    ) {
    }

    #[Route('', name: 'app_admin_methodology', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $config = $this->pageConfigRepository->findCurrent() ?? new MethodologyPageConfig();

        $heroForm = $this->createForm(MethodologyHeroType::class, $config);
        $heroForm->handleRequest($request);
        if ($heroForm->isSubmitted() && $heroForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'El Hero de Metodología se guardó correctamente.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-hero']);
        }

        $pillarsHeaderForm = $this->createForm(MethodologyPillarsHeaderType::class, $config);
        $pillarsHeaderForm->handleRequest($request);
        if ($pillarsHeaderForm->isSubmitted() && $pillarsHeaderForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'El encabezado de Nuestra Filosofía se guardó correctamente.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-filosofia']);
        }

        $phasesHeaderForm = $this->createForm(MethodologyPhasesHeaderType::class, $config);
        $phasesHeaderForm->handleRequest($request);
        if ($phasesHeaderForm->isSubmitted() && $phasesHeaderForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'El encabezado de Ciclo de Entrega se guardó correctamente.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-fases']);
        }

        $standardsHeaderForm = $this->createForm(MethodologyStandardsHeaderType::class, $config);
        $standardsHeaderForm->handleRequest($request);
        if ($standardsHeaderForm->isSubmitted() && $standardsHeaderForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'El encabezado de Buenas Prácticas se guardó correctamente.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-estandares']);
        }

        $pillars = $this->pillarRepository->findAllOrdered();
        $phases = $this->phaseRepository->findAllOrdered();
        $standards = $this->standardRepository->findAllOrdered();

        $newPillarForm = $this->createForm(
            MethodologyPillarType::class,
            (new MethodologyPillar())->setSortOrder(count($pillars) + 1),
            ['action' => $this->generateUrl('app_admin_methodology_pillar_new')]
        );

        $nextPhaseOrder = count($phases) + 1;
        $newPhaseForm = $this->createForm(
            MethodologyPhaseType::class,
            (new MethodologyPhase())
                ->setSortOrder($nextPhaseOrder)
                ->setPhaseBadge('FASE '.str_pad((string) $nextPhaseOrder, 2, '0', \STR_PAD_LEFT)),
            ['action' => $this->generateUrl('app_admin_methodology_phase_new')]
        );

        $newStandardForm = $this->createForm(
            MethodologyStandardType::class,
            (new MethodologyStandard())->setSortOrder(count($standards) + 1),
            ['action' => $this->generateUrl('app_admin_methodology_standard_new')]
        );

        return $this->render('admin/methodology/index.html.twig', [
            'hero_form' => $heroForm,
            'pillars_header_form' => $pillarsHeaderForm,
            'phases_header_form' => $phasesHeaderForm,
            'standards_header_form' => $standardsHeaderForm,
            'pillars' => $pillars,
            'new_pillar_form' => $newPillarForm,
            'phases' => $phases,
            'new_phase_form' => $newPhaseForm,
            'standards' => $standards,
            'new_standard_form' => $newStandardForm,
        ]);
    }

    #[Route('/pilares/nuevo', name: 'app_admin_methodology_pillar_new', methods: ['GET', 'POST'])]
    public function newPillar(Request $request): Response
    {
        $pillar = (new MethodologyPillar())->setSortOrder(count($this->pillarRepository->findAll()) + 1);
        $form = $this->createForm(MethodologyPillarType::class, $pillar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($pillar);
            $this->entityManager->flush();
            $this->addFlash('success', 'Principio agregado correctamente.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-filosofia']);
        }

        return $this->render('admin/methodology/pillar_form.html.twig', [
            'form' => $form,
            'is_edit' => false,
        ]);
    }

    #[Route('/pilares/{id}/editar', name: 'app_admin_methodology_pillar_edit', methods: ['GET', 'POST'])]
    public function editPillar(MethodologyPillar $pillar, Request $request): Response
    {
        $form = $this->createForm(MethodologyPillarType::class, $pillar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Principio actualizado correctamente.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-filosofia']);
        }

        return $this->render('admin/methodology/pillar_form.html.twig', [
            'form' => $form,
            'is_edit' => true,
        ]);
    }

    #[Route('/pilares/{id}/eliminar', name: 'app_admin_methodology_pillar_delete', methods: ['POST'])]
    public function deletePillar(MethodologyPillar $pillar, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('delete_methodology_pillar_'.$pillar->getId(), (string) $request->request->get('_token', ''))) {
            $this->addFlash('error', 'Token de seguridad inválido.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-filosofia']);
        }

        $this->entityManager->remove($pillar);
        $this->entityManager->flush();
        $this->addFlash('success', 'Principio eliminado.');

        return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-filosofia']);
    }

    #[Route('/fases/nuevo', name: 'app_admin_methodology_phase_new', methods: ['GET', 'POST'])]
    public function newPhase(Request $request): Response
    {
        $nextOrder = count($this->phaseRepository->findAll()) + 1;
        $phase = (new MethodologyPhase())
            ->setSortOrder($nextOrder)
            ->setPhaseBadge('FASE '.str_pad((string) $nextOrder, 2, '0', \STR_PAD_LEFT));
        $form = $this->createForm(MethodologyPhaseType::class, $phase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($phase);
            $this->entityManager->flush();
            $this->addFlash('success', 'Fase agregada correctamente.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-fases']);
        }

        return $this->render('admin/methodology/phase_form.html.twig', [
            'form' => $form,
            'is_edit' => false,
        ]);
    }

    #[Route('/fases/{id}/editar', name: 'app_admin_methodology_phase_edit', methods: ['GET', 'POST'])]
    public function editPhase(MethodologyPhase $phase, Request $request): Response
    {
        $form = $this->createForm(MethodologyPhaseType::class, $phase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Fase actualizada correctamente.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-fases']);
        }

        return $this->render('admin/methodology/phase_form.html.twig', [
            'form' => $form,
            'is_edit' => true,
        ]);
    }

    #[Route('/fases/{id}/eliminar', name: 'app_admin_methodology_phase_delete', methods: ['POST'])]
    public function deletePhase(MethodologyPhase $phase, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('delete_methodology_phase_'.$phase->getId(), (string) $request->request->get('_token', ''))) {
            $this->addFlash('error', 'Token de seguridad inválido.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-fases']);
        }

        $this->entityManager->remove($phase);
        $this->entityManager->flush();
        $this->addFlash('success', 'Fase eliminada.');

        return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-fases']);
    }

    #[Route('/estandares/nuevo', name: 'app_admin_methodology_standard_new', methods: ['GET', 'POST'])]
    public function newStandard(Request $request): Response
    {
        $standard = (new MethodologyStandard())->setSortOrder(count($this->standardRepository->findAll()) + 1);
        $form = $this->createForm(MethodologyStandardType::class, $standard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($standard);
            $this->entityManager->flush();
            $this->addFlash('success', 'Estándar agregado correctamente.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-estandares']);
        }

        return $this->render('admin/methodology/standard_form.html.twig', [
            'form' => $form,
            'is_edit' => false,
        ]);
    }

    #[Route('/estandares/{id}/editar', name: 'app_admin_methodology_standard_edit', methods: ['GET', 'POST'])]
    public function editStandard(MethodologyStandard $standard, Request $request): Response
    {
        $form = $this->createForm(MethodologyStandardType::class, $standard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Estándar actualizado correctamente.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-estandares']);
        }

        return $this->render('admin/methodology/standard_form.html.twig', [
            'form' => $form,
            'is_edit' => true,
        ]);
    }

    #[Route('/estandares/{id}/eliminar', name: 'app_admin_methodology_standard_delete', methods: ['POST'])]
    public function deleteStandard(MethodologyStandard $standard, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('delete_methodology_standard_'.$standard->getId(), (string) $request->request->get('_token', ''))) {
            $this->addFlash('error', 'Token de seguridad inválido.');

            return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-estandares']);
        }

        $this->entityManager->remove($standard);
        $this->entityManager->flush();
        $this->addFlash('success', 'Estándar eliminado.');

        return $this->redirectToRoute('app_admin_methodology', ['_fragment' => 'sec-estandares']);
    }
}
