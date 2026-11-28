<?php

namespace App\Entity;

use App\Repository\HomeServiceCardRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HomeServiceCardRepository::class)]
#[ORM\Table(name: 'home_service_card')]
class HomeServiceCard
{
    public const ICONS = [
        'Desarrollo Web / Monitor' => 'web_mobile',
        'Cloud / Arquitectura' => 'cloud_devops',
        'Consultoría / Documento' => 'consulting_audit',
        'Código / API' => 'code',
        'Seguridad / Escudo' => 'shield',
        'Rendimiento / Rayo' => 'bolt',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['web_mobile', 'cloud_devops', 'consulting_audit', 'code', 'shield', 'bolt'])]
    private string $iconKey = 'web_mobile';

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank(message: 'El título de la tarjeta es obligatorio.')]
    #[Assert\Length(max: 120)]
    private string $title = '';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'La descripción es obligatoria.')]
    #[Assert\Length(max: 600)]
    private string $description = '';

    #[ORM\Column(length: 80)]
    #[Assert\NotBlank(message: 'El texto del enlace es obligatorio.')]
    #[Assert\Length(max: 80)]
    private string $linkText = 'Ver detalles del servicio';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'El enlace es obligatorio.')]
    #[Assert\Length(max: 255)]
    private string $linkUrl = '/servicios';

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(0)]
    private int $sortOrder = 0;

    #[ORM\Column]
    private bool $isActive = true;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIconKey(): string
    {
        return $this->iconKey;
    }

    public function setIconKey(string $iconKey): static
    {
        $this->iconKey = $iconKey;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = trim($title);

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = trim($description);

        return $this;
    }

    public function getLinkText(): string
    {
        return $this->linkText;
    }

    public function setLinkText(string $linkText): static
    {
        $this->linkText = trim($linkText);

        return $this;
    }

    public function getLinkUrl(): string
    {
        return $this->linkUrl;
    }

    public function setLinkUrl(string $linkUrl): static
    {
        $this->linkUrl = trim($linkUrl);

        return $this;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): static
    {
        $this->sortOrder = max(0, $sortOrder);

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
