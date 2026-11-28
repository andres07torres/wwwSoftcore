<?php

namespace App\Entity;

use App\Repository\AboutPageConfigRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AboutPageConfigRepository::class)]
#[ORM\Table(name: 'about_page_config')]
class AboutPageConfig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Sección 1: Hero
    #[ORM\Column(length: 160)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 160)]
    private string $heroTitlePrefix = 'Construyendo el futuro digital con';

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 120)]
    private string $heroTitleHighlight = 'ingeniería de software';

    #[ORM\Column(length: 120)]
    #[Assert\Length(max: 120)]
    private string $heroTitleSuffix = 'de clase mundial';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 700)]
    private string $heroSubtitle = 'Somos una compañía de tecnología especializada en arquitectura de software distribuido, soluciones cloud-native y modernización de plataformas críticas para empresas que buscan escalar sin fricciones.';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $heroImagePath = null;

    #[ORM\Column(length: 180)]
    #[Assert\Length(max: 180)]
    private string $heroCaption = 'Ingeniería de Software & Arquitectura Cloud · SoftCorec';

    // Sección 2: Nuestro Propósito (Misión y Visión)
    #[ORM\Column(length: 80)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 80)]
    private string $purposeEyebrow = 'Nuestro Propósito';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    private string $purposeTitle = 'Guiados por una visión de impacto tecnológico medible';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $purposeSubtitle = 'Alineamos la ingeniería informática avanzada con las metas comerciales estratégicas de cada cliente.';

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 60)]
    private string $missionBadge = 'Nuestra Misión';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    private string $missionTitle = 'Potenciar el crecimiento con software de alto impacto';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 700)]
    private string $missionDescription = 'Empoderar a empresas e instituciones transformando desafíos operativos y de negocio en arquitecturas de software robustas, resilientes y eficientes, entregando valor tangible en cada despliegue.';

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 60)]
    private string $visionBadge = 'Nuestra Visión';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    private string $visionTitle = 'Ser el socio tecnológico de referencia regional';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 700)]
    private string $visionDescription = 'Consolidarnos como el referente en arquitectura de software, DevOps y computación en la nube, reconocidos internacionalmente por nuestra rigurosidad técnica, capacidad de innovación y relaciones de confianza duraderas.';

    // Sección 3: Cultura & Principios (Encabezado)
    #[ORM\Column(length: 80)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 80)]
    private string $valuesEyebrow = 'Cultura & Principios';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    private string $valuesTitle = 'Los pilares que guían cada línea de código';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $valuesSubtitle = 'Nuestra cultura se fundamenta en principios sólidos de ingeniería, ética profesional y excelencia operativa.';

    // Sección 4: Resultados & Trayectoria (Encabezado)
    #[ORM\Column(length: 80)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 80)]
    private string $metricsEyebrow = 'Resultados & Trayectoria';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    private string $metricsTitle = 'Cifras que respaldan nuestro compromiso';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $metricsSubtitle = 'Medimos nuestro éxito a través de la estabilidad operativa y el valor sostenido generado para nuestros clientes.';

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

    public function getHeroImagePath(): ?string { return $this->heroImagePath; }
    public function setHeroImagePath(?string $v): static { $this->heroImagePath = null !== $v ? trim($v) : null; return $this; }

    public function getHeroCaption(): string { return $this->heroCaption; }
    public function setHeroCaption(?string $v): static { $this->heroCaption = trim((string) $v); return $this; }

    public function getPurposeEyebrow(): string { return $this->purposeEyebrow; }
    public function setPurposeEyebrow(string $v): static { $this->purposeEyebrow = trim($v); return $this; }

    public function getPurposeTitle(): string { return $this->purposeTitle; }
    public function setPurposeTitle(string $v): static { $this->purposeTitle = trim($v); return $this; }

    public function getPurposeSubtitle(): string { return $this->purposeSubtitle; }
    public function setPurposeSubtitle(string $v): static { $this->purposeSubtitle = trim($v); return $this; }

    public function getMissionBadge(): string { return $this->missionBadge; }
    public function setMissionBadge(string $v): static { $this->missionBadge = trim($v); return $this; }

    public function getMissionTitle(): string { return $this->missionTitle; }
    public function setMissionTitle(string $v): static { $this->missionTitle = trim($v); return $this; }

    public function getMissionDescription(): string { return $this->missionDescription; }
    public function setMissionDescription(string $v): static { $this->missionDescription = trim($v); return $this; }

    public function getVisionBadge(): string { return $this->visionBadge; }
    public function setVisionBadge(string $v): static { $this->visionBadge = trim($v); return $this; }

    public function getVisionTitle(): string { return $this->visionTitle; }
    public function setVisionTitle(string $v): static { $this->visionTitle = trim($v); return $this; }

    public function getVisionDescription(): string { return $this->visionDescription; }
    public function setVisionDescription(string $v): static { $this->visionDescription = trim($v); return $this; }

    public function getValuesEyebrow(): string { return $this->valuesEyebrow; }
    public function setValuesEyebrow(string $v): static { $this->valuesEyebrow = trim($v); return $this; }

    public function getValuesTitle(): string { return $this->valuesTitle; }
    public function setValuesTitle(string $v): static { $this->valuesTitle = trim($v); return $this; }

    public function getValuesSubtitle(): string { return $this->valuesSubtitle; }
    public function setValuesSubtitle(string $v): static { $this->valuesSubtitle = trim($v); return $this; }

    public function getMetricsEyebrow(): string { return $this->metricsEyebrow; }
    public function setMetricsEyebrow(string $v): static { $this->metricsEyebrow = trim($v); return $this; }

    public function getMetricsTitle(): string { return $this->metricsTitle; }
    public function setMetricsTitle(string $v): static { $this->metricsTitle = trim($v); return $this; }

    public function getMetricsSubtitle(): string { return $this->metricsSubtitle; }
    public function setMetricsSubtitle(string $v): static { $this->metricsSubtitle = trim($v); return $this; }

    public function getUpdatedAt(): \DateTimeImmutable { return $this->updatedAt; }
    public function touch(): static { $this->updatedAt = new \DateTimeImmutable(); return $this; }
}
