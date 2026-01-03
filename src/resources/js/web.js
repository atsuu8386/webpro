// Web site JavaScript - Using jQuery
import './bootstrap';

// Import jQuery
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

// Import Bootstrap (for jQuery)
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Web site specific JavaScript
$(document).ready(function() {
    // Example: Smooth scroll
    $('a[href^="#"]').on('click', function(event) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });

    // Example: Form validation
    $('form').on('submit', function(e) {
        const form = $(this);
        if (form[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.addClass('was-validated');
    });

    // Add your web site specific JavaScript here
    console.log('Web site JavaScript loaded');
});
