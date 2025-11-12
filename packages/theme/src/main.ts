/**
 * CloudStudio Theme - Main Entry Point
 * 
 * Modern theme utilities and enhancements
 */

import './styles/main.css';

// Theme initialization
document.addEventListener('DOMContentLoaded', () => {
    console.log('CloudStudio Theme v2.0.0 loaded');

    initDarkMode();
    initSmoothScroll();
    initLazyLoad();
});

/**
 * Dark mode toggle
 */
function initDarkMode(): void {
    const toggle = document.getElementById('dark-mode-toggle');

    if (!toggle) return;

    // Check saved preference
    const savedMode = localStorage.getItem('cloudstudio-dark-mode');
    if (savedMode === 'true') {
        document.body.classList.add('cloudstudio-dark-mode');
    }

    toggle.addEventListener('click', () => {
        const isDark = document.body.classList.toggle('cloudstudio-dark-mode');
        localStorage.setItem('cloudstudio-dark-mode', String(isDark));
    });
}

/**
 * Smooth scroll for anchor links
 */
function initSmoothScroll(): void {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (e) => {
            const href = anchor.getAttribute('href');
            if (!href || href === '#') return;

            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                });
            }
        });
    });
}

/**
 * Lazy load images
 */
function initLazyLoad(): void {
    const images = document.querySelectorAll('img[data-src]');

    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const img = entry.target as HTMLImageElement;
                    img.src = img.dataset.src || '';
                    img.removeAttribute('data-src');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach((img) => imageObserver.observe(img));
    } else {
        // Fallback for older browsers
        images.forEach((img) => {
            const image = img as HTMLImageElement;
            image.src = image.dataset.src || '';
            image.removeAttribute('data-src');
        });
    }
}
