import './stimulus_bootstrap.js';

// Importar Bootstrap (CSS y componentes JS como Collapse, Dropdown, etc.)
import 'bootstrap/dist/css/bootstrap.min.css';
import { Alert } from 'bootstrap';

// Cierre automático de alertas (Flash Messages) tras 5 segundos con desvanecimiento suave
function initAutoDismissAlerts() {
    const alerts = document.querySelectorAll('.alert-auto-dismiss, .alert-dismissible, .services-form-card .alert');
    alerts.forEach((alertEl) => {
        if (alertEl.dataset.autoDismissInitialized) return;
        alertEl.dataset.autoDismissInitialized = 'true';

        setTimeout(() => {
            if (!document.body.contains(alertEl)) return;
            try {
                const bsAlert = Alert.getOrCreateInstance(alertEl);
                bsAlert.close();
            } catch {
                alertEl.classList.remove('show');
                setTimeout(() => {
                    if (document.body.contains(alertEl)) {
                        alertEl.remove();
                    }
                }, 300);
            }
        }, 5000);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAutoDismissAlerts);
} else {
    initAutoDismissAlerts();
}
document.addEventListener('turbo:load', initAutoDismissAlerts);

// Hoja de estilos generales de la aplicación
import './styles/styles.css';

// Compilar y emitir automáticamente todas las imágenes de assets/images
import.meta.glob('./images/**', { eager: true });

console.log('Softcore frontend assets loaded successfully 🚀');
