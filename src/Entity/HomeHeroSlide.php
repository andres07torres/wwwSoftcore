<?php

namespace App\Entity;

use App\Repository\HomeHeroSlideRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HomeHeroSlideRepository::class)]
#[ORM\Table(name: 'home_hero_slide')]
class HomeHeroSlide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $imagePath = '';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: 'El texto alternativo (alt) es obligatorio.')]
    #[Assert\Length(max: 180)]
    private string $altText = '';

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

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = trim($imagePath);

        return $this;
    }

    public function getAltText(): string
    {
        return $this->altText;
    }

    public function setAltText(string $altText): static
    {
        $this->altText = trim($altText);

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
