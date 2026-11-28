<?php

namespace App\Entity;

use App\Repository\AboutValueCardRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AboutValueCardRepository::class)]
#[ORM\Table(name: 'about_value_card')]
class AboutValueCard
{
    public const ICONS = [
        'Código / Excelencia' => 'code',
        'Gráfico / Negocio' => 'chart',
        'Comunicación / Transparencia' => 'chat',
        'Laboratorio / Innovación' => 'beaker',
        'Seguridad / Escudo' => 'shield',
        'Velocidad / Rayo' => 'bolt',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['code', 'chart', 'chat', 'beaker', 'shield', 'bolt'])]
    private string $iconKey = 'code';

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
    public function setIconKey(string $iconKey): static { $this->iconKey = $iconKey; return $this; }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): static { $this->title = trim($title); return $this; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): static { $this->description = trim($description); return $this; }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $sortOrder): static { $this->sortOrder = max(0, $sortOrder); return $this; }

    public function isActive(): bool { return $this->isActive; }
    public function setIsActive(bool $isActive): static { $this->isActive = $isActive; return $this; }

    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}
