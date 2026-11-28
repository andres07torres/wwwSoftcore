<?php

namespace App\Entity;

use App\Repository\MethodologyPageConfigRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MethodologyPageConfigRepository::class)]
#[ORM\Table(name: 'methodology_page_config')]
class MethodologyPageConfig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // 1. Hero
    #[ORM\Column(length: 160)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 160)]
    private string $heroTitlePrefix = 'Metodología diseñada para';

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 120)]
    private string $heroTitleHighlight = 'entregas continuas';

    #[ORM\Column(length: 120)]
    #[Assert\Length(max: 120)]
    private string $heroTitleSuffix = 'y valor medible';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 700)]
    private string $heroSubtitle = 'Combinamos rigor de arquitectura, sprints iterativos y automatización CI/CD para convertir requerimientos complejos en software robusto, escalable y sin fricción operativa.';

    #[ORM\Column(length: 200)]
    #[Assert\Length(max: 200)]
    private string $heroFlowNote = 'Ciclos de 2 semanas · Demostraciones en staging · Transparencia radical';

    #[ORM\Column(length: 100)]
    #[Assert\Length(max: 100)]
    private string $pipelineLabel = 'pipeline: agile-lifecycle.yaml';

    // 2. Nuestra Filosofía
    #[ORM\Column(length: 80)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 80)]
    private string $pillarsEyebrow = 'Nuestra Filosofía';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    private string $pillarsTitle = 'Principios que garantizan predictibilidad y calidad';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $pillarsSubtitle = 'Estructuramos cada desarrollo para reducir la incertidumbre, acelerar el time-to-market y proteger la estabilidad de tus operaciones.';

    // 3. Ciclo de Entrega (Fases)
    #[ORM\Column(length: 80)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 80)]
    private string $phasesEyebrow = 'Ciclo de Entrega';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    private string $phasesTitle = 'De la idea a la producción en 5 etapas';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $phasesSubtitle = 'Un flujo estructurado donde cada fase cuenta con objetivos claros y entregables técnicos verificables.';

    // 4. Buenas Prácticas (Estándares)
    #[ORM\Column(length: 80)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 80)]
    private string $standardsEyebrow = 'Buenas Prácticas';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    private string $standardsTitle = 'Estándares técnicos no negociables';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $standardsSubtitle = 'Nuestro código y nuestras arquitecturas están respaldados por convenciones internacionales de la industria.';

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getHeroTitlePrefix(): string { return $this->heroTitlePrefix; }
    public function setHeroTitlePrefix(string $v): static { $this->heroTitlePrefix = trim($v); return $this; }

    public function getHeroTitleHighlight(): string { return $this->heroTitleHighlight; }
    public function setHeroTitleHighlight(string $v): static { $this->heroTitleHighlight = trim($v); return $this; }

    public function getHeroTitleSuffix(): string { return $this->heroTitleSuffix; }
    public function setHeroTitleSuffix(?string $v): static { $this->heroTitleSuffix = trim((string) $v); return $this; }

    public function getHeroSubtitle(): string { return $this->heroSubtitle; }
    public function setHeroSubtitle(string $v): static { $this->heroSubtitle = trim($v); return $this; }

    public function getHeroFlowNote(): string { return $this->heroFlowNote; }
    public function setHeroFlowNote(?string $v): static { $this->heroFlowNote = trim((string) $v); return $this; }

    public function getPipelineLabel(): string { return $this->pipelineLabel; }
    public function setPipelineLabel(?string $v): static { $this->pipelineLabel = trim((string) $v); return $this; }

    public function getPillarsEyebrow(): string { return $this->pillarsEyebrow; }
    public function setPillarsEyebrow(string $v): static { $this->pillarsEyebrow = trim($v); return $this; }

    public function getPillarsTitle(): string { return $this->pillarsTitle; }
    public function setPillarsTitle(string $v): static { $this->pillarsTitle = trim($v); return $this; }

    public function getPillarsSubtitle(): string { return $this->pillarsSubtitle; }
    public function setPillarsSubtitle(string $v): static { $this->pillarsSubtitle = trim($v); return $this; }

    public function getPhasesEyebrow(): string { return $this->phasesEyebrow; }
    public function setPhasesEyebrow(string $v): static { $this->phasesEyebrow = trim($v); return $this; }

    public function getPhasesTitle(): string { return $this->phasesTitle; }
    public function setPhasesTitle(string $v): static { $this->phasesTitle = trim($v); return $this; }

    public function getPhasesSubtitle(): string { return $this->phasesSubtitle; }
    public function setPhasesSubtitle(string $v): static { $this->phasesSubtitle = trim($v); return $this; }

    public function getStandardsEyebrow(): string { return $this->standardsEyebrow; }
    public function setStandardsEyebrow(string $v): static { $this->standardsEyebrow = trim($v); return $this; }

    public function getStandardsTitle(): string { return $this->standardsTitle; }
    public function setStandardsTitle(string $v): static { $this->standardsTitle = trim($v); return $this; }

    public function getStandardsSubtitle(): string { return $this->standardsSubtitle; }
    public function setStandardsSubtitle(string $v): static { $this->standardsSubtitle = trim($v); return $this; }

    public function getUpdatedAt(): \DateTimeImmutable { return $this->updatedAt; }
    public function touch(): static { $this->updatedAt = new \DateTimeImmutable(); return $this; }
}
