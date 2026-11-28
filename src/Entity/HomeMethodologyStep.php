<?php

namespace App\Entity;

use App\Repository\HomeMethodologyStepRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HomeMethodologyStepRepository::class)]
#[ORM\Table(name: 'home_methodology_step')]
class HomeMethodologyStep
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: 'El número de paso es obligatorio (ej. 01).')]
    #[Assert\Length(max: 10)]
    private string $stepNumber = '01';

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank(message: 'El título del paso es obligatorio.')]
    #[Assert\Length(max: 120)]
    private string $title = '';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'La descripción del paso es obligatoria.')]
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStepNumber(): string
    {
        return $this->stepNumber;
    }

    public function setStepNumber(string $stepNumber): static
    {
        $this->stepNumber = trim($stepNumber);

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
