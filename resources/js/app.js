// وارد کردن Alpine.js و شروع آن
import Alpine from 'alpinejs';
window.Alpine = Alpine;
window.Choices = Choices;
Alpine.start();

// وارد کردن popper.js (برای Bootstrap)
import { createPopper } from '@popperjs/core';

// وارد کردن Bootstrap و اطمینان از دسترسی به آن در window
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// وارد کردن adminlte
import '../../node_modules/admin-lte/dist/js/adminlte';
