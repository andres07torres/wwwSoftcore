<?php

namespace App\Entity;

use App\Repository\HomeHeroConfigRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HomeHeroConfigRepository::class)]
#[ORM\Table(name: 'home_hero_config')]
class HomeHeroConfig
{
    public const DEFAULT_TITLE_PREFIX = 'Arquitectura de software a medida que';
    public const DEFAULT_TITLE_HIGHLIGHT = 'escala con tu negocio';
    public const DEFAULT_SUBTITLE = 'En SoftCorec diseñamos y desarrollamos infraestructuras tecnológicas robustas, escalables y orientadas a resultados. Optimizamos procesos críticos para acelerar el crecimiento de tu empresa.';
    public const DEFAULT_PRIMARY_BUTTON_TEXT = 'Agendar Consultoría';
    public const DEFAULT_PRIMARY_BUTTON_URL = '/servicios#formulario-contacto';
    public const DEFAULT_SECONDARY_BUTTON_TEXT = 'Ver Servicios';
    public const DEFAULT_SECONDARY_BUTTON_URL = '/servicios';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: 'El título principal es obligatorio.')]
    #[Assert\Length(max: 180)]
    private string $titlePrefix = self::DEFAULT_TITLE_PREFIX;

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank(message: 'El texto destacado del título es obligatorio.')]
    #[Assert\Length(max: 120)]
    private string $titleHighlight = self::DEFAULT_TITLE_HIGHLIGHT;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'El subtítulo es obligatorio.')]
    #[Assert\Length(max: 600)]
    private string $subtitle = self::DEFAULT_SUBTITLE;

    #[ORM\Column(length: 80)]
    #[Assert\NotBlank(message: 'El texto del botón principal es obligatorio.')]
    #[Assert\Length(max: 80)]
    private string $primaryButtonText = self::DEFAULT_PRIMARY_BUTTON_TEXT;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'El enlace del botón principal es obligatorio.')]
    #[Assert\Length(max: 255)]
    private string $primaryButtonUrl = self::DEFAULT_PRIMARY_BUTTON_URL;

    #[ORM\Column(length: 80)]
    #[Assert\NotBlank(message: 'El texto del botón secundario es obligatorio.')]
    #[Assert\Length(max: 80)]
    private string $secondaryButtonText = self::DEFAULT_SECONDARY_BUTTON_TEXT;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'El enlace del botón secundario es obligatorio.')]
    #[Assert\Length(max: 255)]
    private string $secondaryButtonUrl = self::DEFAULT_SECONDARY_BUTTON_URL;

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

    public function getTitlePrefix(): string
    {
        return $this->titlePrefix;
    }

    public function setTitlePrefix(string $titlePrefix): static
    {
        $this->titlePrefix = trim($titlePrefix);

        return $this;
    }

    public function getTitleHighlight(): string
    {
        return $this->titleHighlight;
    }

    public function setTitleHighlight(string $titleHighlight): static
    {
        $this->titleHighlight = trim($titleHighlight);

        return $this;
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): static
    {
        $this->subtitle = trim($subtitle);

        return $this;
    }

    public function getPrimaryButtonText(): string
    {
        return $this->primaryButtonText;
    }

    public function setPrimaryButtonText(string $primaryButtonText): static
    {
        $this->primaryButtonText = trim($primaryButtonText);

        return $this;
    }

    public function getPrimaryButtonUrl(): string
    {
        return $this->primaryButtonUrl;
    }

    public function setPrimaryButtonUrl(string $primaryButtonUrl): static
    {
        $this->primaryButtonUrl = trim($primaryButtonUrl);

        return $this;
    }

    public function getSecondaryButtonText(): string
    {
        return $this->secondaryButtonText;
    }

    public function setSecondaryButtonText(string $secondaryButtonText): static
    {
        $this->secondaryButtonText = trim($secondaryButtonText);

        return $this;
    }

    public function getSecondaryButtonUrl(): string
    {
        return $this->secondaryButtonUrl;
    }

    public function setSecondaryButtonUrl(string $secondaryButtonUrl): static
    {
        $this->secondaryButtonUrl = trim($secondaryButtonUrl);

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
