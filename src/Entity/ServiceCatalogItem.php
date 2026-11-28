<?php

namespace App\Entity;

use App\Repository\ServiceCatalogItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceCatalogItemRepository::class)]
#[ORM\Table(name: 'service_catalog_item')]
class ServiceCatalogItem
{
    public const ICONS = [
        'Código / APIs' => 'code',
        'Nube / DevOps' => 'cloud',
        'Móvil / Frontend' => 'mobile',
        'Documento / Consultoría' => 'document',
        'Base de Datos' => 'database',
        'Candado / Seguridad' => 'lock',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['code', 'cloud', 'mobile', 'document', 'database', 'lock'])]
    private string $iconKey = 'code';

    #[ORM\Column(length: 80)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 80)]
    private string $category = '';

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 120)]
    private string $title = '';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $description = '';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 1000)]
    private string $capabilities = '';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $techTags = '';

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

    public function getId(): ?int { return $this->id; }

    public function getIconKey(): string { return $this->iconKey; }
    public function setIconKey(string $v): static { $this->iconKey = $v; return $this; }

    public function getCategory(): string { return $this->category; }
    public function setCategory(string $v): static { $this->category = trim($v); return $this; }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $v): static { $this->title = trim($v); return $this; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $v): static { $this->description = trim($v); return $this; }

    public function getCapabilities(): string { return $this->capabilities; }
    public function setCapabilities(string $v): static { $this->capabilities = trim($v); return $this; }

    /**
     * @return list<string>
     */
    public function getCapabilitiesList(): array
    {
        $lines = preg_split('/\r\n|\r|\n/', $this->capabilities) ?: [];

        return array_values(array_filter(array_map('trim', $lines), static fn (string $s): bool => '' !== $s));
    }

    public function getTechTags(): string { return $this->techTags; }
    public function setTechTags(string $v): static { $this->techTags = trim($v); return $this; }

    /**
     * @return list<string>
     */
    public function getTechTagsList(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $this->techTags)), static fn (string $s): bool => '' !== $s));
    }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $v): static { $this->sortOrder = max(0, $v); return $this; }

    public function isActive(): bool { return $this->isActive; }
    public function setIsActive(bool $v): static { $this->isActive = $v; return $this; }

    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}
