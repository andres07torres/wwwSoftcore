<?php

namespace App\Entity;

use App\Repository\MethodologyPhaseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MethodologyPhaseRepository::class)]
#[ORM\Table(name: 'methodology_phase')]
class MethodologyPhase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 30)]
    private string $phaseBadge = 'FASE 01';

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 60)]
    private string $duration = 'Semana 1 - 2';

    #[ORM\Column(length: 140)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 140)]
    private string $title = '';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 800)]
    private string $description = '';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $deliverable = '';

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

    public function getPhaseBadge(): string { return $this->phaseBadge; }
    public function setPhaseBadge(string $v): static { $this->phaseBadge = trim($v); return $this; }

    public function getDuration(): string { return $this->duration; }
    public function setDuration(string $v): static { $this->duration = trim($v); return $this; }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $v): static { $this->title = trim($v); return $this; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $v): static { $this->description = trim($v); return $this; }

    public function getDeliverable(): string { return $this->deliverable; }
    public function setDeliverable(string $v): static { $this->deliverable = trim($v); return $this; }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $v): static { $this->sortOrder = max(0, $v); return $this; }

    public function isActive(): bool { return $this->isActive; }
    public function setIsActive(bool $v): static { $this->isActive = $v; return $this; }

    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}
