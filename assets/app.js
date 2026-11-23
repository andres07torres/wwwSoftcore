import './stimulus_bootstrap.js';

// Importar Bootstrap (CSS y componentes JS como Collapse, Dropdown, etc.)
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

// Hoja de estilos generales de la aplicación
import './styles/styles.css';

// Compilar y emitir automáticamente todas las imágenes de assets/images
import.meta.glob('./images/**', { eager: true });

console.log('Softcore frontend assets loaded successfully 🚀');
