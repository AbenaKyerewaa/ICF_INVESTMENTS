import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

document.addEventListener('DOMContentLoaded', () => {
    const shellToggle = document.querySelector('[data-shell-toggle]');
    const sidebar = document.querySelector('[data-sidebar]');

    shellToggle?.addEventListener('click', () => {
        sidebar?.classList.toggle('is-open');
    });
});
