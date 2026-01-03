import { createApp } from 'vue';

// Import bootstrap to setup axios with CSRF token
import './bootstrap';

// Tabler JS (includes Bootstrap)
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

// Auto-initialize Vue components on admin pages
document.addEventListener('DOMContentLoaded', function() {
    const data = window.dashboardData || {};

    // Dynamically import Vue components if needed
    if (document.getElementById('stats-total-users') || document.getElementById('stats-revenue')) {
        import('./components/StatsCard.js').then(({ default: StatsCard }) => {
            if (document.getElementById('stats-total-users')) {
                window.createVueApp(StatsCard, {
                    title: 'Total Users',
                    value: data.totalUsers ?? 0,
                    trend: 2,
                    description: 'Total registered users'
                }).mount('#stats-total-users');
            }

            if (document.getElementById('stats-revenue')) {
                window.createVueApp(StatsCard, {
                    title: 'Revenue',
                    value: data.revenue ?? '$0',
                    trend: 12,
                    description: 'Total revenue'
                }).mount('#stats-revenue');
            }
        });
    }
});
