<?php

namespace App\Entity;

use App\Repository\SocialLinksConfigRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SocialLinksConfigRepository::class)]
#[ORM\Table(name: 'social_links_config')]
class SocialLinksConfig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ingresa el enlace de WhatsApp.')]
    #[Assert\Url(message: 'Ingresa una URL válida para WhatsApp (ej. https://wa.me/593999999999).', requireTld: true)]
    #[Assert\Length(max: 255)]
    private string $whatsappUrl = 'https://wa.me/';

    #[ORM\Column]
    private bool $whatsappActive = true;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ingresa el enlace de Instagram.')]
    #[Assert\Url(message: 'Ingresa una URL válida para Instagram (ej. https://instagram.com/softcorec).', requireTld: true)]
    #[Assert\Length(max: 255)]
    private string $instagramUrl = 'https://instagram.com/';

    #[ORM\Column]
    private bool $instagramActive = true;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ingresa el enlace de Facebook.')]
    #[Assert\Url(message: 'Ingresa una URL válida para Facebook (ej. https://facebook.com/softcorec).', requireTld: true)]
    #[Assert\Length(max: 255)]
    private string $facebookUrl = 'https://facebook.com/';

    #[ORM\Column]
    private bool $facebookActive = true;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWhatsappUrl(): string
    {
        return $this->whatsappUrl;
    }

    public function setWhatsappUrl(string $whatsappUrl): static
    {
        $this->whatsappUrl = trim($whatsappUrl);

        return $this;
    }

    public function isWhatsappActive(): bool
    {
        return $this->whatsappActive;
    }

    public function setWhatsappActive(bool $whatsappActive): static
    {
        $this->whatsappActive = $whatsappActive;

        return $this;
    }

    public function getInstagramUrl(): string
    {
        return $this->instagramUrl;
    }

    public function setInstagramUrl(string $instagramUrl): static
    {
        $this->instagramUrl = trim($instagramUrl);

        return $this;
    }

    public function isInstagramActive(): bool
    {
        return $this->instagramActive;
    }

    public function setInstagramActive(bool $instagramActive): static
    {
        $this->instagramActive = $instagramActive;

        return $this;
    }

    public function getFacebookUrl(): string
    {
        return $this->facebookUrl;
    }

    public function setFacebookUrl(string $facebookUrl): static
    {
        $this->facebookUrl = trim($facebookUrl);

        return $this;
    }

    public function isFacebookActive(): bool
    {
        return $this->facebookActive;
    }

    public function setFacebookActive(bool $facebookActive): static
    {
        $this->facebookActive = $facebookActive;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function touch(): static
    {
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }
}
