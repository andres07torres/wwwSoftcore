<?php

namespace App\Entity;

use App\Repository\ServicesPageConfigRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServicesPageConfigRepository::class)]
#[ORM\Table(name: 'services_page_config')]
class ServicesPageConfig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // 1. Hero
    #[ORM\Column(length: 160)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 160)]
    private string $heroTitlePrefix = 'Servicios de ingeniería diseñados para';

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 120)]
    private string $heroTitleHighlight = 'escalar tu negocio';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 700)]
    private string $heroSubtitle = 'Acompañamos a tu empresa en cada fase del ciclo tecnológico: desde el diseño conceptual de arquitecturas robustas hasta el despliegue cloud automatizado y la optimización continua.';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $heroImagePath = null;

    #[ORM\Column(length: 180)]
    #[Assert\Length(max: 180)]
    private string $heroCaption = 'Desarrollo Full-Lifecycle & Arquitectura Cloud · SoftCorec';

    // 2. Portafolio / Catálogo
    #[ORM\Column(length: 80)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 80)]
    private string $catalogEyebrow = 'Nuestro Portafolio';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    private string $catalogTitle = 'Soluciones diseñadas con rigor técnico';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $catalogSubtitle = 'Arquitecturas escalables, código limpio y buenas prácticas de ingeniería para resolver desafíos de alto impacto.';

    // 3. Proyectos Realizados
    #[ORM\Column(length: 80)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 80)]
    private string $projectsEyebrow = 'Proyectos Realizados';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    private string $projectsTitle = 'Casos y soluciones construidas a medida';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $projectsSubtitle = 'Explora algunos de los sistemas, plataformas y arquitecturas que hemos diseñado y puesto en producción.';

    // 4. Cómo Trabajamos (Workflow)
    #[ORM\Column(length: 80)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 80)]
    private string $workflowEyebrow = 'Cómo Trabajamos';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    private string $workflowTitle = 'Un proceso claro, predecible y orientado a resultados';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $workflowSubtitle = 'De la conceptualización a la producción con transparencia total y validación rigurosa en cada hito.';

    // 5. Contacto & Asesoría
    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    private string $contactTitle = '¿Tienes un proyecto desafiante en mente?';

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 600)]
    private string $contactSubtitle = 'Conversemos sobre tus metas tecnológicas y diseñemos juntos una arquitectura sólida, escalable y optimizada para tu negocio.';

    #[ORM\Column(length: 160)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 160)]
    private string $contactBenefit1 = 'Respuesta técnica en menos de 24 horas';

    #[ORM\Column(length: 160)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 160)]
    private string $contactBenefit2 = 'Acuerdo de confidencialidad (NDA) garantizado';

    #[ORM\Column(length: 160)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 160)]
    private string $contactBenefit3 = 'Diagnóstico preliminar sin costo ni compromiso';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $contactWhatsappUrl = 'https://wa.me/593999999999';

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 120)]
    private string $contactFormTitle = 'Solicitar Asesoría Técnica';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $contactFormSubtitle = 'Completa el formulario y analizaremos tus requerimientos sin costo inicial.';

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

    public function getHeroSubtitle(): string { return $this->heroSubtitle; }
    public function setHeroSubtitle(string $v): static { $this->heroSubtitle = trim($v); return $this; }

    public function getHeroImagePath(): ?string { return $this->heroImagePath; }
    public function setHeroImagePath(?string $v): static { $this->heroImagePath = null !== $v ? trim($v) : null; return $this; }

    public function getHeroCaption(): string { return $this->heroCaption; }
    public function setHeroCaption(?string $v): static { $this->heroCaption = trim((string) $v); return $this; }

    public function getCatalogEyebrow(): string { return $this->catalogEyebrow; }
    public function setCatalogEyebrow(string $v): static { $this->catalogEyebrow = trim($v); return $this; }

    public function getCatalogTitle(): string { return $this->catalogTitle; }
    public function setCatalogTitle(string $v): static { $this->catalogTitle = trim($v); return $this; }

    public function getCatalogSubtitle(): string { return $this->catalogSubtitle; }
    public function setCatalogSubtitle(string $v): static { $this->catalogSubtitle = trim($v); return $this; }

    public function getProjectsEyebrow(): string { return $this->projectsEyebrow; }
    public function setProjectsEyebrow(string $v): static { $this->projectsEyebrow = trim($v); return $this; }

    public function getProjectsTitle(): string { return $this->projectsTitle; }
    public function setProjectsTitle(string $v): static { $this->projectsTitle = trim($v); return $this; }

    public function getProjectsSubtitle(): string { return $this->projectsSubtitle; }
    public function setProjectsSubtitle(string $v): static { $this->projectsSubtitle = trim($v); return $this; }

    public function getWorkflowEyebrow(): string { return $this->workflowEyebrow; }
    public function setWorkflowEyebrow(string $v): static { $this->workflowEyebrow = trim($v); return $this; }

    public function getWorkflowTitle(): string { return $this->workflowTitle; }
    public function setWorkflowTitle(string $v): static { $this->workflowTitle = trim($v); return $this; }

    public function getWorkflowSubtitle(): string { return $this->workflowSubtitle; }
    public function setWorkflowSubtitle(string $v): static { $this->workflowSubtitle = trim($v); return $this; }

    public function getContactTitle(): string { return $this->contactTitle; }
    public function setContactTitle(string $v): static { $this->contactTitle = trim($v); return $this; }

    public function getContactSubtitle(): string { return $this->contactSubtitle; }
    public function setContactSubtitle(string $v): static { $this->contactSubtitle = trim($v); return $this; }

    public function getContactBenefit1(): string { return $this->contactBenefit1; }
    public function setContactBenefit1(string $v): static { $this->contactBenefit1 = trim($v); return $this; }

    public function getContactBenefit2(): string { return $this->contactBenefit2; }
    public function setContactBenefit2(string $v): static { $this->contactBenefit2 = trim($v); return $this; }

    public function getContactBenefit3(): string { return $this->contactBenefit3; }
    public function setContactBenefit3(string $v): static { $this->contactBenefit3 = trim($v); return $this; }

    public function getContactWhatsappUrl(): string { return $this->contactWhatsappUrl; }
    public function setContactWhatsappUrl(string $v): static { $this->contactWhatsappUrl = trim($v); return $this; }

    public function getContactWhatsappHref(): string
    {
        $base = rtrim(trim($this->contactWhatsappUrl), '?&');
        if ('' === $base) {
            return 'https://wa.me/?text='.rawurlencode('Hola SoftCorec, quiero una consultoría');
        }

        if (str_contains($base, 'text=')) {
            return $base;
        }

        $separator = str_contains($base, '?') ? '&' : '?';

        return $base.$separator.'text='.rawurlencode('Hola SoftCorec, quiero una consultoría');
    }

    public function getContactFormTitle(): string { return $this->contactFormTitle; }
    public function setContactFormTitle(string $v): static { $this->contactFormTitle = trim($v); return $this; }

    public function getContactFormSubtitle(): string { return $this->contactFormSubtitle; }
    public function setContactFormSubtitle(string $v): static { $this->contactFormSubtitle = trim($v); return $this; }

    public function getUpdatedAt(): \DateTimeImmutable { return $this->updatedAt; }
    public function touch(): static { $this->updatedAt = new \DateTimeImmutable(); return $this; }
}
