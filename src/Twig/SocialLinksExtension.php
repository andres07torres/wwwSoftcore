<?php

namespace App\Twig;

use App\Entity\SocialLinksConfig;
use App\Repository\SocialLinksConfigRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class SocialLinksExtension extends AbstractExtension
{
    public function __construct(
        private readonly SocialLinksConfigRepository $repository,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('site_social_links', $this->getSocialLinks(...)),
        ];
    }

    public function getSocialLinks(): SocialLinksConfig
    {
        return $this->repository->findCurrent() ?? new SocialLinksConfig();
    }
}
