import { Controller } from '@hotwired/stimulus';

const translations = {
    es: {
        // Navbar
        'nav.consultoria': 'Consultoría',
        'nav.inicio': 'Inicio',
        'nav.quienes_somos': 'Quiénes Somos',
        'nav.servicios': 'Servicios',
        'nav.metodologia': 'Metodología',
        'nav.tecnologias': 'Tecnologías',

        // Hero
        'hero.title': 'Arquitectura de software a medida que <span class="text-gradient-light">escala con tu negocio</span>',
        'hero.subtitle': 'Diseñamos y desarrollamos infraestructuras tecnológicas robustas, escalables y orientadas a resultados. Optimizamos procesos críticos para acelerar el crecimiento de tu empresa.',
        'hero.btn_consultoria': 'Agendar Consultoría',
        'hero.btn_servicios': 'Ver Servicios',

        // Barra de Confianza / Métricas
        'trust.metric1_val': '+99.9%',
        'trust.metric1_lbl': 'Disponibilidad & Uptime',
        'trust.metric2_val': 'Cloud-Native',
        'trust.metric2_lbl': 'Arquitectura Escalable',
        'trust.metric3_val': 'Ágil & CI/CD',
        'trust.metric3_lbl': 'Despliegues Continuos',
        'trust.metric4_val': '24/7',
        'trust.metric4_lbl': 'Soporte y Monitoreo',

        // Servicios Bento Grid
        'services.eyebrow': 'Nuestros Pilares',
        'services.title': 'Soluciones de ingeniería diseñadas para impactar',
        'services.subtitle': 'Cubrimos el ciclo de vida completo de tus proyectos tecnológicos con estándares internacionales de calidad y seguridad.',
        'services.card1_title': 'Desarrollo Web & Móvil',
        'services.card1_desc': 'Plataformas web corporativas, SPAs y aplicaciones nativas/híbridas con arquitecturas limpias, alta velocidad de respuesta y UX intuitiva.',
        'services.card1_link': 'Ver detalles del servicio',
        'services.card2_title': 'Cloud Architecture & DevOps',
        'services.card2_desc': 'Diseño de infraestructura como código (Terraform), contenedores con Kubernetes y flujos CI/CD para despliegues automatizados y sin fricción.',
        'services.card2_link': 'Ver detalles del servicio',
        'services.card3_title': 'Consultoría & Auditoría IT',
        'services.card3_desc': 'Evaluación de deuda técnica, auditorías de seguridad, optimización de base de datos y modernización estratégica de sistemas legados.',
        'services.card3_link': 'Ver detalles del servicio',

        // Metodología
        'methodology.eyebrow': 'Cómo Trabajamos',
        'methodology.title': 'Metodología ágil orientada a entregas tangibles',
        'methodology.subtitle': 'Un proceso transparente, predecible y validado en cada etapa para minimizar riesgos técnicos y de negocio.',
        'methodology.step1_title': 'Diagnóstico & Estrategia',
        'methodology.step1_desc': 'Relevamiento de requerimientos, análisis de factibilidad y diseño conceptual de la arquitectura.',
        'methodology.step2_title': 'Diseño & Prototipado',
        'methodology.step2_desc': 'Modelado de datos, definición de interfaces API y maquetación de flujos de usuario clave.',
        'methodology.step3_title': 'Desarrollo & Testing',
        'methodology.step3_desc': 'Sprints iterativos con pruebas unitarias, de integración y revisión continua de código.',
        'methodology.step4_title': 'Despliegue & Monitoreo',
        'methodology.step4_desc': 'Lanzamiento automatizado a producción con alertas en tiempo real y soporte técnico constante.',
        'methodology.btn': 'Conoce nuestra metodología completa',

        // Tecnologías
        'tech.eyebrow': 'Ecosistema & Herramientas',
        'tech.title': 'Tecnologías probadas en entornos de alta exigencia',
        'tech.subtitle': 'Seleccionamos las herramientas más eficientes para garantizar mantenibilidad, velocidad y seguridad a largo plazo.',

        // Footer
        'footer.desc': 'Arquitectura de software de alto rendimiento, ingeniería cloud y desarrollo a medida para acelerar el crecimiento de tu empresa.',
        'footer.heading_nav': 'Navegación',
        'footer.heading_services': 'Servicios',
        'footer.heading_contact': 'Contacto',
        'footer.contact_desc': '¿Tienes un proyecto en mente? Hablemos de cómo llevarlo al siguiente nivel.',
        'footer.rights': 'Todos los derechos reservados.',
        'footer.serv_arch': 'Arquitectura de Software',
        'footer.privacy': 'Privacidad',
        'footer.terms': 'Términos',

        // Quiénes Somos (About)
        'about.breadcrumb': 'Quiénes Somos',
        'about.hero_badge': 'Sobre Nosotros',
        'about.hero_title': 'Construyendo el futuro digital con <span class="text-gradient-light">ingeniería de software</span> de clase mundial',
        'about.hero_subtitle': 'Somos una compañía de tecnología especializada en arquitectura de software distribuido, soluciones cloud-native y modernización de plataformas críticas para empresas que buscan escalar sin fricciones.',
        'about.hero_btn_cta': 'Trabajemos Juntos',
        'about.hero_btn_values': 'Conoce Nuestra Cultura',
        'about.card_lead_title': 'ADN de Ingeniería',
        'about.card_lead_subtitle': 'Rigor técnico y valor real',
        'about.card_lead_desc': 'No creemos en soluciones genéricas. Diseñamos sistemas hechos a la medida de los objetivos de tu negocio, con foco en mantenibilidad a largo plazo y rendimiento constante.',
        'about.feat_item1': 'Arquitecturas cloud escalables',
        'about.feat_item2': 'Automatización y CI/CD integral',
        'about.feat_item3': 'Seguridad y estándares internacionales',
        'about.purpose_eyebrow': 'Nuestro Propósito',
        'about.purpose_title': 'Guiados por una visión de impacto tecnológico medible',
        'about.purpose_subtitle': 'Alineamos la ingeniería informática avanzada con las metas comerciales estratégicas de cada cliente.',
        'about.mission_badge': 'Nuestra Misión',
        'about.mission_title': 'Potenciar el crecimiento con software de alto impacto',
        'about.mission_desc': 'Empoderar a empresas e instituciones transformando desafíos operativos y de negocio en arquitecturas de software robustas, resilientes y eficientes, entregando valor tangible en cada despliegue.',
        'about.vision_badge': 'Nuestra Visión',
        'about.vision_title': 'Ser el socio tecnológico de referencia regional',
        'about.vision_desc': 'Consolidarnos como el referente en arquitectura de software, DevOps y computación en la nube, reconocidos internacionalmente por nuestra rigurosidad técnica, capacidad de innovación y relaciones de confianza duraderas.',
        'about.values_eyebrow': 'Cultura & Principios',
        'about.values_title': 'Los pilares que guían cada línea de código',
        'about.values_subtitle': 'Nuestra cultura se fundamenta en principios sólidos de ingeniería, ética profesional y excelencia operativa.',
        'about.val1_title': 'Excelencia Técnica',
        'about.val1_desc': 'Diseñamos con patrones limpios, testing automatizado y arquitecturas sólidas. No tomamos atajos que comprometan la seguridad o mantenibilidad futura.',
        'about.val2_title': 'Orientación a Negocio',
        'about.val2_desc': 'La tecnología es una palanca para generar resultados. Priorizamos funcionalidades y decisiones que maximicen el retorno de inversión y la eficiencia operativa.',
        'about.val3_title': 'Transparencia Radical',
        'about.val3_desc': 'Comunicación clara, estimaciones realistas y visibilidad total del estado de cada proyecto en sprints demostrables y sin cajas negras.',
        'about.val4_title': 'Innovación Pragmática',
        'about.val4_desc': 'Adoptamos las herramientas más modernas (Cloud, Microservicios, DevOps, IA) solo cuando aportan ventajas comprobadas sobre estabilidad y velocidad.',
        'about.metrics_eyebrow': 'Resultados & Trayectoria',
        'about.metrics_title': 'Cifras que respaldan nuestro compromiso',
        'about.metrics_subtitle': 'Medimos nuestro éxito a través de la estabilidad operativa y el valor sostenido generado para nuestros clientes.',
        'about.kpi1_label': 'Proyectos Desplegados',
        'about.kpi1_desc': 'Sistemas corporativos y aplicaciones web de alta disponibilidad',
        'about.kpi2_label': 'Uptime Promedio',
        'about.kpi2_desc': 'Infraestructuras cloud resilientes con balanceo de carga',
        'about.kpi3_label': 'Automatización CI/CD',
        'about.kpi3_desc': 'Pipelines de despliegue continuo con pruebas automatizadas',
        'about.kpi4_label': 'Años de Trayectoria',
        'about.kpi4_desc': 'Resolviendo desafíos de arquitectura y consultoría técnica',
        'about.cta_title': '¿Listo para llevar tu infraestructura al siguiente nivel?',
        'about.cta_subtitle': 'Hablemos de tus requerimientos y diseñemos una arquitectura sólida, escalable y optimizada para tus metas de negocio.',
        'about.cta_btn_primary': 'Agendar Consultoría'
    },
    en: {
        // Navbar
        'nav.consultoria': 'Consulting',
        'nav.inicio': 'Home',
        'nav.quienes_somos': 'About Us',
        'nav.servicios': 'Services',
        'nav.metodologia': 'Methodology',
        'nav.tecnologias': 'Technologies',

        // Hero
        'hero.title': 'Custom software architecture that <span class="text-gradient-light">scales with your business</span>',
        'hero.subtitle': 'We design and develop robust, scalable, and results-driven technological infrastructures. We optimize critical processes to accelerate your company growth.',
        'hero.btn_consultoria': 'Schedule Consulting',
        'hero.btn_servicios': 'View Services',

        // Barra de Confianza / Métricas
        'trust.metric1_val': '+99.9%',
        'trust.metric1_lbl': 'Availability & Uptime',
        'trust.metric2_val': 'Cloud-Native',
        'trust.metric2_lbl': 'Scalable Architecture',
        'trust.metric3_val': 'Agile & CI/CD',
        'trust.metric3_lbl': 'Continuous Deployments',
        'trust.metric4_val': '24/7',
        'trust.metric4_lbl': 'Support & Monitoring',

        // Servicios Bento Grid
        'services.eyebrow': 'Our Core Pillars',
        'services.title': 'Engineering solutions designed to make an impact',
        'services.subtitle': 'We cover the complete lifecycle of your technology projects with international quality and security standards.',
        'services.card1_title': 'Web & Mobile Development',
        'services.card1_desc': 'Corporate web platforms, SPAs, and native/hybrid applications with clean architectures, high response speed, and intuitive UX.',
        'services.card1_link': 'View service details',
        'services.card2_title': 'Cloud Architecture & DevOps',
        'services.card2_desc': 'Infrastructure as code design (Terraform), Kubernetes containers, and CI/CD pipelines for automated, frictionless deployments.',
        'services.card2_link': 'View service details',
        'services.card3_title': 'IT Consulting & Auditing',
        'services.card3_desc': 'Technical debt assessment, security audits, database optimization, and strategic modernization of legacy systems.',
        'services.card3_link': 'View service details',

        // Metodología
        'methodology.eyebrow': 'How We Work',
        'methodology.title': 'Agile methodology focused on tangible deliverables',
        'methodology.subtitle': 'A transparent, predictable, and validated process at every stage to minimize technical and business risks.',
        'methodology.step1_title': 'Diagnosis & Strategy',
        'methodology.step1_desc': 'Requirements assessment, feasibility analysis, and conceptual architecture design.',
        'methodology.step2_title': 'Design & Prototyping',
        'methodology.step2_desc': 'Data modeling, API interface definition, and key user flow wireframing.',
        'methodology.step3_title': 'Development & Testing',
        'methodology.step3_desc': 'Iterative sprints with unit, integration tests, and continuous code reviews.',
        'methodology.step4_title': 'Deployment & Monitoring',
        'methodology.step4_desc': 'Automated zero-downtime release to production with real-time alerts and constant technical support.',
        'methodology.btn': 'Explore our full methodology',

        // Tecnologías
        'tech.eyebrow': 'Ecosystem & Tools',
        'tech.title': 'Technologies proven in demanding environments',
        'tech.subtitle': 'We select the most efficient tools to guarantee long-term maintainability, speed, and security.',

        // Footer
        'footer.desc': 'High-performance software architecture, cloud engineering, and custom development to accelerate your company growth.',
        'footer.heading_nav': 'Navigation',
        'footer.heading_services': 'Services',
        'footer.heading_contact': 'Contact',
        'footer.contact_desc': 'Have a project in mind? Let us talk about taking it to the next level.',
        'footer.rights': 'All rights reserved.',
        'footer.serv_arch': 'Software Architecture',
        'footer.privacy': 'Privacy',
        'footer.terms': 'Terms',

        // Quiénes Somos (About)
        'about.breadcrumb': 'About Us',
        'about.hero_badge': 'About Us',
        'about.hero_title': 'Building the digital future with world-class <span class="text-gradient-light">software engineering</span>',
        'about.hero_subtitle': 'We are a technology company specializing in distributed software architecture, cloud-native solutions, and modernization of mission-critical platforms for businesses looking to scale frictionlessly.',
        'about.hero_btn_cta': 'Let\'s Work Together',
        'about.hero_btn_values': 'Our Culture',
        'about.card_lead_title': 'Engineering DNA',
        'about.card_lead_subtitle': 'Technical rigor and real value',
        'about.card_lead_desc': 'We do not believe in one-size-fits-all solutions. We engineer systems tailored to your business goals, focused on long-term maintainability and sustained performance.',
        'about.feat_item1': 'Scalable cloud architectures',
        'about.feat_item2': 'Comprehensive automation and CI/CD',
        'about.feat_item3': 'Security and global engineering standards',
        'about.purpose_eyebrow': 'Our Purpose',
        'about.purpose_title': 'Driven by a vision of measurable technological impact',
        'about.purpose_subtitle': 'We align advanced computer engineering with the strategic business goals of every client.',
        'about.mission_badge': 'Our Mission',
        'about.mission_title': 'Empowering growth through high-impact software',
        'about.mission_desc': 'Empowering enterprises and institutions by transforming operational and business challenges into robust, resilient, and efficient software architectures, delivering tangible value with every deployment.',
        'about.vision_badge': 'Our Vision',
        'about.vision_title': 'Becoming the benchmark technology partner in the region',
        'about.vision_desc': 'Establishing ourselves as the leading authority in software architecture, DevOps, and cloud computing, internationally recognized for our technical rigor, innovative capabilities, and lasting trust.',
        'about.values_eyebrow': 'Culture & Principles',
        'about.values_title': 'The core pillars guiding every line of code',
        'about.values_subtitle': 'Our culture is built on solid engineering principles, professional ethics, and operational excellence.',
        'about.val1_title': 'Technical Excellence',
        'about.val1_desc': 'We design with clean patterns, automated testing, and solid architectures. We take no shortcuts that compromise future security or maintainability.',
        'about.val2_title': 'Business-Driven',
        'about.val2_desc': 'Technology is a lever to drive tangible results. We prioritize decisions that maximize ROI and operational efficiency.',
        'about.val3_title': 'Radical Transparency',
        'about.val3_desc': 'Clear communication, realistic estimates, and total visibility of project health in demonstrable sprints without black boxes.',
        'about.val4_title': 'Pragmatic Innovation',
        'about.val4_desc': 'We embrace modern tooling (Cloud, Microservices, DevOps, AI) only when it delivers proven advantages for stability and velocity.',
        'about.metrics_eyebrow': 'Track Record & Results',
        'about.metrics_title': 'Numbers that back our commitment',
        'about.metrics_subtitle': 'We measure our success through operational stability and sustained value generated for our clients.',
        'about.kpi1_label': 'Deployed Projects',
        'about.kpi1_desc': 'High-availability corporate systems and web platforms',
        'about.kpi2_label': 'Average Uptime',
        'about.kpi2_desc': 'Resilient cloud infrastructure with load balancing',
        'about.kpi3_label': 'CI/CD Automation',
        'about.kpi3_desc': 'Continuous deployment pipelines with automated testing',
        'about.kpi4_label': 'Years of Experience',
        'about.kpi4_desc': 'Solving architecture and technical consulting challenges',
        'about.cta_title': 'Ready to take your infrastructure to the next level?',
        'about.cta_subtitle': 'Let us discuss your requirements and design a solid, scalable architecture optimized for your business goals.',
        'about.cta_btn_primary': 'Schedule Consulting'
    }
};

