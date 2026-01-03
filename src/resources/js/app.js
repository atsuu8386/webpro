import { createApp } from 'vue';

// Import bootstrap to setup axios with CSRF token
import './bootstrap';

// Tabler JS (already includes Bootstrap, no need to import separately)
import '@tabler/core';

// Vue.js factory function for MPA
window.createVueApp = (component, props = {}) => {
    const app = createApp(component, props);
    return app;
};

// Theme toggle
document.addEventListener('DOMContentLoaded', function() {
    const theme = localStorage.getItem('theme') || 'light';
    if (theme === 'dark') {
        document.documentElement.setAttribute('data-bs-theme', 'dark');
    }
});

window.toggleTheme = () => {
    const currentTheme = document.documentElement.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('theme', newTheme);
};
