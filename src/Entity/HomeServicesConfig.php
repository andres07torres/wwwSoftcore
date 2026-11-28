<?php

namespace App\Entity;

use App\Repository\HomeServicesConfigRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HomeServicesConfigRepository::class)]
#[ORM\Table(name: 'home_services_config')]
class HomeServicesConfig
{
    public const DEFAULT_EYEBROW = 'Nuestros Pilares';
    public const DEFAULT_TITLE = 'Soluciones de ingeniería diseñadas para impactar';
    public const DEFAULT_SUBTITLE = 'Cubrimos el ciclo de vida completo de tus proyectos tecnológicos con estándares internacionales de calidad y seguridad.';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    #[Assert\NotBlank(message: 'La etiqueta superior es obligatoria.')]
    #[Assert\Length(max: 80)]
    private string $eyebrow = self::DEFAULT_EYEBROW;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: 'El título de la sección es obligatorio.')]
    #[Assert\Length(max: 180)]
    private string $title = self::DEFAULT_TITLE;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'El subtítulo de la sección es obligatorio.')]
    #[Assert\Length(max: 600)]
    private string $subtitle = self::DEFAULT_SUBTITLE;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEyebrow(): string
    {
        return $this->eyebrow;
    }

    public function setEyebrow(string $eyebrow): static
    {
        $this->eyebrow = trim($eyebrow);

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

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function touch(): static
    {
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }
}
