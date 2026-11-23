import { startStimulusApp } from '@symfony/stimulus-bundle';
import LanguageSwitcherController from './controllers/language_switcher_controller.js';

const app = startStimulusApp();
app.register('language-switcher', LanguageSwitcherController);

export { app };
