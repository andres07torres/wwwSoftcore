import { Controller } from '@hotwired/stimulus';

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
            this.updateUI();
        }
    }

    toggle(event) {
        if (event) {
            event.preventDefault();
        }

        // Animación suave de rotación al hacer clic
        this.element.classList.add('switching');
        setTimeout(() => this.element.classList.remove('switching'), 300);

        this.langValue = this.langValue === 'es' ? 'en' : 'es';
        this.updateUI();
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
            this.element.setAttribute('title', 'Switch language to Spanish');
        } else {
            if (this.hasFlagTarget && this.esFlagValue) {
                this.flagTarget.src = this.esFlagValue;
                this.flagTarget.alt = 'Español';
            }
            if (this.hasCodeTarget) {
                this.codeTarget.textContent = 'ES';
            }
            this.element.setAttribute('title', 'Cambiar idioma a Inglés');
        }
    }
}
