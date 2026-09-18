import './bootstrap';
import * as isvek from 'bvi';


document.addEventListener('livewire:init', () => {
    console.log('✅ Livewire initialized with Alpine.js');
});


document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ App.js loaded');
    
    
    try {
        
        if (typeof isvek === 'undefined' || typeof isvek.Bvi === 'undefined') {
            console.error('❌ BVI library not properly loaded');
            return;
        }

        new isvek.Bvi({
            target: '.bvi-open',
            fontSize: 16,
            theme: 'white',
            images: 'grayscale',
            letterSpacing: 'normal',
            lineHeight: 'normal',
            speech: true,
            fontFamily: 'arial',
            builtElements: false,
            panelFixed: true,
            panelHide: false,
            reload: false,
            lang: document.documentElement.lang === 'ru' ? 'ru-RU' : 'en-US',
            
            path: '/bvi/'
        });
        console.log('✅ BVI successfully initialized');
    } catch (error) {
        console.error('❌ BVI initialization error:', error);
    }
    
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            
            
            if (!href || href === '#' || href.length <= 1) {
                e.preventDefault();
                return;
            }
            
            
            const targetId = href.includes('#') ? href.substring(href.indexOf('#') + 1) : null;
            
            if (targetId) {
                const target = document.getElementById(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    
                    const mobileMenu = document.getElementById('mobile-menu');
                    if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            }
        });
    });

    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    
    const animatedElements = document.querySelectorAll('.fade-in-on-scroll');
    animatedElements.forEach(el => observer.observe(el));

    
    const header = document.querySelector('header');
    if (header) {
        let lastScroll = 0;
        
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll <= 0) {
                header.classList.remove('scroll-up');
                return;
            }
            
            if (currentScroll > lastScroll && !header.classList.contains('scroll-down')) {
                header.classList.remove('scroll-up');
                header.classList.add('scroll-down');
            } else if (currentScroll < lastScroll && header.classList.contains('scroll-down')) {
                header.classList.remove('scroll-down');
                header.classList.add('scroll-up');
            }
            
            lastScroll = currentScroll;
        });
    }

    
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));
});


window.showSuccessNotification = function(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-24 right-4 bg-green-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-fade-in';
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('opacity-0', 'transition-opacity');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
};


window.showErrorNotification = function(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-24 right-4 bg-red-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-fade-in';
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('opacity-0', 'transition-opacity');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
};


window.showInfoNotification = function(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-24 right-4 bg-blue-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-fade-in';
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('opacity-0', 'transition-opacity');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
};

// ============================================
// MOBILE MENU - Complete Implementation
// ============================================

function initMobileMenuOnLoad() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');

    if (!mobileMenu) {
        console.error('Mobile menu element not found');
        return;
    }

    // Initialize dropdown handlers
    function initializeMobileDropdowns() {
        document.querySelectorAll('.mobile-dropdown > button').forEach(button => {
            button.removeEventListener('click', handleDropdownClick);
            button.addEventListener('click', handleDropdownClick);
        });
    }

    // Handle dropdown button clicks
    function handleDropdownClick(e) {
        e.stopPropagation();
        e.preventDefault();
        
        const dropdown = this.parentElement;
        const menu = dropdown.querySelector('.mobile-dropdown-menu');
        const arrow = this.querySelector('.dropdown-arrow');
        
        // Close other dropdowns
        document.querySelectorAll('.mobile-dropdown').forEach(otherDropdown => {
            if (otherDropdown !== dropdown) {
                const otherMenu = otherDropdown.querySelector('.mobile-dropdown-menu');
                const otherArrow = otherDropdown.querySelector('.dropdown-arrow');
                
                if (otherMenu) {
                    otherMenu.classList.remove('show');
                    otherMenu.classList.add('hidden');
                }
                
                if (otherArrow) {
                    otherArrow.classList.remove('rotate-180');
                }
                
                const otherButton = otherDropdown.querySelector('button');
                if (otherButton) {
                    otherButton.setAttribute('aria-expanded', 'false');
                }
            }
        });

        // Toggle current dropdown
        if (menu) {
            const isHidden = menu.classList.contains('hidden');
            
            if (isHidden) {
                menu.classList.remove('hidden');
                menu.classList.add('show');
            } else {
                menu.classList.remove('show');
                menu.classList.add('hidden');
            }
        }
        
        if (arrow) {
            arrow.classList.toggle('rotate-180');
        }
        
        const isExpanded = menu?.classList.contains('hidden') ? 'false' : 'true';
        this.setAttribute('aria-expanded', isExpanded);
    }

    // Setup dropdown link handlers
    function setupDropdownLinks() {
        document.querySelectorAll('.mobile-dropdown-menu a').forEach(link => {
            link.removeEventListener('click', handleDropdownLinkClick);
            link.addEventListener('click', handleDropdownLinkClick);
        });
    }

    // Handle dropdown link clicks
    function handleDropdownLinkClick(e) {
        const dropdownMenu = this.closest('.mobile-dropdown-menu');
        
        if (dropdownMenu) {
            dropdownMenu.classList.remove('show');
            dropdownMenu.classList.add('hidden');
            
            const dropdown = dropdownMenu.closest('.mobile-dropdown');
            const button = dropdown?.querySelector('button');
            const arrow = dropdown?.querySelector('.dropdown-arrow');
            
            if (button) {
                button.setAttribute('aria-expanded', 'false');
            }
            
            if (arrow) {
                arrow.classList.remove('rotate-180');
            }
        }
    }

    // Open menu button handler
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            mobileMenu.classList.remove('hidden');
            mobileMenu.classList.add('show');
            mobileMenu.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => {
                const sidebar = mobileMenu.querySelector('.bg-white');
                if (sidebar) {
                    sidebar.style.transform = 'translateY(0)';
                }
                initializeMobileDropdowns();
                setupDropdownLinks();
            }, 10);
        });
    }

    // Close menu button handler
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMobileMenu);
    }

    // Backdrop click handler
    if (mobileMenuBackdrop) {
        mobileMenuBackdrop.addEventListener('click', closeMobileMenu);
    }

    // Initial setup
    initializeMobileDropdowns();
    setupDropdownLinks();
}

// Close mobile menu function
window.closeMobileMenu = function() {
    const mobileMenu = document.getElementById('mobile-menu');
    if (!mobileMenu) return;
    
    const sidebar = mobileMenu.querySelector('.bg-white');
    if (sidebar) {
        sidebar.style.transform = 'translateY(-100%)';
    }
    
    setTimeout(() => {
        mobileMenu.classList.remove('show');
        mobileMenu.classList.add('hidden');
        mobileMenu.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }, 300);
};

// Initialize mobile menu when document is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMobileMenuOnLoad);
} else {
    initMobileMenuOnLoad();
}