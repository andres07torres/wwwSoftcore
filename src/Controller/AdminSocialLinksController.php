<?php

namespace App\Controller;

use App\Entity\SocialLinksConfig;
use App\Form\SocialLinksConfigType;
use App\Repository\SocialLinksConfigRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/redes-sociales')]
final class AdminSocialLinksController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SocialLinksConfigRepository $repository,
    ) {
    }

    #[Route('', name: 'app_admin_social_links', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $config = $this->repository->findCurrent() ?? new SocialLinksConfig();

        $form = $this->createForm(SocialLinksConfigType::class, $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $config->touch();
            $this->entityManager->persist($config);
            $this->entityManager->flush();
            $this->addFlash('success', 'Las redes sociales se guardaron correctamente.');

            return $this->redirectToRoute('app_admin_social_links');
        }

        return $this->render('admin/social_links/index.html.twig', [
            'form' => $form,
            'config' => $config,
        ]);
    }
}
