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
        'about.hero_stat1': 'Años de Trayectoria',
        'about.hero_stat2': 'Sistemas Desplegados',
        'about.hero_stat3': 'Uptime Promedio',
        'about.hero_caption': 'Ingeniería de Software & Arquitectura Cloud · SoftCore',
        'about.float1_val': '+99.9% Uptime',
        'about.float1_lbl': 'Arquitectura Cloud Resiliente',
        'about.float2_lbl': '100% Código Probado CI/CD',
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
        'about.cta_btn_primary': 'Agendar Consultoría',

        // Servicios (Services Page)
        'services_page.hero_badge': 'Capacidades de Ingeniería End-to-End',
        'services_page.hero_title': 'Servicios de ingeniería diseñados para <span class="text-gradient-light">escalar tu negocio</span>',
        'services_page.hero_subtitle': 'Acompañamos a tu empresa en cada fase del ciclo tecnológico: desde el diseño conceptual de arquitecturas robustas hasta el despliegue cloud automatizado y la optimización continua.',
        'services_page.hero_btn_cta': 'Iniciar Proyecto',
        'services_page.hero_btn_whatsapp': 'Consultar por WhatsApp',
        'services_page.hero_btn_catalog': 'Explorar Soluciones',
        'services_page.domain_software': 'Software & APIs',
        'services_page.domain_cloud': 'Cloud DevOps',
        'services_page.domain_data': 'Bases de Datos',
        'services_page.domain_security': 'Ciberseguridad OWASP',
        'services_page.hero_caption': 'Desarrollo Full-Lifecycle & Arquitectura Cloud · SoftCore',
        'services_page.catalog_eyebrow': 'Nuestro Portafolio',
        'services_page.catalog_title': 'Soluciones diseñadas con rigor técnico',
        'services_page.catalog_subtitle': 'Arquitecturas escalables, código limpio y buenas prácticas de ingeniería para resolver desafíos de alto impacto.',
        'services_page.serv1_cat': 'Desarrollo Core',
        'services_page.serv1_title': 'Software a Medida & APIs',
        'services_page.serv1_desc': 'Construimos backends robustos, arquitecturas limpias y APIs RESTful/GraphQL de alto rendimiento orientadas a operaciones críticas de negocio.',
        'services_page.serv1_cap1': 'Arquitecturas limpias (Hexagonal / DDD)',
        'services_page.serv1_cap2': 'APIs RESTful y GraphQL escalables',
        'services_page.serv1_cap3': 'Integración continua y tests automáticos',
        'services_page.serv2_cat': 'Infraestructura & Cloud',
        'services_page.serv2_title': 'Cloud Architecture & DevOps',
        'services_page.serv2_desc': 'Infraestructura como código y pipelines automatizados que eliminan la fricción operativa y garantizan disponibilidad continua.',
        'services_page.serv2_cap1': 'Infraestructura como Código (Terraform)',
        'services_page.serv2_cap2': 'Contenedores con Kubernetes y Docker',
        'services_page.serv2_cap3': 'Flujos CI/CD automatizados y seguros',
        'services_page.serv3_cat': 'Frontend & UX',
        'services_page.serv3_title': 'Aplicaciones Web & Móviles',
        'services_page.serv3_desc': 'Interfaces de usuario reactivas, de carga ultra rápida y diseño intuitivo, optimizadas para la conversión y la retención del usuario.',
        'services_page.serv3_cap1': 'SPAs y plataformas interactivas',
        'services_page.serv3_cap2': 'Optimización Core Web Vitals',
        'services_page.serv3_cap3': 'Enfoque Mobile-First adaptable',
        'services_page.serv4_cat': 'Estrategia Tecnológica',
        'services_page.serv4_title': 'Consultoría & Auditoría IT',
        'services_page.serv4_desc': 'Diagnóstico integral de sistemas, identificación de cuellos de botella y mitigación de deuda técnica para asegurar estabilidad operativa.',
        'services_page.serv4_cap1': 'Auditoría de código y arquitectura',
        'services_page.serv4_cap2': 'Planes de modernización de legado',
        'services_page.serv4_cap3': 'Optimización de costos cloud',
        'services_page.serv5_cat': 'Persistencia & Datos',
        'services_page.serv5_title': 'Bases de Datos & Rendimiento',
        'services_page.serv5_desc': 'Modelado relacional avanzado, afinamiento de consultas SQL y capas de caché distribuido para sostener millones de transacciones.',
        'services_page.serv5_cap1': 'Indexación y afinamiento de queries',
        'services_page.serv5_cap2': 'Caché de alto rendimiento con Redis',
        'services_page.serv5_cap3': 'Replicación y alta disponibilidad',
        'services_page.serv6_cat': 'Seguridad & Continuidad',
        'services_page.serv6_title': 'Ciberseguridad & Hardening',
        'services_page.serv6_desc': 'Protección perimetral y seguridad por diseño en cada capa de la aplicación, siguiendo directrices OWASP y gestión criptográfica moderna.',
        'services_page.serv6_cap1': 'Mitigación OWASP Top 10',
        'services_page.serv6_cap2': 'Autenticación segura (OAuth2 / JWT)',
        'services_page.serv6_cap3': 'Hardening de servidores y contenedores',
        'services_page.workflow_eyebrow': 'Cómo Trabajamos',
        'services_page.workflow_title': 'Un proceso claro, predecible y orientado a resultados',
        'services_page.workflow_subtitle': 'De la conceptualización a la producción con transparencia total y validación rigurosa en cada hito.',
        'services_page.step1_title': 'Diagnóstico & Estrategia',
        'services_page.step1_desc': 'Analizamos tus requerimientos técnicos, evaluamos la arquitectura actual y definimos una propuesta de solución clara y viable.',
        'services_page.step2_title': 'Desarrollo Iterativo',
        'services_page.step2_desc': 'Avanzamos en sprints ágiles con entregables funcionales, revisiones de código exhaustivas y comunicación continua.',
        'services_page.step3_title': 'QA & Seguridad CI/CD',
        'services_page.step3_desc': 'Pruebas unitarias, de integración y escaneo de vulnerabilidades integrados en cada despliegue automatizado.',
        'services_page.step4_title': 'Despliegue & Soporte',
        'services_page.step4_desc': 'Pase a producción sin tiempo de inactividad, monitoreo continuo del rendimiento y soporte proactivo post-lanzamiento.',
        'services_page.cta_title': '¿Tienes un proyecto desafiante en mente?',
        'services_page.cta_subtitle': 'Conversemos sobre tus metas tecnológicas y diseñemos juntos la arquitectura ideal para alcanzarlas con éxito.',
        'services_page.cta_btn_whatsapp': 'Contactar por WhatsApp',

        'services_page.form_eyebrow': 'Hablemos de Ingeniería',
        'services_page.form_title': '¿Tienes un proyecto desafiante en mente?',
        'services_page.form_subtitle': 'Conversemos sobre tus metas tecnológicas y diseñemos juntos una arquitectura sólida, escalable y optimizada para tu negocio.',
        'services_page.form_feat1': 'Respuesta técnica en menos de 24 horas',
        'services_page.form_feat2': 'Acuerdo de confidencialidad (NDA) garantizado',
        'services_page.form_feat3': 'Diagnóstico preliminar sin costo ni compromiso',
        'services_page.form_whatsapp_alt': '¿Prefieres una consulta inmediata?',
        'services_page.form_btn_whatsapp': 'Escribir por WhatsApp',
        'services_page.form_card_title': 'Solicitar Asesoría Técnica',
        'services_page.form_card_subtitle': 'Completa el formulario y analizaremos tus requerimientos sin costo inicial.',
        'services_page.form_lbl_name': 'Nombre Completo',
        'services_page.form_ph_name': 'Ej. Carlos Torres',
        'services_page.form_lbl_email': 'Correo Corporativo',
        'services_page.form_ph_email': 'nombre@empresa.com',
        'services_page.form_lbl_company': 'Empresa / Organización',
        'services_page.form_ph_company': 'Tu empresa o startup',
        'services_page.form_lbl_service': 'Servicio de Interés',
        'services_page.form_opt_select': 'Selecciona una opción...',
        'services_page.form_opt_1': 'Software a Medida & APIs',
        'services_page.form_opt_2': 'Cloud Architecture & DevOps',
        'services_page.form_opt_3': 'Aplicaciones Web & Móviles',
        'services_page.form_opt_4': 'Consultoría & Auditoría IT',
        'services_page.form_opt_5': 'Bases de Datos & Rendimiento',
        'services_page.form_opt_6': 'Ciberseguridad & Hardening',
        'services_page.form_opt_other': 'Otro requerimiento',
        'services_page.form_lbl_message': 'Cuéntanos sobre tu proyecto',
        'services_page.form_ph_message': 'Describe brevemente tus requerimientos técnicos, metas o plazos estimados...',
        'services_page.form_btn_submit': 'Enviar Solicitud de Asesoría',
        'services_page.form_privacy': 'Tus datos están protegidos. Confidencialidad técnica garantizada.',

        // Metodología (Página Dedicada)
        'methodology_page.hero_badge': 'Ingeniería Ágil & Predecible',
        'methodology_page.hero_title': 'Metodología diseñada para <span class="text-gradient-light">entregas continuas</span> y valor medible',
        'methodology_page.hero_subtitle': 'Combinamos rigor de arquitectura, sprints iterativos y automatización CI/CD para convertir requerimientos complejos en software robusto, escalable y sin fricción operativa.',
        'methodology_page.hero_btn_cta': 'Iniciar Proyecto',
        'methodology_page.hero_btn_phases': 'Explorar las Fases',
        'methodology_page.hero_flow_note': 'Ciclos de 2 semanas · Demostraciones en staging · Transparencia radical',
        'methodology_page.pipe1_title': 'Descubrimiento & Estrategia',
        'methodology_page.pipe1_desc': 'SAD, contratos y backlog priorizado',
        'methodology_page.pipe2_title': 'Arquitectura & Diseño C4',
        'methodology_page.pipe2_desc': 'OpenAPI, esquemas BD e infraestructura base',
        'methodology_page.pipe3_title': 'Sprints Ágiles Iterativos',
        'methodology_page.pipe3_desc': 'Entregas quincenales funcionales en staging',
        'methodology_page.pipe4_title': 'QA & Hardening OWASP',
        'methodology_page.pipe4_desc': 'Tests automatizados de carga y seguridad',
        'methodology_page.pipe5_title': 'Despliegue Continuo Cloud',
        'methodology_page.pipe5_desc': 'Zero-downtime, telemetría y soporte 24/7',
        'methodology_page.pillars_eyebrow': 'Nuestra Filosofía',
        'methodology_page.pillars_title': 'Principios que garantizan predictibilidad y calidad',
        'methodology_page.pillars_subtitle': 'Estructuramos cada desarrollo para reducir la incertidumbre, acelerar el time-to-market y proteger la estabilidad de tus operaciones.',
        'methodology_page.p1_title': 'Architecture-First',
        'methodology_page.p1_desc': 'Definición formal de contratos API, esquemas de persistencia y patrones limpios antes de escribir una sola línea de código funcional.',
        'methodology_page.p2_title': 'Sprints Iterativos',
        'methodology_page.p2_desc': 'Ciclos de entrega de 2 semanas con demostraciones funcionales continuas. Cero cajas negras y visibilidad total del avance.',
        'methodology_page.p3_title': 'QA & CI/CD Automatizado',
        'methodology_page.p3_desc': 'Cada pull request pasa por un pipeline estricto de pruebas unitarias, análisis estático y escaneo de vulnerabilidades.',
        'methodology_page.p4_title': 'Transparencia Radical',
        'methodology_page.p4_desc': 'Tableros de gestión compartidos, estimaciones realistas y acceso directo al equipo de ingeniería sin intermediarios.',
        'methodology_page.phases_eyebrow': 'Ciclo de Entrega',
        'methodology_page.phases_title': 'De la idea a la producción en 5 etapas',
        'methodology_page.phases_subtitle': 'Un flujo estructurado donde cada fase cuenta con objetivos claros y entregables técnicos verificables.',
        'methodology_page.deliverable_lbl': 'Entregable:',
        'methodology_page.f1_dur': 'Semana 1 - 2',
        'methodology_page.f1_title': 'Descubrimiento & Diagnóstico Estratégico',
        'methodology_page.f1_desc': 'Iniciamos con una inmersión profunda en tu modelo de negocio, requerimientos funcionales y sistemas existentes. Evaluamos riesgos técnicos, dependencias e identificamos oportunidades de optimización.',
        'methodology_page.f1_deliv': 'Documento de Arquitectura de Solución (SAD) y backlog priorizado',
        'methodology_page.f2_dur': 'Semana 2 - 3',
        'methodology_page.f2_title': 'Arquitectura & Diseño de Solución',
        'methodology_page.f2_desc': 'Modelamos las entidades de datos, especificamos contratos de API (OpenAPI/Swagger), diseñamos los flujos de usuario y configuramos la infraestructura base en la nube mediante código (Terraform).',
        'methodology_page.f2_deliv': 'Diagramas de arquitectura C4, esquemas de BD y prototipos de interfaz',
        'methodology_page.f3_dur': 'Sprints quincenales',
        'methodology_page.f3_title': 'Desarrollo Iterativo & Sprints Ágiles',
        'methodology_page.f3_desc': 'Desarrollamos en sprints de dos semanas bajo metodologías ágiles. Cada sprint culmina con una sesión de demostración del software funcionando en un entorno de staging para recibir retroalimentación temprana.',
        'methodology_page.f3_deliv': 'Incrementos de software funcionales desplegados en staging para revisión',
        'methodology_page.f4_dur': 'Fase de validación',
        'methodology_page.f4_title': 'Aseguramiento de Calidad & Hardening de Seguridad',
        'methodology_page.f4_desc': 'Pruebas exhaustivas de carga y estrés, verificación de seguridad OWASP, validación de compatibilidad multidispositivo y pruebas de aceptación de usuario (UAT) para asegurar máxima estabilidad.',
        'methodology_page.f4_deliv': 'Reporte de QA, matriz de pruebas de seguridad y certificación para salida',
        'methodology_page.f5_dur': 'Continuo',
        'methodology_page.f5_title': 'Despliegue Automatizado & Operación Cloud',
        'methodology_page.f5_desc': 'Pase a producción automatizado mediante estrategias Blue/Green o Canary (sin tiempo de inactividad). Activación de alertas de monitoreo 24/7 y acompañamiento técnico post-lanzamiento.',
        'methodology_page.f5_deliv': 'Sistema en producción, dashboards de observabilidad y soporte continuo',
        'methodology_page.standards_eyebrow': 'Buenas Prácticas',
        'methodology_page.standards_title': 'Estándares técnicos no negociables',
        'methodology_page.standards_subtitle': 'Nuestro código y nuestras arquitecturas están respaldados por convenciones internacionales de la industria.',
        'methodology_page.s1_title': 'Clean Code & SOLID',
        'methodology_page.s1_desc': 'Arquitecturas limpias y código desacoplado que facilitan el mantenimiento a largo plazo y la incorporación de nuevos desarrolladores.',
        'methodology_page.s2_title': 'CI/CD & GitFlow',
        'methodology_page.s2_desc': 'Estrategia estricta de ramas, pull requests revisados por al menos dos ingenieros sénior y despliegues automáticos certificados.',
        'methodology_page.s3_title': 'Seguridad por Diseño',
        'methodology_page.s3_desc': 'Escaneo continuo de dependencias, protección contra inyecciones y cumplimiento de las 10 directrices clave de OWASP.',
        'methodology_page.s4_title': 'Observabilidad 24/7',
        'methodology_page.s4_desc': 'Trazabilidad distribuida, métricas de rendimiento y alertas automatizadas para detectar anomalías antes de que impacten al usuario.',
        'methodology_page.cta_title': '¿Quieres aplicar esta metodología en tu próximo proyecto?',
        'methodology_page.cta_subtitle': 'Hablemos de tus requerimientos y diseñemos una hoja de ruta ágil con entregables claros desde el primer sprint.',
        'methodology_page.cta_btn_whatsapp': 'Contactar por WhatsApp'
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
        'about.hero_stat1': 'Years of Track Record',
        'about.hero_stat2': 'Deployed Platforms',
        'about.hero_stat3': 'Average SLA Uptime',
        'about.hero_caption': 'Software Engineering & Cloud Architecture · SoftCore',
        'about.float1_val': '+99.9% Uptime',
        'about.float1_lbl': 'Resilient Cloud Architecture',
        'about.float2_lbl': '100% CI/CD Tested Code',
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
        'about.cta_btn_primary': 'Schedule Consulting',

        // Services Page
        'services_page.hero_badge': 'End-to-End Engineering Capabilities',
        'services_page.hero_title': 'Engineering services designed to <span class="text-gradient-light">scale your business</span>',
        'services_page.hero_subtitle': 'We guide your company through every stage of the technology lifecycle: from robust architecture design to automated cloud deployment and continuous optimization.',
        'services_page.hero_btn_cta': 'Start Project',
        'services_page.hero_btn_whatsapp': 'Inquire via WhatsApp',
        'services_page.hero_btn_catalog': 'Explore Solutions',
        'services_page.domain_software': 'Software & APIs',
        'services_page.domain_cloud': 'Cloud DevOps',
        'services_page.domain_data': 'Databases',
        'services_page.domain_security': 'OWASP Cybersecurity',
        'services_page.hero_caption': 'Full-Lifecycle Development & Cloud Architecture · SoftCore',
        'services_page.catalog_eyebrow': 'Our Portfolio',
        'services_page.catalog_title': 'Solutions designed with technical rigor',
        'services_page.catalog_subtitle': 'Scalable architectures, clean code, and engineering best practices to solve high-impact challenges.',
        'services_page.serv1_cat': 'Core Development',
        'services_page.serv1_title': 'Custom Software & APIs',
        'services_page.serv1_desc': 'We build robust backends, clean architectures, and high-performance RESTful/GraphQL APIs tailored for mission-critical business operations.',
        'services_page.serv1_cap1': 'Clean Architectures (Hexagonal / DDD)',
        'services_page.serv1_cap2': 'Scalable RESTful & GraphQL APIs',
        'services_page.serv1_cap3': 'Continuous integration & automated testing',
        'services_page.serv2_cat': 'Infrastructure & Cloud',
        'services_page.serv2_title': 'Cloud Architecture & DevOps',
        'services_page.serv2_desc': 'Infrastructure as code and automated pipelines that eliminate operational friction and guarantee continuous uptime.',
        'services_page.serv2_cap1': 'Infrastructure as Code (Terraform)',
        'services_page.serv2_cap2': 'Containers with Kubernetes & Docker',
        'services_page.serv2_cap3': 'Automated, secure CI/CD pipelines',
        'services_page.serv3_cat': 'Frontend & UX',
        'services_page.serv3_title': 'Web & Mobile Applications',
        'services_page.serv3_desc': 'Responsive, ultra-fast user interfaces with intuitive design optimized for user conversion and engagement retention.',
        'services_page.serv3_cap1': 'SPAs & interactive web platforms',
        'services_page.serv3_cap2': 'Core Web Vitals performance tuning',
        'services_page.serv3_cap3': 'Adaptive mobile-first layout',
        'services_page.serv4_cat': 'Technology Strategy',
        'services_page.serv4_title': 'IT Consulting & Code Audit',
        'services_page.serv4_desc': 'Comprehensive system assessments, bottleneck discovery, and technical debt mitigation to ensure long-term stability.',
        'services_page.serv4_cap1': 'Code quality & architecture audits',
        'services_page.serv4_cap2': 'Legacy modernization roadmaps',
        'services_page.serv4_cap3': 'Cloud cost optimization',
        'services_page.serv5_cat': 'Persistence & Data',
        'services_page.serv5_title': 'Databases & Performance',
        'services_page.serv5_desc': 'Advanced relational data modeling, query tuning, and distributed cache layers to handle millions of transactions.',
        'services_page.serv5_cap1': 'Indexing & complex query tuning',
        'services_page.serv5_cap2': 'High-throughput caching with Redis',
        'services_page.serv5_cap3': 'Replication & high availability',
        'services_page.serv6_cat': 'Security & Continuity',
        'services_page.serv6_title': 'Cybersecurity & Hardening',
        'services_page.serv6_desc': 'Perimeter defense and security-by-design at every application layer, following OWASP standards and modern cryptography.',
        'services_page.serv6_cap1': 'OWASP Top 10 mitigation',
        'services_page.serv6_cap2': 'Secure authentication (OAuth2 / JWT)',
        'services_page.serv6_cap3': 'Server & container hardening',
        'services_page.workflow_eyebrow': 'How We Work',
        'services_page.workflow_title': 'A clear, predictable, and results-oriented process',
        'services_page.workflow_subtitle': 'From conceptualization to production with full transparency and rigorous validation at every milestone.',
        'services_page.step1_title': 'Discovery & Strategy',
        'services_page.step1_desc': 'We analyze your technical requirements, audit existing architecture, and define an actionable, viable roadmap.',
        'services_page.step2_title': 'Iterative Development',
        'services_page.step2_desc': 'We advance in agile sprints delivering working software, comprehensive code reviews, and continuous communication.',
        'services_page.step3_title': 'QA & CI/CD Security',
        'services_page.step3_desc': 'Unit and integration tests paired with automated vulnerability scans embedded directly in deployment pipelines.',
        'services_page.step4_title': 'Deployment & Support',
        'services_page.step4_desc': 'Zero-downtime releases, proactive performance monitoring, and dependable post-launch engineering support.',
        'services_page.cta_title': 'Have an ambitious project in mind?',
        'services_page.cta_subtitle': 'Let us talk about your technological goals and design the ideal architecture to achieve them successfully.',
        'services_page.cta_btn_whatsapp': 'Contact via WhatsApp',

        'services_page.form_eyebrow': 'Let us Talk Engineering',
        'services_page.form_title': 'Have an ambitious project in mind?',
        'services_page.form_subtitle': 'Let us discuss your technological goals and design a solid, scalable, and business-optimized architecture together.',
        'services_page.form_feat1': 'Technical response within 24 hours',
        'services_page.form_feat2': 'Non-Disclosure Agreement (NDA) guaranteed',
        'services_page.form_feat3': 'Preliminary diagnosis with no initial commitment',
        'services_page.form_whatsapp_alt': 'Prefer an immediate response?',
        'services_page.form_btn_whatsapp': 'Message on WhatsApp',
        'services_page.form_card_title': 'Request Technical Consulting',
        'services_page.form_card_subtitle': 'Fill out the form and we will assess your requirements at no initial cost.',
        'services_page.form_lbl_name': 'Full Name',
        'services_page.form_ph_name': 'e.g. John Doe',
        'services_page.form_lbl_email': 'Corporate Email',
        'services_page.form_ph_email': 'name@company.com',
        'services_page.form_lbl_company': 'Company / Organization',
        'services_page.form_ph_company': 'Your company or startup',
        'services_page.form_lbl_service': 'Area of Interest',
        'services_page.form_opt_select': 'Select an option...',
        'services_page.form_opt_1': 'Custom Software & APIs',
        'services_page.form_opt_2': 'Cloud Architecture & DevOps',
        'services_page.form_opt_3': 'Web & Mobile Applications',
        'services_page.form_opt_4': 'IT Consulting & Code Audit',
        'services_page.form_opt_5': 'Databases & Performance',
        'services_page.form_opt_6': 'Cybersecurity & Hardening',
        'services_page.form_opt_other': 'Other requirements',
        'services_page.form_lbl_message': 'Tell us about your project',
        'services_page.form_ph_message': 'Briefly describe your technical goals, requirements, or timeline...',
        'services_page.form_btn_submit': 'Submit Consulting Request',
        'services_page.form_privacy': 'Your information is protected. Professional technical confidentiality guaranteed.',

        // Methodology (Dedicated Page)
        'methodology_page.hero_badge': 'Agile & Predictable Engineering',
        'methodology_page.hero_title': 'Methodology designed for <span class="text-gradient-light">continuous delivery</span> and measurable value',
        'methodology_page.hero_subtitle': 'We combine architectural rigor, iterative sprints, and CI/CD automation to transform complex requirements into robust, scalable software with zero operational friction.',
        'methodology_page.hero_btn_cta': 'Start Project',
        'methodology_page.hero_btn_phases': 'Explore the Phases',
        'methodology_page.hero_flow_note': '2-week sprint cycles · Continuous staging demos · Radical transparency',
        'methodology_page.pipe1_title': 'Discovery & Strategy',
        'methodology_page.pipe1_desc': 'SAD, architecture contracts & prioritized backlog',
        'methodology_page.pipe2_title': 'Architecture & C4 Design',
        'methodology_page.pipe2_desc': 'OpenAPI specs, DB schemas & IaC foundations',
        'methodology_page.pipe3_title': 'Iterative Agile Sprints',
        'methodology_page.pipe3_desc': 'Bi-weekly functional increments in staging',
        'methodology_page.pipe4_title': 'QA & OWASP Hardening',
        'methodology_page.pipe4_desc': 'Automated load & security vulnerability scans',
        'methodology_page.pipe5_title': 'Continuous Cloud Deployment',
        'methodology_page.pipe5_desc': 'Zero-downtime, telemetry alerts & 24/7 hypercare',
        'methodology_page.pillars_eyebrow': 'Our Philosophy',
        'methodology_page.pillars_title': 'Principles ensuring predictability and quality',
        'methodology_page.pillars_subtitle': 'We structure every development cycle to minimize uncertainty, accelerate time-to-market, and protect operational stability.',
        'methodology_page.p1_title': 'Architecture-First',
        'methodology_page.p1_desc': 'Formal definition of API contracts, persistence schemas, and clean patterns before writing a single line of production code.',
        'methodology_page.p2_title': 'Iterative Sprints',
        'methodology_page.p2_desc': 'Two-week delivery cycles with continuous working demos. Zero black boxes and full visibility into progress.',
        'methodology_page.p3_title': 'Automated QA & CI/CD',
        'methodology_page.p3_desc': 'Every pull request passes through a strict pipeline of unit tests, static analysis, and security vulnerability scans.',
        'methodology_page.p4_title': 'Radical Transparency',
        'methodology_page.p4_desc': 'Shared project boards, realistic estimates, and direct access to the engineering team without intermediaries.',
        'methodology_page.phases_eyebrow': 'Delivery Lifecycle',
        'methodology_page.phases_title': 'From concept to production in 5 stages',
        'methodology_page.phases_subtitle': 'A structured workflow where each phase has clear goals and verifiable technical deliverables.',
        'methodology_page.deliverable_lbl': 'Deliverable:',
        'methodology_page.f1_dur': 'Weeks 1 - 2',
        'methodology_page.f1_title': 'Discovery & Strategic Assessment',
        'methodology_page.f1_desc': 'We begin with a deep dive into your business model, functional requirements, and legacy systems to assess technical risks, map dependencies, and prioritize opportunities.',
        'methodology_page.f1_deliv': 'Solution Architecture Document (SAD) and prioritized product backlog',
        'methodology_page.f2_dur': 'Weeks 2 - 3',
        'methodology_page.f2_title': 'Architecture & Solution Design',
        'methodology_page.f2_desc': 'We model data entities, specify API contracts (OpenAPI/Swagger), design user flows, and provision foundational cloud infrastructure via Infrastructure as Code (Terraform).',
        'methodology_page.f2_deliv': 'C4 architecture diagrams, database schemas, and interactive prototypes',
        'methodology_page.f3_dur': 'Bi-weekly sprints',
        'methodology_page.f3_title': 'Iterative Development & Agile Sprints',
        'methodology_page.f3_desc': 'We build in two-week agile sprints. Each sprint concludes with a live demo of functional software deployed to a staging environment for early stakeholder feedback.',
        'methodology_page.f3_deliv': 'Functional software increments deployed to staging for validation',
        'methodology_page.f4_dur': 'Validation phase',
        'methodology_page.f4_title': 'Quality Assurance & Security Hardening',
        'methodology_page.f4_desc': 'Comprehensive load and stress testing, OWASP security compliance audits, cross-device compatibility checks, and UAT to guarantee maximum reliability.',
        'methodology_page.f4_deliv': 'QA test report, security audit matrix, and production release sign-off',
        'methodology_page.f5_dur': 'Continuous',
        'methodology_page.f5_title': 'Automated Deployment & Cloud Operations',
        'methodology_page.f5_desc': 'Zero-downtime production releases via Blue/Green or Canary rollouts. Real-time 24/7 observability alerts and dedicated post-launch hypercare.',
        'methodology_page.f5_deliv': 'Live production system, observability dashboards, and ongoing support',
        'methodology_page.standards_eyebrow': 'Best Practices',
        'methodology_page.standards_title': 'Non-negotiable technical standards',
        'methodology_page.standards_subtitle': 'Our code and cloud architectures are governed by international industry conventions and clean code benchmarks.',
        'methodology_page.s1_title': 'Clean Code & SOLID',
        'methodology_page.s1_desc': 'Clean architecture and decoupled code designed for long-term maintainability and smooth team scaling.',
        'methodology_page.s2_title': 'CI/CD & GitFlow',
        'methodology_page.s2_desc': 'Strict branching strategies, mandatory multi-peer reviews by senior engineers, and certified automated build pipelines.',
        'methodology_page.s3_title': 'Security by Design',
        'methodology_page.s3_desc': 'Continuous dependency vulnerability scanning, injection protection, and OWASP Top 10 compliance baked in.',
        'methodology_page.s4_title': '24/7 Observability',
        'methodology_page.s4_desc': 'Distributed tracing, runtime telemetry, and proactive alerting to resolve anomalies before they ever reach end users.',
        'methodology_page.cta_title': 'Ready to apply this methodology to your next project?',
        'methodology_page.cta_subtitle': 'Let’s discuss your technical vision and define an agile roadmap with clear deliverables starting in Sprint 1.',
        'methodology_page.cta_btn_whatsapp': 'Contact via WhatsApp'
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

        // Elementos con placeholder (inputs y textareas)
        document.querySelectorAll('[data-i18n-ph]').forEach(el => {
            const key = el.getAttribute('data-i18n-ph');
            if (dict[key]) {
                el.setAttribute('placeholder', dict[key]);
            }
        });
    }
}
