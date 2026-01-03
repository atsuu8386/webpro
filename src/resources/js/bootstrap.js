import axios from 'axios';

// Configure axios defaults
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// CSRF Token setup
function setupCSRFToken() {
    const token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        window.axios = axios; // Also set to window for backward compatibility
    } else {
        console.error('CSRF token not found');
    }
}

// Setup CSRF token immediately
setupCSRFToken();

// Also setup when DOM is ready (in case meta tag is added later)
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupCSRFToken);
} else {
    setupCSRFToken();
}

// Export configured axios instance
export default axios;
