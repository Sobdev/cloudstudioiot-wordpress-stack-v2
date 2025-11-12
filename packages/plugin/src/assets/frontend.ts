/**
 * CloudStudio Elementor Widgets - Frontend Scripts
 * 
 * Loaded on frontend pages.
 * Handles widget interactions and animations.
 */

import './styles/frontend.css';

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    console.log('CloudStudio Elementor Widgets v2.0.0 - Frontend loaded');

    // Initialize animations
    initAnimations();

    // Initialize logo carousel
    initLogoCarousel();

    // Initialize FAQ accordion
    initFAQ();

    // Initialize tabs
    initTabs();
});

/**
 * Initialize entrance animations
 */
function initAnimations(): void {
    const animatedElements = document.querySelectorAll('[data-cloudstudio-animation]');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const element = entry.target as HTMLElement;
                    const animation = element.dataset.cloudstudioAnimation;
                    const delay = element.dataset.cloudstudioDelay || '0';

                    setTimeout(() => {
                        element.classList.add(`cloudstudio-animate-${animation}`);
                    }, parseInt(delay));

                    observer.unobserve(element);
                }
            });
        }, { threshold: 0.1 });

        animatedElements.forEach((el) => observer.observe(el));
    } else {
        // Fallback for browsers without IntersectionObserver
        animatedElements.forEach((el) => {
            const element = el as HTMLElement;
            const animation = element.dataset.cloudstudioAnimation;
            element.classList.add(`cloudstudio-animate-${animation}`);
        });
    }
}

/**
 * Initialize logo carousel
 */
function initLogoCarousel(): void {
    const carousels = document.querySelectorAll('.cloudstudio-logo-carousel');

    carousels.forEach(async (carousel) => {
        // Lazy load Swiper only when needed
        const { default: Swiper } = await import('swiper');
        const { Autoplay, Pagination, Navigation } = await import('swiper/modules');

        new Swiper(carousel as HTMLElement, {
            modules: [Autoplay, Pagination, Navigation],
            slidesPerView: 2,
            spaceBetween: 30,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: { slidesPerView: 3 },
                1024: { slidesPerView: 5 },
            },
            loop: true,
        });
    });
}

/**
 * Initialize FAQ accordion
 */
function initFAQ(): void {
    const faqItems = document.querySelectorAll('.cloudstudio-faq-item');

    faqItems.forEach((item) => {
        const question = item.querySelector('.cloudstudio-faq-question');
        const answer = item.querySelector('.cloudstudio-faq-answer');

        question?.addEventListener('click', () => {
            const isOpen = item.classList.contains('is-open');

            // Close all other items
            faqItems.forEach((otherItem) => {
                if (otherItem !== item) {
                    otherItem.classList.remove('is-open');
                }
            });

            // Toggle current item
            item.classList.toggle('is-open', !isOpen);
        });
    });
}

/**
 * Initialize tabs
 */
function initTabs(): void {
    const tabContainers = document.querySelectorAll('.cloudstudio-tabs');

    tabContainers.forEach((container) => {
        const tabs = container.querySelectorAll('.cloudstudio-tab');
        const panels = container.querySelectorAll('.cloudstudio-tab-panel');

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                // Remove active class from all
                tabs.forEach((t) => t.classList.remove('is-active'));
                panels.forEach((p) => p.classList.remove('is-active'));

                // Add active class to current
                tab.classList.add('is-active');
                panels[index]?.classList.add('is-active');
            });
        });
    });
}
