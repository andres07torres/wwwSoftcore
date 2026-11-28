<?php

namespace App\Entity;

use App\Repository\TechnologyDomainRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TechnologyDomainRepository::class)]
#[ORM\Table(name: 'technology_domain')]
class TechnologyDomain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['code', 'desktop', 'mobile', 'layers', 'database', 'shield'])]
    private string $iconKey = 'code';

    #[ORM\Column(length: 160)]
    #[Assert\NotBlank(message: 'Ingresa el título del dominio.')]
    #[Assert\Length(max: 160)]
    private string $title = '';

    #[ORM\Column(length: 220)]
    #[Assert\NotBlank(message: 'Ingresa el subtítulo del dominio.')]
    #[Assert\Length(max: 220)]
    private string $subtitle = '';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Ingresa la descripción del dominio.')]
    private string $description = '';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Ingresa al menos una tecnología separada por coma.')]
    private string $techTags = '';

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

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): static
    {
        $this->subtitle = trim($subtitle);

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

    public function getTechTags(): string
    {
        return $this->techTags;
    }

    public function setTechTags(string $techTags): static
    {
        $this->techTags = trim($techTags);

        return $this;
    }

    /**
     * @return list<string>
     */
    public function getTechTagsList(): array
    {
        return array_values(array_filter(
            array_map('trim', explode(',', $this->techTags)),
            static fn (string $tag): bool => '' !== $tag
        ));
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
