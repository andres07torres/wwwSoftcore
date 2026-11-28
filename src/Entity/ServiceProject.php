<?php

namespace App\Entity;

use App\Repository\ServiceProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceProjectRepository::class)]
#[ORM\Table(name: 'service_project')]
class ServiceProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 140)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 140)]
    private string $title = '';

    #[ORM\Column(length: 80)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 80)]
    private string $category = '';

    #[ORM\Column(length: 100)]
    #[Assert\Length(max: 100)]
    private string $client = '';

    #[ORM\Column(length: 10)]
    #[Assert\Length(max: 10)]
    private string $year = '';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $description = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagePath = null;

    #[ORM\Column(length: 120)]
    #[Assert\Length(max: 120)]
    private string $metric = '';

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    private string $techTags = '';

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    private string $url = '#formulario-contacto';

    #[ORM\Column(length: 80)]
    #[Assert\Length(max: 80)]
    private string $urlText = 'Solicitar caso similar';

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

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $v): static { $this->title = trim($v); return $this; }

    public function getCategory(): string { return $this->category; }
    public function setCategory(string $v): static { $this->category = trim($v); return $this; }

    public function getClient(): string { return $this->client; }
    public function setClient(?string $v): static { $this->client = trim((string) $v); return $this; }

    public function getYear(): string { return $this->year; }
    public function setYear(?string $v): static { $this->year = trim((string) $v); return $this; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $v): static { $this->description = trim($v); return $this; }

    public function getImagePath(): ?string { return $this->imagePath; }
    public function setImagePath(?string $v): static { $this->imagePath = null !== $v ? trim($v) : null; return $this; }

    public function getMetric(): string { return $this->metric; }
    public function setMetric(?string $v): static { $this->metric = trim((string) $v); return $this; }

    public function getTechTags(): string { return $this->techTags; }
    public function setTechTags(?string $v): static { $this->techTags = trim((string) $v); return $this; }

    /**
     * @return list<string>
     */
    public function getTechTagsList(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $this->techTags)), static fn (string $s): bool => '' !== $s));
    }

    public function getUrl(): string { return $this->url; }
    public function setUrl(?string $v): static { $this->url = trim((string) $v); return $this; }

    public function getUrlText(): string { return $this->urlText; }
    public function setUrlText(?string $v): static { $this->urlText = trim((string) $v); return $this; }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $v): static { $this->sortOrder = max(0, $v); return $this; }

    public function isActive(): bool { return $this->isActive; }
    public function setIsActive(bool $v): static { $this->isActive = $v; return $this; }

    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }

    /**
     * @return array<string, mixed>
     */
    public function toTemplateArray(): array
    {
        return [
            'titulo' => $this->title,
            'categoria' => $this->category,
            'cliente' => $this->client,
            'anio' => $this->year,
            'descripcion' => $this->description,
            'imagen' => $this->imagePath ?? '',
            'imagen_alt' => $this->title,
            'metrica' => $this->metric,
            'tecnologias' => $this->getTechTagsList(),
            'url' => $this->url,
            'url_texto' => '' !== $this->urlText ? $this->urlText : 'Solicitar caso similar',
        ];
    }
}
