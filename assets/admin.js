import 'bootstrap/dist/css/bootstrap.min.css';
import Offcanvas from 'bootstrap/js/dist/offcanvas';
import 'bootstrap/js/dist/modal';
import 'bootstrap/js/dist/collapse';
import Dropdown from 'bootstrap/js/dist/dropdown';
import './styles/admin.css';

function initPasswordToggles() {
    document.querySelectorAll('[data-toggle-password]').forEach((button) => {
        if (button.dataset.toggleBound === 'true') {
            return;
        }
        button.dataset.toggleBound = 'true';

        button.addEventListener('click', () => {
            const targetSelector = button.getAttribute('data-toggle-password');
            if (!targetSelector) {
                return;
            }
            const input = document.querySelector(targetSelector);
            if (!input) {
                return;
            }

            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');
            button.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
            const label = isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña';
            button.setAttribute('aria-label', label);
            button.setAttribute('title', label);
        });
    });
}

function initSidebarToggleEffect() {
    const sidebar = document.getElementById('adminSidebar');
    const toggleBtn = document.querySelector('.sc-topbar-menu-btn');
    if (!sidebar || !toggleBtn || sidebar.dataset.toggleEffectBound === 'true') {
        return;
    }
    sidebar.dataset.toggleEffectBound = 'true';

    sidebar.addEventListener('show.bs.offcanvas', () => {
        toggleBtn.classList.add('is-open');
        toggleBtn.setAttribute('aria-expanded', 'true');
        toggleBtn.setAttribute('aria-label', 'Cerrar menú administrativo');
    });

    sidebar.addEventListener('hide.bs.offcanvas', () => {
        toggleBtn.classList.remove('is-open');
        toggleBtn.setAttribute('aria-expanded', 'false');
        toggleBtn.setAttribute('aria-label', 'Abrir menú administrativo');
    });
}

function initAdminLanguageToggle() {
    const button = document.querySelector('[data-admin-lang-toggle]');
    if (!button || button.dataset.langBound === 'true') {
        return;
    }
    button.dataset.langBound = 'true';

    const flagImg = button.querySelector('[data-admin-lang-flag]');
    const codeEl = button.querySelector('[data-admin-lang-code]');
    const esFlag = button.dataset.esFlag || '/images/flags/es.svg';
    const usFlag = button.dataset.usFlag || '/images/flags/us.svg';

    const applyLang = (lang) => {
        const isEn = lang === 'en';
        button.dataset.lang = isEn ? 'en' : 'es';
        if (flagImg) {
            flagImg.src = isEn ? usFlag : esFlag;
            flagImg.alt = isEn ? 'English' : 'Español';
        }
        if (codeEl) {
            codeEl.textContent = isEn ? 'EN' : 'ES';
        }
    };

    let savedLang = 'es';
    try {
        savedLang = localStorage.getItem('softcore_lang') || 'es';
    } catch {
        savedLang = 'es';
    }
    applyLang(savedLang);

    button.addEventListener('click', () => {
        const nextLang = button.dataset.lang === 'en' ? 'es' : 'en';
        button.classList.add('switching');
        setTimeout(() => button.classList.remove('switching'), 300);

        applyLang(nextLang);
        try {
            localStorage.setItem('softcore_lang', nextLang);
        } catch {
            // ignore storage errors
        }
    });
}

function initEcuadorClock() {
    const clockEl = document.querySelector('[data-ecuador-clock]');
    if (!clockEl || clockEl.dataset.clockBound === 'true') {
        return;
    }
    clockEl.dataset.clockBound = 'true';

    const formatter = new Intl.DateTimeFormat('en-US', {
        timeZone: 'America/Guayaquil',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true,
    });

    const updateClock = () => {
        clockEl.textContent = formatter.format(new Date());
    };

    updateClock();
    setInterval(updateClock, 1000);
}

function initHoverDropdowns() {
    if (!window.matchMedia('(hover: hover)').matches) {
        return;
    }

    const containers = Array.from(document.querySelectorAll('.sc-notif-dropdown, .sc-user-dropdown'));
    if (containers.length === 0) {
        return;
    }

    containers.forEach((container) => {
        if (container.dataset.hoverBound === 'true') {
            return;
        }
        container.dataset.hoverBound = 'true';

        const toggle = container.querySelector('[data-bs-toggle="dropdown"]');
        if (!toggle) {
            return;
        }

        let closeTimer = null;

        container.addEventListener('mouseenter', () => {
            if (closeTimer) {
                clearTimeout(closeTimer);
                closeTimer = null;
            }

            containers.forEach((other) => {
                if (other !== container) {
                    const otherToggle = other.querySelector('[data-bs-toggle="dropdown"]');
                    if (otherToggle) {
                        Dropdown.getOrCreateInstance(otherToggle).hide();
                    }
                }
            });

            Dropdown.getOrCreateInstance(toggle).show();
        });

        container.addEventListener('mouseleave', () => {
            closeTimer = setTimeout(() => {
                Dropdown.getOrCreateInstance(toggle).hide();
                closeTimer = null;
            }, 180);
        });
    });
}

function initAvatarPreview() {
    const input = document.querySelector('[data-avatar-input]');
    const container = document.querySelector('[data-avatar-preview]');
    if (!input || !container || input.dataset.previewBound === 'true') {
        return;
    }
    input.dataset.previewBound = 'true';

    input.addEventListener('change', () => {
        const file = input.files && input.files[0];
        if (!file || !file.type.startsWith('image/')) {
            return;
        }
        const reader = new FileReader();
        reader.onload = (event) => {
            const url = typeof event.target?.result === 'string' ? event.target.result : '';
            if (!url) {
                return;
            }
            let img = container.querySelector('[data-avatar-preview-img]');
            const fallback = container.querySelector('[data-avatar-preview-fallback]');
            if (fallback) {
                fallback.remove();
            }
            if (!img) {
                img = document.createElement('img');
                img.setAttribute('data-avatar-preview-img', '');
                img.alt = 'Vista previa de foto de perfil';
                container.appendChild(img);
            }
            img.src = url;
        };
        reader.readAsDataURL(file);
    });
}

function initSidebarSublinks() {
    const sidebar = document.getElementById('adminSidebar');
    if (!sidebar) {
        return;
    }

    sidebar.querySelectorAll('.sc-sidebar-sublink').forEach((link) => {
        if (link.dataset.sublinkBound === 'true') {
            return;
        }
        link.dataset.sublinkBound = 'true';

        link.addEventListener('click', () => {
            if (window.innerWidth < 992) {
                const instance = Offcanvas.getInstance(sidebar);
                if (instance) {
                    instance.hide();
                }
            }
        });
    });
}

function initAdminUI() {
    initPasswordToggles();
    initSidebarToggleEffect();
    initAdminLanguageToggle();
    initEcuadorClock();
    initHoverDropdowns();
    initAvatarPreview();
    initSidebarSublinks();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdminUI);
} else {
    initAdminUI();
}