export default class extends Controller {
    static targets = ['flag', 'code'];
    static values = {
        lang: { type: String, default: 'es' },
        esFlag: String,
        usFlag: String
    };

    connect() {
        const saved = localStorage.getItem('softcore_lang');
        if (saved && (saved === 'es' || saved === 'en')) {
            this.langValue = saved;
        } else {
            this.langValue = 'es';
        }
        this.updateUI();
        if (this.langValue !== 'es') {
            this.applyTranslations();
        }
    }

    toggle(event) {
        if (event) {
            event.preventDefault();
        }

        // Animación suave de rotación / escala al hacer clic
        this.element.classList.add('switching');
        setTimeout(() => this.element.classList.remove('switching'), 300);

        this.langValue = this.langValue === 'es' ? 'en' : 'es';
        this.updateUI();
        this.applyTranslations();
        localStorage.setItem('softcore_lang', this.langValue);
        document.documentElement.lang = this.langValue;
    }

    updateUI() {
        if (this.langValue === 'en') {
            if (this.hasFlagTarget && this.usFlagValue) {
                this.flagTarget.src = this.usFlagValue;
                this.flagTarget.alt = 'English';
            }
            if (this.hasCodeTarget) {
                this.codeTarget.textContent = 'EN';
            }
            this.element.setAttribute('title', 'Switch language to Spanish (Español)');
            this.element.setAttribute('aria-label', 'Switch language to Spanish');
        } else {
            if (this.hasFlagTarget && this.esFlagValue) {
                this.flagTarget.src = this.esFlagValue;
                this.flagTarget.alt = 'Español';
            }
            if (this.hasCodeTarget) {
                this.codeTarget.textContent = 'ES';
            }
            this.element.setAttribute('title', 'Cambiar idioma a Inglés (English)');
            this.element.setAttribute('aria-label', 'Cambiar idioma entre Español e Inglés');
        }
    }

    applyTranslations() {
        const lang = this.langValue; // 'es' or 'en'
        const dict = translations[lang];
        if (!dict) return;

        // Elementos con texto plano
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (dict[key]) {
                el.textContent = dict[key];
            }
        });

        // Elementos con HTML (por ejemplo gradientes internos)
        document.querySelectorAll('[data-i18n-html]').forEach(el => {
            const key = el.getAttribute('data-i18n-html');
            if (dict[key]) {
                el.innerHTML = dict[key];
            }
        });
    }
}
