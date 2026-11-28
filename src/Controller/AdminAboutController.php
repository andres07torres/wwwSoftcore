<?php

namespace App\Controller;

use App\Entity\AboutMetricCard;
use App\Entity\AboutPageConfig;
use App\Entity\AboutValueCard;
use App\Form\AboutHeroType;
use App\Form\AboutMetricCardType;
use App\Form\AboutMetricsHeaderType;
use App\Form\AboutPurposeType;
use App\Form\AboutValueCardType;
use App\Form\AboutValuesHeaderType;
use App\Repository\AboutMetricCardRepository;
use App\Repository\AboutPageConfigRepository;
use App\Repository\AboutValueCardRepository;
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
#[Route('/admin/quienes-somos')]
final class AdminAboutController extends AbstractController
{
    private const IMAGE_PREFIX = '/uploads/about/';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AboutPageConfigRepository $pageConfigRepository,
        private readonly AboutValueCardRepository $valueCardRepository,
        private readonly AboutMetricCardRepository $metricCardRepository,
        private readonly SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/public/uploads/about')]
        private readonly string $aboutUploadDir,
    ) {
    }

    #[Route('', name: 'app_admin_about', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $config = $this->pageConfigRepository->findCurrent() ?? new AboutPageConfig();

        $heroForm = $this->createForm(AboutHeroType::class, $config);
        $heroForm->handleRequest($request);
        if ($heroForm->isSubmitted() && $heroForm->isValid()) {
            /** @var UploadedFile|null $imageFile */
            $imageFile = $heroForm->get('heroImageFile')->getData();
            if ($imageFile instanceof UploadedFile) {
                $oldPath = $config->getHeroImagePath();
                $config->setHeroImagePath($this->uploadImage($imageFile));
                $this->deleteManagedImage($oldPath);
            }

            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();

            $this->addFlash('success', 'El Hero de Quiénes Somos se guardó correctamente.');

            return $this->redirectToRoute('app_admin_about', ['_fragment' => 'sec-hero']);
        }

        $purposeForm = $this->createForm(AboutPurposeType::class, $config);
        $purposeForm->handleRequest($request);
        if ($purposeForm->isSubmitted() && $purposeForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();

            $this->addFlash('success', 'La sección Nuestro Propósito se guardó correctamente.');

            return $this->redirectToRoute('app_admin_about', ['_fragment' => 'sec-proposito']);
        }

        $valuesHeaderForm = $this->createForm(AboutValuesHeaderType::class, $config);
        $valuesHeaderForm->handleRequest($request);
        if ($valuesHeaderForm->isSubmitted() && $valuesHeaderForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();

            $this->addFlash('success', 'El encabezado de Cultura & Principios se guardó correctamente.');

            return $this->redirectToRoute('app_admin_about', ['_fragment' => 'sec-cultura']);
        }

        $metricsHeaderForm = $this->createForm(AboutMetricsHeaderType::class, $config);
        $metricsHeaderForm->handleRequest($request);
        if ($metricsHeaderForm->isSubmitted() && $metricsHeaderForm->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();

            $this->addFlash('success', 'El encabezado de Resultados & Trayectoria se guardó correctamente.');

            return $this->redirectToRoute('app_admin_about', ['_fragment' => 'sec-resultados']);
        }

        $valueCards = $this->valueCardRepository->findAllOrdered();
        $metricCards = $this->metricCardRepository->findAllOrdered();

        $newValueCard = (new AboutValueCard())->setSortOrder(count($valueCards) + 1);
        $newValueForm = $this->createForm(AboutValueCardType::class, $newValueCard, [
            'action' => $this->generateUrl('app_admin_about_value_new'),
        ]);

        $newMetricCard = (new AboutMetricCard())->setSortOrder(count($metricCards) + 1);
        $newMetricForm = $this->createForm(AboutMetricCardType::class, $newMetricCard, [
            'action' => $this->generateUrl('app_admin_about_metric_new'),
        ]);

        return $this->render('admin/about/index.html.twig', [
            'config' => $config,
            'hero_form' => $heroForm,
            'purpose_form' => $purposeForm,
            'values_header_form' => $valuesHeaderForm,
            'metrics_header_form' => $metricsHeaderForm,
            'value_cards' => $valueCards,
            'new_value_form' => $newValueForm,
            'metric_cards' => $metricCards,
            'new_metric_form' => $newMetricForm,
        ]);
    }

    #[Route('/principios/nuevo', name: 'app_admin_about_value_new', methods: ['GET', 'POST'])]
    public function newValue(Request $request): Response
    {
        $card = (new AboutValueCard())->setSortOrder(count($this->valueCardRepository->findAll()) + 1);
        $form = $this->createForm(AboutValueCardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($card);
            $this->entityManager->flush();

            $this->addFlash('success', 'Principio creado correctamente.');

            return $this->redirectToRoute('app_admin_about', ['_fragment' => 'sec-cultura']);
        }

        return $this->render('admin/about/value_form.html.twig', [
            'form' => $form,
            'card' => $card,
            'is_edit' => false,
        ]);
    }

    #[Route('/principios/{id}/editar', name: 'app_admin_about_value_edit', methods: ['GET', 'POST'])]
    public function editValue(AboutValueCard $card, Request $request): Response
    {
        $form = $this->createForm(AboutValueCardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Principio actualizado correctamente.');

            return $this->redirectToRoute('app_admin_about', ['_fragment' => 'sec-cultura']);
        }

        return $this->render('admin/about/value_form.html.twig', [
            'form' => $form,
            'card' => $card,
            'is_edit' => true,
        ]);
    }

    #[Route('/principios/{id}/eliminar', name: 'app_admin_about_value_delete', methods: ['POST'])]
    public function deleteValue(AboutValueCard $card, Request $request): Response
    {
        $token = (string) $request->request->get('_token', '');
        if (!$this->isCsrfTokenValid('delete_about_value_'.$card->getId(), $token)) {
            $this->addFlash('error', 'Token de seguridad inválido.');

            return $this->redirectToRoute('app_admin_about', ['_fragment' => 'sec-cultura']);
        }

        $this->entityManager->remove($card);
        $this->entityManager->flush();

        $this->addFlash('success', 'Principio eliminado correctamente.');

        return $this->redirectToRoute('app_admin_about', ['_fragment' => 'sec-cultura']);
    }

    #[Route('/cifras/nuevo', name: 'app_admin_about_metric_new', methods: ['GET', 'POST'])]
    public function newMetric(Request $request): Response
    {
        $card = (new AboutMetricCard())->setSortOrder(count($this->metricCardRepository->findAll()) + 1);
        $form = $this->createForm(AboutMetricCardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($card);
            $this->entityManager->flush();

            $this->addFlash('success', 'Cifra creada correctamente.');

            return $this->redirectToRoute('app_admin_about', ['_fragment' => 'sec-resultados']);
        }

        return $this->render('admin/about/metric_form.html.twig', [
            'form' => $form,
            'card' => $card,
            'is_edit' => false,
        ]);
    }

    #[Route('/cifras/{id}/editar', name: 'app_admin_about_metric_edit', methods: ['GET', 'POST'])]
    public function editMetric(AboutMetricCard $card, Request $request): Response
    {
        $form = $this->createForm(AboutMetricCardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Cifra actualizada correctamente.');

            return $this->redirectToRoute('app_admin_about', ['_fragment' => 'sec-resultados']);
        }

        return $this->render('admin/about/metric_form.html.twig', [
            'form' => $form,
            'card' => $card,
            'is_edit' => true,
        ]);
    }

    #[Route('/cifras/{id}/eliminar', name: 'app_admin_about_metric_delete', methods: ['POST'])]
    public function deleteMetric(AboutMetricCard $card, Request $request): Response
    {
        $token = (string) $request->request->get('_token', '');
        if (!$this->isCsrfTokenValid('delete_about_metric_'.$card->getId(), $token)) {
            $this->addFlash('error', 'Token de seguridad inválido.');

            return $this->redirectToRoute('app_admin_about', ['_fragment' => 'sec-resultados']);
        }

        $this->entityManager->remove($card);
        $this->entityManager->flush();

        $this->addFlash('success', 'Cifra eliminada correctamente.');

        return $this->redirectToRoute('app_admin_about', ['_fragment' => 'sec-resultados']);
    }

    private function uploadImage(UploadedFile $file): string
    {
        if (!is_dir($this->aboutUploadDir)) {
            mkdir($this->aboutUploadDir, 0775, true);
        }

        $originalName = pathinfo($file->getClientOriginalName(), \PATHINFO_FILENAME);
        $safeName = (string) $this->slugger->slug($originalName)->lower();
        if ('' === $safeName) {
            $safeName = 'about-hero';
        }

        $ext = $file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'webp';
        $fileName = sprintf('%s-%s.%s', $safeName, bin2hex(random_bytes(4)), $ext);
        $file->move($this->aboutUploadDir, $fileName);

        return self::IMAGE_PREFIX.$fileName;
    }

    private function deleteManagedImage(?string $path): void
    {
        if (null === $path || !str_starts_with($path, self::IMAGE_PREFIX)) {
            return;
        }

        $fullPath = $this->aboutUploadDir.\DIRECTORY_SEPARATOR.basename($path);
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
