<?php

namespace App\Entity;

use App\Repository\TechnologyCriterionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TechnologyCriterionRepository::class)]
#[ORM\Table(name: 'technology_criterion')]
class TechnologyCriterion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['shield', 'bolt', 'cloud', 'lock', 'code', 'cpu'])]
    private string $iconKey = 'shield';

    #[ORM\Column(length: 160)]
    #[Assert\NotBlank(message: 'Ingresa el título del criterio.')]
    #[Assert\Length(max: 160)]
    private string $title = '';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Ingresa la descripción del criterio.')]
    private string $description = '';

    #[ORM\Column]
    #[Assert\Range(min: 0, max: 999)]
    private int $sortOrder = 1;

    #[ORM\Column]
    private bool $isActive = true;

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

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): static
    {
        $this->sortOrder = $sortOrder;

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
}
