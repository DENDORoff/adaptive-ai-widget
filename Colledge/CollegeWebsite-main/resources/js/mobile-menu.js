document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');

    // Initialize dropdown handlers
    function initializeMobileDropdowns() {
        document.querySelectorAll('.mobile-dropdown > button').forEach(button => {
            button.removeEventListener('click', handleDropdownClick);
            button.addEventListener('click', handleDropdownClick);
        });
    }

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
                otherDropdown.querySelector('button')?.setAttribute('aria-expanded', 'false');
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

    // Handle dropdown menu link clicks
    function setupDropdownLinks() {
        document.querySelectorAll('.mobile-dropdown-menu a').forEach(link => {
            link.removeEventListener('click', handleDropdownLinkClick);
            link.addEventListener('click', handleDropdownLinkClick);
        });
    }

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

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            if (!mobileMenu) return;
            mobileMenu.classList.remove('hidden');
            mobileMenu.classList.add('show');
            mobileMenu.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => {
                const sidebar = mobileMenu.querySelector('.bg-white');
                if (sidebar) {
                    sidebar.style.transform = 'translateY(0)';
                }
                // Initialize dropdowns after menu opens
                initializeMobileDropdowns();
                setupDropdownLinks();
            }, 10);
        });
    }

    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMobileMenu);
    }

    if (mobileMenuBackdrop) {
        mobileMenuBackdrop.addEventListener('click', closeMobileMenu);
    }

    // Initial setup
    initializeMobileDropdowns();
    setupDropdownLinks();
});

function closeMobileMenu() {
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
}
