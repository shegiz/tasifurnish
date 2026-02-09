/**
 * Main JavaScript
 * Portfolio filtering and mobile navigation
 */

(function() {
    'use strict';

    // Mobile navigation toggle
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            const isExpanded = navToggle.getAttribute('aria-expanded') === 'true';
            navToggle.setAttribute('aria-expanded', !isExpanded);
            navMenu.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!navToggle.contains(event.target) && !navMenu.contains(event.target)) {
                navToggle.setAttribute('aria-expanded', 'false');
                navMenu.classList.remove('active');
            }
        });

        // Close menu when clicking a link
        const navLinks = navMenu.querySelectorAll('a');
        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                navToggle.setAttribute('aria-expanded', 'false');
                navMenu.classList.remove('active');
            });
        });
    }

    // Portfolio filtering
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card');

    if (filterButtons.length > 0 && projectCards.length > 0) {
        filterButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');

                // Update active state
                filterButtons.forEach(function(btn) {
                    btn.classList.remove('active');
                });
                this.classList.add('active');

                // Filter projects
                projectCards.forEach(function(card) {
                    const cardCategory = card.getAttribute('data-category');
                    
                    if (category === 'all' || cardCategory === category) {
                        card.classList.remove('hidden');
                        // Smooth reveal animation
                        card.style.opacity = '0';
                        setTimeout(function() {
                            card.style.transition = 'opacity 0.3s ease';
                            card.style.opacity = '1';
                        }, 10);
                    } else {
                        card.classList.add('hidden');
                    }
                });
            });
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Form validation enhancement (client-side, server-side is primary)
    const contactForm = document.querySelector('form[action*="contact"]');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = contactForm.querySelectorAll('[required]');
            
            requiredFields.forEach(function(field) {
                const formGroup = field.closest('.form-group');
                if (!formGroup) return;
                
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error-input');
                    let errorMsg = formGroup.querySelector('.error');
                    if (!errorMsg) {
                        errorMsg = document.createElement('span');
                        errorMsg.className = 'error';
                        formGroup.appendChild(errorMsg);
                    }
                    errorMsg.textContent = 'Ez a mező kötelező.';
                } else {
                    field.classList.remove('error-input');
                    const errorMsg = formGroup.querySelector('.error');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });

            // Email validation
            const emailField = contactForm.querySelector('input[type="email"]');
            if (emailField && emailField.value) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailField.value)) {
                    isValid = false;
                    emailField.classList.add('error-input');
                    const formGroup = emailField.closest('.form-group');
                    if (formGroup) {
                        let errorMsg = formGroup.querySelector('.error');
                        if (!errorMsg) {
                            errorMsg = document.createElement('span');
                            errorMsg.className = 'error';
                            formGroup.appendChild(errorMsg);
                        }
                        errorMsg.textContent = 'Kérjük, adjon meg egy érvényes email címet.';
                    }
                }
            }

            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = contactForm.querySelector('.error-input');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });

        // Clear error on input
        const formFields = contactForm.querySelectorAll('input, select, textarea');
        formFields.forEach(function(field) {
            field.addEventListener('input', function() {
                this.classList.remove('error-input');
                const formGroup = this.closest('.form-group');
                if (formGroup) {
                    const errorMsg = formGroup.querySelector('.error');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });
        });
    }
})();
