<?php

namespace App\Entity;

use App\Repository\MethodologyPillarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MethodologyPillarRepository::class)]
#[ORM\Table(name: 'methodology_pillar')]
class MethodologyPillar
{
    public const ICONS = [
        'Arquitectura / Capas' => 'layers',
        'Sprints / Rayo' => 'bolt',
        'QA / Escudo' => 'shield',
        'Transparencia / Ojo' => 'eye',
        'Código / API' => 'code',
        'Métricas / Gráfico' => 'chart',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['layers', 'bolt', 'shield', 'eye', 'code', 'chart'])]
    private string $iconKey = 'layers';

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 120)]
    private string $title = '';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $description = '';

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

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $v): static { $this->title = trim($v); return $this; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $v): static { $this->description = trim($v); return $this; }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $v): static { $this->sortOrder = max(0, $v); return $this; }

    public function isActive(): bool { return $this->isActive; }
    public function setIsActive(bool $v): static { $this->isActive = $v; return $this; }

    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}
