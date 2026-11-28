<?php

namespace App\Controller;

use App\Entity\TechnologyCriterion;
use App\Entity\TechnologyDomain;
use App\Entity\TechnologyPageConfig;
use App\Entity\TechnologyPractice;
use App\Form\TechnologyCatalogHeaderType;
use App\Form\TechnologyCriteriaHeaderType;
use App\Form\TechnologyCriterionType;
use App\Form\TechnologyDomainType;
use App\Form\TechnologyHeroType;
use App\Form\TechnologyPracticesHeaderType;
use App\Form\TechnologyPracticeType;
use App\Repository\TechnologyCriterionRepository;
use App\Repository\TechnologyDomainRepository;
use App\Repository\TechnologyPageConfigRepository;
use App\Repository\TechnologyPracticeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/tecnologias')]
final class AdminTechnologyController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TechnologyPageConfigRepository $pageConfigRepository,
        private readonly TechnologyCriterionRepository $criterionRepository,
        private readonly TechnologyDomainRepository $domainRepository,
        private readonly TechnologyPracticeRepository $practiceRepository,
    ) {
    }

    #[Route('', name: 'app_admin_technology', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $config = $this->pageConfigRepository->findCurrent() ?? new TechnologyPageConfig();

        $heroForm = $this->createForm(TechnologyHeroType::class, $config);
        $heroForm->handleRequest($request);
        if ($heroForm->isSubmitted() && $heroForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'El Hero de Tecnologías se guardó correctamente.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-hero']);
        }

        $criteriaHeaderForm = $this->createForm(TechnologyCriteriaHeaderType::class, $config);
        $criteriaHeaderForm->handleRequest($request);
        if ($criteriaHeaderForm->isSubmitted() && $criteriaHeaderForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'El encabezado de Rigor Técnico se guardó correctamente.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-criterios']);
        }

        $catalogHeaderForm = $this->createForm(TechnologyCatalogHeaderType::class, $config);
        $catalogHeaderForm->handleRequest($request);
        if ($catalogHeaderForm->isSubmitted() && $catalogHeaderForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'El encabezado de Catálogo Técnico se guardó correctamente.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-ecosistema']);
        }

        $practicesHeaderForm = $this->createForm(TechnologyPracticesHeaderType::class, $config);
        $practicesHeaderForm->handleRequest($request);
        if ($practicesHeaderForm->isSubmitted() && $practicesHeaderForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'El encabezado de Buenas Prácticas se guardó correctamente.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-practicas']);
        }

        $criteria = $this->criterionRepository->findAllOrdered();
        $domains = $this->domainRepository->findAllOrdered();
        $practices = $this->practiceRepository->findAllOrdered();

        $newCriterionForm = $this->createForm(
            TechnologyCriterionType::class,
            (new TechnologyCriterion())->setSortOrder(count($criteria) + 1),
            ['action' => $this->generateUrl('app_admin_technology_criterion_new')]
        );

        $newDomainForm = $this->createForm(
            TechnologyDomainType::class,
            (new TechnologyDomain())->setSortOrder(count($domains) + 1),
            ['action' => $this->generateUrl('app_admin_technology_domain_new')]
        );

        $nextPracticeOrder = count($practices) + 1;
        $newPracticeForm = $this->createForm(
            TechnologyPracticeType::class,
            (new TechnologyPractice())
                ->setSortOrder($nextPracticeOrder)
                ->setStepNumber(str_pad((string) $nextPracticeOrder, 2, '0', \STR_PAD_LEFT)),
            ['action' => $this->generateUrl('app_admin_technology_practice_new')]
        );

        return $this->render('admin/technology/index.html.twig', [
            'hero_form' => $heroForm,
            'criteria_header_form' => $criteriaHeaderForm,
            'catalog_header_form' => $catalogHeaderForm,
            'practices_header_form' => $practicesHeaderForm,
            'criteria' => $criteria,
            'new_criterion_form' => $newCriterionForm,
            'domains' => $domains,
            'new_domain_form' => $newDomainForm,
            'practices' => $practices,
            'new_practice_form' => $newPracticeForm,
        ]);
    }

    #[Route('/criterios/nuevo', name: 'app_admin_technology_criterion_new', methods: ['GET', 'POST'])]
    public function newCriterion(Request $request): Response
    {
        $criterion = (new TechnologyCriterion())->setSortOrder(count($this->criterionRepository->findAll()) + 1);
        $form = $this->createForm(TechnologyCriterionType::class, $criterion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($criterion);
            $this->entityManager->flush();
            $this->addFlash('success', 'Criterio agregado correctamente.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-criterios']);
        }

        return $this->render('admin/technology/criterion_form.html.twig', [
            'form' => $form,
            'is_edit' => false,
        ]);
    }

    #[Route('/criterios/{id}/editar', name: 'app_admin_technology_criterion_edit', methods: ['GET', 'POST'])]
    public function editCriterion(TechnologyCriterion $criterion, Request $request): Response
    {
        $form = $this->createForm(TechnologyCriterionType::class, $criterion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Criterio actualizado correctamente.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-criterios']);
        }

        return $this->render('admin/technology/criterion_form.html.twig', [
            'form' => $form,
            'is_edit' => true,
        ]);
    }

    #[Route('/criterios/{id}/eliminar', name: 'app_admin_technology_criterion_delete', methods: ['POST'])]
    public function deleteCriterion(TechnologyCriterion $criterion, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('delete_technology_criterion_'.$criterion->getId(), (string) $request->request->get('_token', ''))) {
            $this->addFlash('error', 'Token de seguridad inválido.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-criterios']);
        }

        $this->entityManager->remove($criterion);
        $this->entityManager->flush();
        $this->addFlash('success', 'Criterio eliminado.');

        return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-criterios']);
    }

    #[Route('/ecosistema/nuevo', name: 'app_admin_technology_domain_new', methods: ['GET', 'POST'])]
    public function newDomain(Request $request): Response
    {
        $domain = (new TechnologyDomain())->setSortOrder(count($this->domainRepository->findAll()) + 1);
        $form = $this->createForm(TechnologyDomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($domain);
            $this->entityManager->flush();
            $this->addFlash('success', 'Dominio tecnológico agregado correctamente.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-ecosistema']);
        }

        return $this->render('admin/technology/domain_form.html.twig', [
            'form' => $form,
            'is_edit' => false,
        ]);
    }

    #[Route('/ecosistema/{id}/editar', name: 'app_admin_technology_domain_edit', methods: ['GET', 'POST'])]
    public function editDomain(TechnologyDomain $domain, Request $request): Response
    {
        $form = $this->createForm(TechnologyDomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Dominio tecnológico actualizado correctamente.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-ecosistema']);
        }

        return $this->render('admin/technology/domain_form.html.twig', [
            'form' => $form,
            'is_edit' => true,
        ]);
    }

    #[Route('/ecosistema/{id}/eliminar', name: 'app_admin_technology_domain_delete', methods: ['POST'])]
    public function deleteDomain(TechnologyDomain $domain, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('delete_technology_domain_'.$domain->getId(), (string) $request->request->get('_token', ''))) {
            $this->addFlash('error', 'Token de seguridad inválido.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-ecosistema']);
        }

        $this->entityManager->remove($domain);
        $this->entityManager->flush();
        $this->addFlash('success', 'Dominio tecnológico eliminado.');

        return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-ecosistema']);
    }

    #[Route('/practicas/nuevo', name: 'app_admin_technology_practice_new', methods: ['GET', 'POST'])]
    public function newPractice(Request $request): Response
    {
        $nextOrder = count($this->practiceRepository->findAll()) + 1;
        $practice = (new TechnologyPractice())
            ->setSortOrder($nextOrder)
            ->setStepNumber(str_pad((string) $nextOrder, 2, '0', \STR_PAD_LEFT));
        $form = $this->createForm(TechnologyPracticeType::class, $practice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($practice);
            $this->entityManager->flush();
            $this->addFlash('success', 'Buena práctica agregada correctamente.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-practicas']);
        }

        return $this->render('admin/technology/practice_form.html.twig', [
            'form' => $form,
            'is_edit' => false,
        ]);
    }

    #[Route('/practicas/{id}/editar', name: 'app_admin_technology_practice_edit', methods: ['GET', 'POST'])]
    public function editPractice(TechnologyPractice $practice, Request $request): Response
    {
        $form = $this->createForm(TechnologyPracticeType::class, $practice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Buena práctica actualizada correctamente.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-practicas']);
        }

        return $this->render('admin/technology/practice_form.html.twig', [
            'form' => $form,
            'is_edit' => true,
        ]);
    }

    #[Route('/practicas/{id}/eliminar', name: 'app_admin_technology_practice_delete', methods: ['POST'])]
    public function deletePractice(TechnologyPractice $practice, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('delete_technology_practice_'.$practice->getId(), (string) $request->request->get('_token', ''))) {
            $this->addFlash('error', 'Token de seguridad inválido.');

            return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-practicas']);
        }

        $this->entityManager->remove($practice);
        $this->entityManager->flush();
        $this->addFlash('success', 'Buena práctica eliminada.');

        return $this->redirectToRoute('app_admin_technology', ['_fragment' => 'sec-practicas']);
    }
}
