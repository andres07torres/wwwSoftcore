<?php

namespace App\Entity;

use App\Repository\TechnologyPageConfigRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TechnologyPageConfigRepository::class)]
#[ORM\Table(name: 'technology_page_config')]
class TechnologyPageConfig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // 1. Hero
    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: 'Ingresa el texto inicial del título.')]
    #[Assert\Length(max: 180)]
    private string $heroTitlePrefix = 'Stack tecnológico seleccionado para';

    #[ORM\Column(length: 140)]
    #[Assert\NotBlank(message: 'Ingresa la frase destacada del título.')]
    #[Assert\Length(max: 140)]
    private string $heroTitleHighlight = 'rendimiento y escalabilidad';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Ingresa la descripción del Hero.')]
    private string $heroSubtitle = 'Elegimos lenguajes, frameworks y plataformas cloud con madurez comprobada, soporte activo y arquitecturas diseñadas para operaciones críticas de alta concurrencia.';

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Ingresa el nombre de especificación.')]
    #[Assert\Length(max: 100)]
    private string $specLabel = 'stack-architecture.spec';

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank(message: 'Ingresa el estado de la consola.')]
    #[Assert\Length(max: 40)]
    private string $specStatus = 'verified';

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank(message: 'Ingresa la etiqueta de la capa 1.')]
    #[Assert\Length(max: 120)]
    private string $stackLayer1Label = 'Capa de Aplicación & APIs';

    #[ORM\Column(length: 220)]
    #[Assert\NotBlank(message: 'Ingresa las tecnologías de la capa 1.')]
    #[Assert\Length(max: 220)]
    private string $stackLayer1Value = 'PHP 8.5 (Symfony) · Python (FastAPI/Django) · Go';

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank(message: 'Ingresa la etiqueta de la capa 2.')]
    #[Assert\Length(max: 120)]
    private string $stackLayer2Label = 'Frontend & Desarrollo Móvil';

    #[ORM\Column(length: 220)]
    #[Assert\NotBlank(message: 'Ingresa las tecnologías de la capa 2.')]
    #[Assert\Length(max: 220)]
    private string $stackLayer2Value = 'Kotlin (Android) · TypeScript · Vue.js · React · Vite';

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank(message: 'Ingresa la etiqueta de la capa 3.')]
    #[Assert\Length(max: 120)]
    private string $stackLayer3Label = 'Infraestructura Cloud & DevOps';

    #[ORM\Column(length: 220)]
    #[Assert\NotBlank(message: 'Ingresa las tecnologías de la capa 3.')]
    #[Assert\Length(max: 220)]
    private string $stackLayer3Value = 'AWS · GCP · Docker · Kubernetes · Terraform · CI/CD';

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank(message: 'Ingresa la etiqueta de la capa 4.')]
    #[Assert\Length(max: 120)]
    private string $stackLayer4Label = 'Datos, Caché & Mensajería';

    #[ORM\Column(length: 220)]
    #[Assert\NotBlank(message: 'Ingresa las tecnologías de la capa 4.')]
    #[Assert\Length(max: 220)]
    private string $stackLayer4Value = 'PostgreSQL · Redis · RabbitMQ · Elasticsearch';

    // 2. Rigor Técnico (Criterios)
    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Ingresa la etiqueta superior de Criterios.')]
    #[Assert\Length(max: 100)]
    private string $criteriaEyebrow = 'Rigor Técnico';

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'Ingresa el título de Criterios.')]
    #[Assert\Length(max: 200)]
    private string $criteriaTitle = 'Criterios de ingeniería para la selección de tecnologías';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Ingresa el subtítulo de Criterios.')]
    private string $criteriaSubtitle = 'No elegimos tecnologías por tendencias pasajeras. Seleccionamos cada componente en función de su solidez operativa, seguridad y facilidad de mantenimiento.';

    // 3. Catálogo Técnico (Ecosistema)
    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Ingresa la etiqueta superior de Catálogo Técnico.')]
    #[Assert\Length(max: 100)]
    private string $catalogEyebrow = 'Catálogo Técnico';

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'Ingresa el título de Catálogo Técnico.')]
    #[Assert\Length(max: 200)]
    private string $catalogTitle = 'Ecosistema tecnológico de alta fidelidad';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Ingresa el subtítulo de Catálogo Técnico.')]
    private string $catalogSubtitle = 'Estructura modular dividida por dominios de especialidad para dar respuesta integral a cualquier desafío digital corporativo.';

    // 4. Buenas Prácticas (Estándares)
    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Ingresa la etiqueta superior de Buenas Prácticas.')]
    #[Assert\Length(max: 100)]
    private string $practicesEyebrow = 'Buenas Prácticas';

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'Ingresa el título de Buenas Prácticas.')]
    #[Assert\Length(max: 200)]
    private string $practicesTitle = 'Estándares de ingeniería aplicados a cada entrega';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Ingresa el subtítulo de Buenas Prácticas.')]
    private string $practicesSubtitle = 'La tecnología cobra valor cuando está respaldada por patrones de diseño probados y procesos continuos de aseguramiento de calidad.';

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

    public function getHeroTitlePrefix(): string
    {
        return $this->heroTitlePrefix;
    }

    public function setHeroTitlePrefix(string $heroTitlePrefix): static
    {
        $this->heroTitlePrefix = trim($heroTitlePrefix);

        return $this;
    }

    public function getHeroTitleHighlight(): string
    {
        return $this->heroTitleHighlight;
    }

    public function setHeroTitleHighlight(string $heroTitleHighlight): static
    {
        $this->heroTitleHighlight = trim($heroTitleHighlight);

        return $this;
    }

    public function getHeroSubtitle(): string
    {
        return $this->heroSubtitle;
    }

    public function setHeroSubtitle(string $heroSubtitle): static
    {
        $this->heroSubtitle = trim($heroSubtitle);

        return $this;
    }

    public function getSpecLabel(): string
    {
        return $this->specLabel;
    }

    public function setSpecLabel(string $specLabel): static
    {
        $this->specLabel = trim($specLabel);

        return $this;
    }

    public function getSpecStatus(): string
    {
        return $this->specStatus;
    }

    public function setSpecStatus(string $specStatus): static
    {
        $this->specStatus = trim($specStatus);

        return $this;
    }

    public function getStackLayer1Label(): string
    {
        return $this->stackLayer1Label;
    }

    public function setStackLayer1Label(string $stackLayer1Label): static
    {
        $this->stackLayer1Label = trim($stackLayer1Label);

        return $this;
    }

    public function getStackLayer1Value(): string
    {
        return $this->stackLayer1Value;
    }

    public function setStackLayer1Value(string $stackLayer1Value): static
    {
        $this->stackLayer1Value = trim($stackLayer1Value);

        return $this;
    }

    public function getStackLayer2Label(): string
    {
        return $this->stackLayer2Label;
    }

    public function setStackLayer2Label(string $stackLayer2Label): static
    {
        $this->stackLayer2Label = trim($stackLayer2Label);

        return $this;
    }

    public function getStackLayer2Value(): string
    {
        return $this->stackLayer2Value;
    }

    public function setStackLayer2Value(string $stackLayer2Value): static
    {
        $this->stackLayer2Value = trim($stackLayer2Value);

        return $this;
    }

    public function getStackLayer3Label(): string
    {
        return $this->stackLayer3Label;
    }

    public function setStackLayer3Label(string $stackLayer3Label): static
    {
        $this->stackLayer3Label = trim($stackLayer3Label);

        return $this;
    }

    public function getStackLayer3Value(): string
    {
        return $this->stackLayer3Value;
    }

    public function setStackLayer3Value(string $stackLayer3Value): static
    {
        $this->stackLayer3Value = trim($stackLayer3Value);

        return $this;
    }

    public function getStackLayer4Label(): string
    {
        return $this->stackLayer4Label;
    }

    public function setStackLayer4Label(string $stackLayer4Label): static
    {
        $this->stackLayer4Label = trim($stackLayer4Label);

        return $this;
    }

    public function getStackLayer4Value(): string
    {
        return $this->stackLayer4Value;
    }

    public function setStackLayer4Value(string $stackLayer4Value): static
    {
        $this->stackLayer4Value = trim($stackLayer4Value);

        return $this;
    }

    public function getCriteriaEyebrow(): string
    {
        return $this->criteriaEyebrow;
    }

    public function setCriteriaEyebrow(string $criteriaEyebrow): static
    {
        $this->criteriaEyebrow = trim($criteriaEyebrow);

        return $this;
    }

    public function getCriteriaTitle(): string
    {
        return $this->criteriaTitle;
    }

    public function setCriteriaTitle(string $criteriaTitle): static
    {
        $this->criteriaTitle = trim($criteriaTitle);

        return $this;
    }

    public function getCriteriaSubtitle(): string
    {
        return $this->criteriaSubtitle;
    }

    public function setCriteriaSubtitle(string $criteriaSubtitle): static
    {
        $this->criteriaSubtitle = trim($criteriaSubtitle);

        return $this;
    }

    public function getCatalogEyebrow(): string
    {
        return $this->catalogEyebrow;
    }

    public function setCatalogEyebrow(string $catalogEyebrow): static
    {
        $this->catalogEyebrow = trim($catalogEyebrow);

        return $this;
    }

    public function getCatalogTitle(): string
    {
        return $this->catalogTitle;
    }

    public function setCatalogTitle(string $catalogTitle): static
    {
        $this->catalogTitle = trim($catalogTitle);

        return $this;
    }

    public function getCatalogSubtitle(): string
    {
        return $this->catalogSubtitle;
    }

    public function setCatalogSubtitle(string $catalogSubtitle): static
    {
        $this->catalogSubtitle = trim($catalogSubtitle);

        return $this;
    }

    public function getPracticesEyebrow(): string
    {
        return $this->practicesEyebrow;
    }

    public function setPracticesEyebrow(string $practicesEyebrow): static
    {
        $this->practicesEyebrow = trim($practicesEyebrow);

        return $this;
    }

    public function getPracticesTitle(): string
    {
        return $this->practicesTitle;
    }

    public function setPracticesTitle(string $practicesTitle): static
    {
        $this->practicesTitle = trim($practicesTitle);

        return $this;
    }

    public function getPracticesSubtitle(): string
    {
        return $this->practicesSubtitle;
    }

    public function setPracticesSubtitle(string $practicesSubtitle): static
    {
        $this->practicesSubtitle = trim($practicesSubtitle);

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
