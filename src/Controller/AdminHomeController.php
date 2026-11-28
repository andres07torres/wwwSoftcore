<?php

namespace App\Controller;

use App\Entity\HomeHeroConfig;
use App\Entity\HomeHeroSlide;
use App\Entity\HomeMethodologyConfig;
use App\Entity\HomeMethodologyStep;
use App\Entity\HomeServiceCard;
use App\Entity\HomeServicesConfig;
use App\Form\HomeHeroConfigType;
use App\Form\HomeHeroSlideType;
use App\Form\HomeMethodologyConfigType;
use App\Form\HomeMethodologyStepType;
use App\Form\HomeServiceCardType;
use App\Form\HomeServicesConfigType;
use App\Repository\HomeHeroConfigRepository;
use App\Repository\HomeHeroSlideRepository;
use App\Repository\HomeMethodologyConfigRepository;
use App\Repository\HomeMethodologyStepRepository;
use App\Repository\HomeServiceCardRepository;
use App\Repository\HomeServicesConfigRepository;
use App\Service\HeroImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/inicio')]
final class AdminHomeController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly HomeHeroConfigRepository $heroConfigRepository,
        private readonly HomeHeroSlideRepository $heroSlideRepository,
        private readonly HomeServicesConfigRepository $servicesConfigRepository,
        private readonly HomeServiceCardRepository $serviceCardRepository,
        private readonly HomeMethodologyConfigRepository $methodologyConfigRepository,
        private readonly HomeMethodologyStepRepository $methodologyStepRepository,
        private readonly HeroImageUploader $imageUploader,
    ) {
    }

    #[Route('', name: 'app_admin_home', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $heroConfig = $this->heroConfigRepository->findCurrent() ?? new HomeHeroConfig();
        $heroForm = $this->createForm(HomeHeroConfigType::class, $heroConfig);
        $heroForm->handleRequest($request);

        if ($heroForm->isSubmitted() && $heroForm->isValid()) {
            $heroConfig->touch();
            $this->entityManager->persist($heroConfig);
            $this->entityManager->flush();

            $this->addFlash('success', 'Los textos del Hero de Inicio se guardaron correctamente.');

            return $this->redirectToRoute('app_admin_home');
        }

        $servicesConfig = $this->servicesConfigRepository->findCurrent() ?? new HomeServicesConfig();
        $servicesForm = $this->createForm(HomeServicesConfigType::class, $servicesConfig);
        $servicesForm->handleRequest($request);

        if ($servicesForm->isSubmitted() && $servicesForm->isValid()) {
            $servicesConfig->touch();
            $this->entityManager->persist($servicesConfig);
            $this->entityManager->flush();

            $this->addFlash('success', 'El encabezado de "Nuestros Pilares" se guardó correctamente.');

            return $this->redirectToRoute('app_admin_home');
        }

        $methodologyConfig = $this->methodologyConfigRepository->findCurrent() ?? new HomeMethodologyConfig();
        $methodologyForm = $this->createForm(HomeMethodologyConfigType::class, $methodologyConfig);
        $methodologyForm->handleRequest($request);

        if ($methodologyForm->isSubmitted() && $methodologyForm->isValid()) {
            $methodologyConfig->touch();
            $this->entityManager->persist($methodologyConfig);
            $this->entityManager->flush();

            $this->addFlash('success', 'El encabezado de "Cómo Trabajamos" se guardó correctamente.');

            return $this->redirectToRoute('app_admin_home');
        }

        $slides = $this->heroSlideRepository->findAllOrdered();
        $serviceCards = $this->serviceCardRepository->findAllOrdered();
        $methodologySteps = $this->methodologyStepRepository->findAllOrdered();

        $newSlide = (new HomeHeroSlide())->setSortOrder(count($slides) + 1);
        $newSlideForm = $this->createForm(HomeHeroSlideType::class, $newSlide, [
            'require_image' => true,
            'action' => $this->generateUrl('app_admin_home_slide_new'),
        ]);

        $newServiceCard = (new HomeServiceCard())->setSortOrder(count($serviceCards) + 1);
        $newServiceCardForm = $this->createForm(HomeServiceCardType::class, $newServiceCard, [
            'action' => $this->generateUrl('app_admin_home_service_new'),
        ]);

        $nextStepOrder = count($methodologySteps) + 1;
        $newMethodologyStep = (new HomeMethodologyStep())
            ->setSortOrder($nextStepOrder)
            ->setStepNumber(str_pad((string) $nextStepOrder, 2, '0', \STR_PAD_LEFT));
        $newMethodologyStepForm = $this->createForm(HomeMethodologyStepType::class, $newMethodologyStep, [
            'action' => $this->generateUrl('app_admin_home_methodology_new'),
        ]);

        return $this->render('admin/home/index.html.twig', [
            'hero_form' => $heroForm,
            'slides' => $slides,
            'new_slide_form' => $newSlideForm,
            'services_form' => $servicesForm,
            'service_cards' => $serviceCards,
            'new_service_card_form' => $newServiceCardForm,
            'methodology_form' => $methodologyForm,
            'methodology_steps' => $methodologySteps,
            'new_methodology_step_form' => $newMethodologyStepForm,
        ]);
    }

    #[Route('/slides/nuevo', name: 'app_admin_home_slide_new', methods: ['GET', 'POST'])]
    public function newSlide(Request $request): Response
    {
        $slide = new HomeHeroSlide();
        $slide->setSortOrder(count($this->heroSlideRepository->findAll()) + 1);

        $form = $this->createForm(HomeHeroSlideType::class, $slide, [
            'require_image' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $imageFile */
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile instanceof UploadedFile) {
                $slide->setImagePath($this->imageUploader->upload($imageFile));
            }

            $this->entityManager->persist($slide);
            $this->entityManager->flush();

            $this->addFlash('success', 'Diapositiva agregada al carrusel de Inicio.');

            return $this->redirectToRoute('app_admin_home');
        }

        return $this->render('admin/home/slide_form.html.twig', [
            'form' => $form,
            'slide' => $slide,
            'is_edit' => false,
        ]);
    }

    #[Route('/slides/{id}/editar', name: 'app_admin_home_slide_edit', methods: ['GET', 'POST'])]
    public function editSlide(HomeHeroSlide $slide, Request $request): Response
    {
        $form = $this->createForm(HomeHeroSlideType::class, $slide, [
            'require_image' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $imageFile */
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile instanceof UploadedFile) {
                $oldPath = $slide->getImagePath();
                $slide->setImagePath($this->imageUploader->upload($imageFile));
                $this->imageUploader->deleteIfManaged($oldPath);
            }

            $this->entityManager->flush();

            $this->addFlash('success', 'Diapositiva actualizada correctamente.');

            return $this->redirectToRoute('app_admin_home');
        }

        return $this->render('admin/home/slide_form.html.twig', [
            'form' => $form,
            'slide' => $slide,
            'is_edit' => true,
        ]);
    }

    #[Route('/slides/{id}/eliminar', name: 'app_admin_home_slide_delete', methods: ['POST'])]
    public function deleteSlide(HomeHeroSlide $slide, Request $request): Response
    {
        $token = (string) $request->request->get('_token', '');
        if (!$this->isCsrfTokenValid('delete_hero_slide_'.$slide->getId(), $token)) {
            $this->addFlash('error', 'Token de seguridad inválido. Intenta nuevamente.');

            return $this->redirectToRoute('app_admin_home');
        }

        $oldPath = $slide->getImagePath();
        $this->entityManager->remove($slide);
        $this->entityManager->flush();
        $this->imageUploader->deleteIfManaged($oldPath);

        $this->addFlash('success', 'Diapositiva eliminada del carrusel.');

        return $this->redirectToRoute('app_admin_home');
    }

    #[Route('/pilares/nuevo', name: 'app_admin_home_service_new', methods: ['GET', 'POST'])]
    public function newServiceCard(Request $request): Response
    {
        $card = new HomeServiceCard();
        $card->setSortOrder(count($this->serviceCardRepository->findAll()) + 1);

        $form = $this->createForm(HomeServiceCardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($card);
            $this->entityManager->flush();

            $this->addFlash('success', 'Tarjeta de servicio creada correctamente.');

            return $this->redirectToRoute('app_admin_home');
        }

        return $this->render('admin/home/service_card_form.html.twig', [
            'form' => $form,
            'card' => $card,
            'is_edit' => false,
        ]);
    }

    #[Route('/pilares/{id}/editar', name: 'app_admin_home_service_edit', methods: ['GET', 'POST'])]
    public function editServiceCard(HomeServiceCard $card, Request $request): Response
    {
        $form = $this->createForm(HomeServiceCardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Tarjeta de servicio actualizada correctamente.');

            return $this->redirectToRoute('app_admin_home');
        }

        return $this->render('admin/home/service_card_form.html.twig', [
            'form' => $form,
            'card' => $card,
            'is_edit' => true,
        ]);
    }

    #[Route('/pilares/{id}/eliminar', name: 'app_admin_home_service_delete', methods: ['POST'])]
    public function deleteServiceCard(HomeServiceCard $card, Request $request): Response
    {
        $token = (string) $request->request->get('_token', '');
        if (!$this->isCsrfTokenValid('delete_service_card_'.$card->getId(), $token)) {
            $this->addFlash('error', 'Token de seguridad inválido. Intenta nuevamente.');

            return $this->redirectToRoute('app_admin_home');
        }

        $this->entityManager->remove($card);
        $this->entityManager->flush();

        $this->addFlash('success', 'Tarjeta de servicio eliminada.');

        return $this->redirectToRoute('app_admin_home');
    }

    #[Route('/metodologia/nuevo', name: 'app_admin_home_methodology_new', methods: ['GET', 'POST'])]
    public function newMethodologyStep(Request $request): Response
    {
        $nextOrder = count($this->methodologyStepRepository->findAll()) + 1;
        $step = new HomeMethodologyStep();
        $step->setSortOrder($nextOrder);
        $step->setStepNumber(str_pad((string) $nextOrder, 2, '0', \STR_PAD_LEFT));

        $form = $this->createForm(HomeMethodologyStepType::class, $step);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($step);
            $this->entityManager->flush();

            $this->addFlash('success', 'Paso de metodología creado correctamente.');

            return $this->redirectToRoute('app_admin_home');
        }

        return $this->render('admin/home/methodology_step_form.html.twig', [
            'form' => $form,
            'step' => $step,
            'is_edit' => false,
        ]);
    }

    #[Route('/metodologia/{id}/editar', name: 'app_admin_home_methodology_edit', methods: ['GET', 'POST'])]
    public function editMethodologyStep(HomeMethodologyStep $step, Request $request): Response
    {
        $form = $this->createForm(HomeMethodologyStepType::class, $step);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Paso de metodología actualizado correctamente.');

            return $this->redirectToRoute('app_admin_home');
        }

        return $this->render('admin/home/methodology_step_form.html.twig', [
            'form' => $form,
            'step' => $step,
            'is_edit' => true,
        ]);
    }

    #[Route('/metodologia/{id}/eliminar', name: 'app_admin_home_methodology_delete', methods: ['POST'])]
    public function deleteMethodologyStep(HomeMethodologyStep $step, Request $request): Response
    {
        $token = (string) $request->request->get('_token', '');
        if (!$this->isCsrfTokenValid('delete_methodology_step_'.$step->getId(), $token)) {
            $this->addFlash('error', 'Token de seguridad inválido. Intenta nuevamente.');

            return $this->redirectToRoute('app_admin_home');
        }

        $this->entityManager->remove($step);
        $this->entityManager->flush();

        $this->addFlash('success', 'Paso de metodología eliminado.');

        return $this->redirectToRoute('app_admin_home');
    }
}
