let chatSessionId = null;
let chatOpen = false;
let messageCheckInterval = null;
let chatMessagesScrollTop = 0;
let wasAtBottom = true;
let isDesktopBurgerOpen = false;

let dropdownListenerAttached = false;

/**
 * Инициализировать все dropdown меню
 */
function initializeDropdowns() {
    // Добавить обработчик к кнопкам dropdown для onclick работы
    document.querySelectorAll('.nav-dropdown-click button').forEach(button => {
        // Только добавляем обработчик если его ещё нет
        if (!button.hasAttribute('data-dropdown-initialized')) {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleDropdown(button);
            });
            button.setAttribute('data-dropdown-initialized', 'true');
        }
    });
    
    // Закрыть dropdown при клике вне его
    if (!dropdownListenerAttached) {
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.nav-dropdown-click')) {
                closeAllDropdowns();
            }
        });
        dropdownListenerAttached = true;
    }
}

/**
 * Инициализировать мобильное меню
 */
function initializeMobileMenu() {
    console.log('Initializing mobile menu...');
    
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');

    console.log('Mobile Menu Elements:', {
        btn: !!mobileMenuBtn,
        menu: !!mobileMenu,
        close: !!mobileMenuClose,
        backdrop: !!mobileMenuBackdrop
    });

    if (!mobileMenuBtn || !mobileMenu || !mobileMenuClose || !mobileMenuBackdrop) {
        console.warn('Mobile menu elements not found');
        return;
    }

    // Открытие меню
    mobileMenuBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('✓ Mobile menu button clicked - opening menu');
        console.log('Mobile menu classes before:', mobileMenu.className);
        mobileMenu.classList.add('show');
        mobileMenu.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        console.log('Mobile menu classes after:', mobileMenu.className);
    });

    // Закрытие меню
    const closeMobileMenu = function() {
        console.log('Closing mobile menu');
        mobileMenu.classList.remove('show');
        mobileMenu.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = 'auto';
    };

    mobileMenuClose.addEventListener('click', closeMobileMenu);
    mobileMenuBackdrop.addEventListener('click', closeMobileMenu);

    // Dropdowns в мобильном меню
    document.querySelectorAll('#mobile-menu .mobile-dropdown > button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const dropdown = this.parentElement;
            const menu = dropdown.querySelector('.mobile-dropdown-menu');
            const arrow = this.querySelector('.dropdown-arrow');
            
            // Закрыть другие dropdowns
            document.querySelectorAll('#mobile-menu .mobile-dropdown').forEach(otherDropdown => {
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
                menu.classList.toggle('hidden');
                menu.classList.toggle('show');
            }
            if (arrow) {
                arrow.classList.toggle('rotate-180');
            }
            const isExpanded = menu?.classList.contains('hidden') ? 'false' : 'true';
            this.setAttribute('aria-expanded', isExpanded);
        });
    });

    console.log('Mobile menu initialized successfully');
}

document.addEventListener('DOMContentLoaded', () => {
    const viewportWidth = window.innerWidth;
    if (viewportWidth < 481) {
        chatOpen = false;
        const chatWindow = document.getElementById('chatWindow');
        chatWindow.classList.remove('show');
    }
    
    initChat();
    checkCookies();
    
    // Инициализируем dropdown меню
    initializeDropdowns();
    
    // Инициализируем мобильное меню
    initializeMobileMenu();
    
    const chatWindow = document.getElementById('chatWindow');
    chatWindow.addEventListener('click', (e) => {
        if (e.target === chatWindow && window.innerWidth < 481 && chatOpen) {
            closeChat();
        }
    });
    
    document.addEventListener('click', (e) => {
        const burgerMenu = document.getElementById('desktopBurgerMenu');
        const burgerBtn = document.querySelector('.burger-btn-desktop');
        
        if (burgerMenu && burgerBtn && !burgerMenu.contains(e.target) && !burgerBtn.contains(e.target)) {
            closeDesktopBurgerMenu();
        }
    });
});

function checkCookies() {
    if (!localStorage.getItem('cookiesAccepted')) {
        document.getElementById('cookieBanner').style.display = 'flex';
    }
}

function openIconLink() {
    window.open('https://chatgpt.com/', '_blank');
}

async function initChat() {
    const savedSessionId = localStorage.getItem('chat_session_id');
    
    const viewportWidth = window.innerWidth;
    if (viewportWidth < 769) {
        try {
            const response = await fetch('/api/chat/session', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    session_id: savedSessionId
                })
            });
            
            const data = await response.json();
            chatSessionId = data.session_id;
            localStorage.setItem('chat_session_id', chatSessionId);
        } catch (error) {
            console.error('Chat init error:', error);
        }
    } else {
        try {
            const response = await fetch('/api/chat/session', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    session_id: savedSessionId
                })
            });
            
            const data = await response.json();
            chatSessionId = data.session_id;
            localStorage.setItem('chat_session_id', chatSessionId);
            
            await loadMessages();
            
        } catch (error) {
            console.error('Chat init error:', error);
        }
    }
}

function openChatNearRobot(event) {
    const chatWindow = document.getElementById('chatWindow');
    const robotIcon = document.querySelector('.chat-assistant-container');
    
    const viewportWidth = window.innerWidth;
    
    if (viewportWidth < 481) {
        if (!chatOpen) {
            chatOpen = true;
            chatWindow.classList.add('show');
        } else {
            chatOpen = false;
            chatWindow.classList.remove('show');
            if (messageCheckInterval) {
                clearInterval(messageCheckInterval);
                messageCheckInterval = null;
            }
            return;
        }
    } else {
        chatOpen = true;
        chatWindow.classList.add('show');
    }
    
    if (viewportWidth < 481) {
        chatWindow.style.position = 'fixed';
        chatWindow.style.left = '0';
        chatWindow.style.right = '0';
        chatWindow.style.bottom = '0';
        chatWindow.style.top = '0';
        chatWindow.style.width = '100%';
        chatWindow.style.height = '100%';
    } else if (viewportWidth < 769) {
        chatWindow.style.position = 'fixed';
        chatWindow.style.left = '50%';
        chatWindow.style.top = '50%';
        chatWindow.style.transform = 'translate(-50%, -50%)';
        chatWindow.style.width = '90%';
        chatWindow.style.height = '70vh';
    } else {
        const chatWidth = 380;
        const minLeftMargin = 10;
        const maxLeftPosition = Math.max(minLeftMargin, viewportWidth - chatWidth - 20);
        const leftPosition = Math.min(170, maxLeftPosition);
        
        chatWindow.style.position = 'fixed';
        chatWindow.style.left = leftPosition + 'px';
        chatWindow.style.right = 'auto';
        chatWindow.style.bottom = '100px';
        chatWindow.style.top = 'auto';
        chatWindow.style.transform = 'none';
        chatWindow.style.width = '380px';
        chatWindow.style.height = '600px';
    }
    
    if (chatOpen) {
        document.getElementById('chatInput').focus();
        loadMessages();
        messageCheckInterval = setInterval(loadMessages, 5000);
    }
}

function closeChat() {
    const chatWindow = document.getElementById('chatWindow');
    chatOpen = false;
    chatWindow.classList.remove('show');
    
    if (messageCheckInterval) {
        clearInterval(messageCheckInterval);
        messageCheckInterval = null;
    }
}

async function loadMessages() {
    if (!chatSessionId) return;
    
    const chatMessages = document.getElementById('chatMessages');
    const oldScrollTop = chatMessages.scrollTop;
    const oldScrollHeight = chatMessages.scrollHeight;
    
    try {
        const response = await fetch('/api/chat/messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                session_id: chatSessionId
            })
        });
        
        const data = await response.json();
        const shouldScrollToBottom = displayMessages(data.messages);
        
        if (!shouldScrollToBottom) {
            chatMessages.scrollTop = oldScrollTop + (chatMessages.scrollHeight - oldScrollHeight);
        }
        
    } catch (error) {
        console.error('Load messages error:', error);
    }
}

function displayMessages(messages) {
    const chatMessages = document.getElementById('chatMessages');
    const welcome = chatMessages.querySelector('.chat-welcome');
    
    const oldMessages = chatMessages.querySelectorAll('.chat-message');
    oldMessages.forEach(msg => msg.remove());
    
    messages.forEach(message => {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${message.is_admin ? 'admin' : 'user'}`;
        
        messageDiv.innerHTML = `
            <div class="message-bubble">
                <div>${message.message.replace(/\n/g, '<br>')}</div>
                <div class="message-time">${message.created_at}</div>
            </div>
        `;
        
        chatMessages.appendChild(messageDiv);
    });
    
    const isNearBottom = chatMessages.scrollHeight - chatMessages.clientHeight - chatMessages.scrollTop < 100;
    
    if (isNearBottom) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return true;
    }
    
    return false;
}

async function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    
    if (!message || !chatSessionId) return;
    
    try {
        const response = await fetch('/api/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                session_id: chatSessionId,
                message: message
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            input.value = '';
            loadMessages();
        }
        
    } catch (error) {
        console.error('Send message error:', error);
        alert('Ошибка отправки сообщения. Попробуйте позже.');
    }
}

function openSituationCenterModal() {
    const modal = document.getElementById('situationCenterModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    closeAllDropdowns();
    closeMobileMenu();
    closeDesktopBurgerMenu();
}

function closeSituationCenterModal() {
    const modal = document.getElementById('situationCenterModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

function acceptCookies() {
    document.getElementById('cookieBanner').style.display = 'none';
    localStorage.setItem('cookiesAccepted', 'true');
    sessionStorage.setItem('cookiesAccepted', 'true');
}

function toggleDesktopBurgerMenu() {
    const menu = document.getElementById('desktopBurgerMenu');
    if (!menu) return;
    
    if (isDesktopBurgerOpen) {
        closeDesktopBurgerMenu();
    } else {
        openDesktopBurgerMenu();
    }
}

function openDesktopBurgerMenu() {
    const menu = document.getElementById('desktopBurgerMenu');
    if (!menu) return;
    
    menu.classList.add('show');
    isDesktopBurgerOpen = true;
    
    closeAllDropdowns();
}

function closeDesktopBurgerMenu() {
    const menu = document.getElementById('desktopBurgerMenu');
    if (!menu) return;
    
    menu.classList.remove('show');
    isDesktopBurgerOpen = false;
}

if ('serviceWorker' in navigator) {
    window.addEventListener('load', async () => {
        try {
            const registration = await navigator.serviceWorker.register('/service-worker.js', {
                scope: '/'
            });

            if (registration.waiting) {
                registration.waiting.postMessage({ type: 'SKIP_WAITING' });
            }

            registration.addEventListener('updatefound', () => {
                const newWorker = registration.installing;
                newWorker.addEventListener('statechange', () => {
                    if (newWorker.state === 'installed') {
                        newWorker.postMessage({ type: 'SKIP_WAITING' });
                    }
                });
            });
        } catch (error) {
            console.error('ServiceWorker registration failed:', error);
        }
    });
} else {
    console.log('ServiceWorker not supported');
}

function updateOnlineStatus() {
    const isOnline = navigator.onLine;
    
    if (!isOnline) {
        showOfflineNotification();
    } else {
        hideOfflineNotification();
    }
}

function showOfflineNotification() {
    let notification = document.getElementById('offline-notification');
    
    if (!notification) {
        notification = document.createElement('div');
        notification.id = 'offline-notification';
        notification.innerHTML = `
            <div style="position: fixed; top: 20px; right: 20px; z-index: 99999; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; padding: 16px 24px; border-radius: 12px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); display: flex; align-items: center; gap: 12px; animation: slideInRight 0.3s ease-out;">
                <svg style="width: 24px; height: 24px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span style="font-weight: 600;">Нет подключения к интернету</span>
            </div>
        `;
        document.body.appendChild(notification);
    }
}

function hideOfflineNotification() {
    const notification = document.getElementById('offline-notification');
    if (notification) {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }
}

window.addEventListener('online', updateOnlineStatus);
window.addEventListener('offline', updateOnlineStatus);
window.addEventListener('load', updateOnlineStatus);

let searchTimeout = null;
let isSearchVisible = false;

function toggleSearch() {
    const searchForm = document.getElementById('searchForm');
    const searchResults = document.getElementById('searchResults');
    
    if (isSearchVisible) {
        searchForm.classList.remove('show');
        searchResults.classList.add('hidden');
        isSearchVisible = false;
    } else {
        searchForm.classList.add('show');
        searchForm.querySelector('.search-input').focus();
        isSearchVisible = true;
        
        document.addEventListener('click', closeSearchOnClickOutside);
    }
}

function closeSearchOnClickOutside(event) {
    const searchForm = document.getElementById('searchForm');
    const searchButton = document.querySelector('.search-button');
    
    if (!searchForm.contains(event.target) && !searchButton.contains(event.target)) {
        searchForm.classList.remove('show');
        document.getElementById('searchResults').classList.add('hidden');
        isSearchVisible = false;
        document.removeEventListener('click', closeSearchOnClickOutside);
    }
}

function handleSearchInput(query) {
    clearTimeout(searchTimeout);
    
    if (query.length < 2) {
        document.getElementById('searchResults').classList.add('hidden');
        return;
    }
    
    searchTimeout = setTimeout(() => {
        performSearch(query);
    }, 300);
}

function handleMobileSearchInput(query) {
    clearTimeout(searchTimeout);
    
    if (query.length < 2) {
        const resultsContainer = document.getElementById('mobileSearchResults');
        if (resultsContainer) {
            resultsContainer.classList.add('hidden');
        }
        return;
    }
    
    searchTimeout = setTimeout(() => {
        performSearch(query, 'mobileSearchResults');
    }, 300);
}

async function performSearch(query, resultsContainerId = 'searchResults') {
    try {
        const response = await fetch(`/api/search?q=${encodeURIComponent(query)}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const results = await response.json();
        const resultsContainer = document.getElementById(resultsContainerId);
        
        if (!resultsContainer) {
            console.error('Results container not found:', resultsContainerId);
            return;
        }
        
        if (!results || results.length === 0) {
            resultsContainer.innerHTML = '<div class="no-results">По вашему запросу ничего не найдено</div>';
            resultsContainer.classList.remove('hidden');
            return;
        }
        
        let html = '';
        results.forEach(result => {
            let badgeColor = 'bg-gray-100 text-gray-800';
            let badgeText = 'Результат';
            
            if (result.type === 'news') {
                badgeColor = 'bg-blue-100 text-blue-800';
                badgeText = '';
            } else if (result.type === 'blog') {
                badgeColor = 'bg-purple-100 text-purple-800';
                badgeText = '';
            } else if (result.type === 'staff') {
                badgeColor = 'bg-green-100 text-green-800';
                badgeText = '';
            } else if (result.type === 'vacancy') {
                badgeColor = 'bg-orange-100 text-orange-800';
                badgeText = '';
            } else if (result.type === 'page') {
                badgeColor = 'bg-indigo-100 text-indigo-800';
                badgeText = '';
            }
            
            if (result.type === 'staff' && result.onclick) {
                html += `
                    <a href="${result.url}" onclick="${result.onclick}; return false;" class="block hover:bg-gray-50 transition">
                        <div class="search-result-title">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ${badgeColor}">
                                ${badgeText}
                            </span>
                            <span>${result.title}</span>
                        </div>
                        ${result.excerpt ? `<div class="search-result-excerpt">${result.excerpt}</div>` : ''}
                        ${result.date ? `<div class="text-xs text-gray-500 mt-1">${result.date}</div>` : ''}
                    </a>
                `;
            } else {
                html += `
                    <a href="${result.url}" class="block hover:bg-gray-50 transition">
                        <div class="search-result-title">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ${badgeColor}">
                                ${badgeText}
                            </span>
                            <span>${result.title}</span>
                        </div>
                        ${result.excerpt ? `<div class="search-result-excerpt">${result.excerpt}</div>` : ''}
                        ${result.date ? `<div class="text-xs text-gray-500 mt-1">${result.date}</div>` : ''}
                    </a>
                `;
            }
        });
        
        html += `
            <a href="/search?q=${encodeURIComponent(query)}" class="block border-t border-gray-200 pt-3 mt-2 text-center text-blue-600 hover:text-blue-700 font-medium text-sm">
                 →
            </a>
        `;
        
        resultsContainer.innerHTML = html;
        resultsContainer.classList.remove('hidden');
        
        if (resultsContainerId === 'mobileSearchResults') {
            const rect = resultsContainer.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            if (rect.bottom > viewportHeight - 100) {
                resultsContainer.style.maxHeight = '200px';
                resultsContainer.style.overflowY = 'auto';
            }
        }
    } catch (error) {
        console.error('Search error:', error);
        const resultsContainer = document.getElementById(resultsContainerId);
        if (resultsContainer) {
            resultsContainer.innerHTML = `
                <div class="no-results">
                    <br>
                    <small class="text-xs text-gray-500">${error.message}</small>
                </div>
            `;
            resultsContainer.classList.remove('hidden');
        }
    }
}

function openStaffModal(staffId) {
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.classList.remove('show');
    }
    
    fetch(`/api/staff/${staffId}`)
        .then(response => response.json())
        .then(data => {
            const modal = document.getElementById('staffSearchModal');
            const content = document.getElementById('staffModalContent');
            const title = document.getElementById('staffModalTitle');
            
            title.textContent = data.full_name;
            
            let html = '';
            
            if (data.photo) {
                html += `<img src="${data.photo}" alt="${data.full_name}" class="staff-photo">`;
            }
            
            html += '<div class="space-y-3">';
            
            if (data.position) {
                html += `
                    <div class="staff-info-item">
                        <div class="staff-info-label"></div>
                        <div class="staff-info-value">${data.position}</div>
                    </div>
                `;
            }
            
            if (data.department) {
                html += `
                    <div class="staff-info-item">
                        <div class="staff-info-label"></div>
                        <div class="staff-info-value">${data.department}</div>
                    </div>
                `;
            }
            
            if (data.email) {
                html += `
                    <div class="staff-info-item">
                        <div class="staff-info-label"></div>
                        <div class="staff-info-value">
                            <a href="mailto:${data.email}" class="text-blue-600 hover:text-blue-700">${data.email}</a>
                        </div>
                    </div>
                `;
            }
            
            if (data.phone) {
                html += `
                    <div class="staff-info-item">
                        <div class="staff-info-label"></div>
                        <div class="staff-info-value">
                            <a href="tel:${data.phone}" class="text-blue-600 hover:text-blue-700">${data.phone}</a>
                        </div>
                    </div>
                `;
            }
            
            if (data.bio) {
                html += `
                    <div class="staff-info-item">
                        <div class="staff-info-label"></div>
                        <div class="staff-info-value">${data.bio}</div>
                    </div>
                `;
            }
            
            html += '</div>';
            
            content.innerHTML = html;
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        })
        .catch(error => {
            console.error('Error loading staff data:', error);
            alert('Ошибка загрузки данных сотрудника');
        });
}

function closeStaffSearchModal() {
    const modal = document.getElementById('staffSearchModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeStaffSearchModal();
        closeDesktopBurgerMenu();
        closeBugReportModal();
    }
});

document.getElementById('staffSearchModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeStaffSearchModal();
    }
});

function openBugReportModal() {
    const modal = document.getElementById('bugReportModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    closeAllDropdowns();
    closeMobileMenu();
    closeDesktopBurgerMenu();
    
    detectUserAgentInfo();
    
    const stepsContainer = document.getElementById('bugStepsContainer');
    if (stepsContainer) {
        stepsContainer.innerHTML = '';
    }
    
    const successMessage = document.getElementById('bugReportSuccessMessage');
    const errorMessages = document.getElementById('bugReportErrorMessages');
    if (successMessage) successMessage.classList.add('hidden');
    if (errorMessages) errorMessages.classList.add('hidden');
}

function closeBugReportModal() {
    const modal = document.getElementById('bugReportModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

function addBugStep() {
    const container = document.getElementById('bugStepsContainer');
    if (!container) return;
    
    const stepNumber = container.children.length + 1;
    const stepDiv = document.createElement('div');
    stepDiv.className = 'flex items-center gap-2';
    stepDiv.innerHTML = `
        <span class="text-sm font-medium text-gray-600 w-8">${stepNumber}.</span>
        <input type="text" 
               name="steps_to_reproduce[]" 
               class="flex-1 px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-900 text-sm"
               placeholder="">
        <button type="button" 
                onclick="this.parentElement.remove(); updateBugStepNumbers()" 
                class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
    container.appendChild(stepDiv);
}

function updateBugStepNumbers() {
    const container = document.getElementById('bugStepsContainer');
    if (!container) return;
    
    const steps = container.children;
    for (let i = 0; i < steps.length; i++) {
        const stepNumber = i + 1;
        const numberSpan = steps[i].querySelector('span');
        if (numberSpan) {
            numberSpan.textContent = `${stepNumber}.`;
        }
    }
}

function detectUserAgentInfo() {
    const userAgent = navigator.userAgent;
    const browser = getBrowser(userAgent);
    const os = getOperatingSystem(userAgent);
    const device = getDeviceType(userAgent);
    
    document.getElementById('bug_browser_info').textContent = browser;
    document.getElementById('bug_os_info').textContent = os;
    document.getElementById('bug_device_info').textContent = device === 'mobile' ? '' : 
                                                            device === 'tablet' ? '' : '';
}

function getBrowser(userAgent) {
    if (userAgent.includes('Chrome')) return 'Chrome';
    if (userAgent.includes('Firefox')) return 'Firefox';
    if (userAgent.includes('Safari')) return 'Safari';
    if (userAgent.includes('Edge')) return 'Edge';
    if (userAgent.includes('Opera')) return 'Opera';
    return '';
}

function getOperatingSystem(userAgent) {
    if (userAgent.includes('Windows')) return 'Windows';
    if (userAgent.includes('Mac OS')) return 'macOS';
    if (userAgent.includes('Linux')) return 'Linux';
    if (userAgent.includes('Android')) return 'Android';
    if (userAgent.includes('iOS')) return 'iOS';
    return '';
}

function getDeviceType(userAgent) {
    if (/Mobile/.test(userAgent)) return 'mobile';
    if (/Tablet/.test(userAgent)) return 'tablet';
    return 'desktop';
}

document.getElementById('bugReportForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Проверка honeypot и предотвращение двойной отправки
    if (!validateFormBeforeSubmit(e, 'bugReportForm')) {
        return;
    }
    
    const submitButton = document.getElementById('bugReportSubmitButton');
    const successMessage = document.getElementById('bugReportSuccessMessage');
    const errorMessages = document.getElementById('bugReportErrorMessages');
    const errorList = document.getElementById('bugReportErrorList');
    const originalButtonHTML = submitButton.innerHTML;
    
    successMessage.classList.add('hidden');
    errorMessages.classList.add('hidden');

    submitButton.disabled = true;
    submitButton.innerHTML = `
        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 .16 5.333.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.333 11.893-11.893 0-3.18-1.24-6.162-3.495-8.411"/>
        </svg>
        
    `;
    
    try {
        const formData = new FormData(this);
        
        // Получить реальную информацию браузера
        const browserInfo = getBrowserInfo();
        formData.set('browser', browserInfo.browser);
        formData.set('os', browserInfo.os);
        
        // Определить тип устройства
        let deviceType = 'desktop';
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(browserInfo.userAgent)) {
            deviceType = /iPad/.test(browserInfo.userAgent) ? 'tablet' : 'mobile';
        }
        formData.set('device', deviceType);
        
        const response = await fetch('{{ route("bug-report.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            successMessage.classList.remove('hidden');
            this.reset();
            
            const stepsContainer = document.getElementById('bugStepsContainer');
            if (stepsContainer) {
                stepsContainer.innerHTML = '';
            }
            
            // На мобильных скроллим к успеху
            if (window.innerWidth < 768) {
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            setTimeout(() => {
                closeBugReportModal();
                unlockForm('bugReportForm');
            }, 3000);
        } else {
            displayFormErrors(errorMessages, errorList, data.errors || data.message || 'Произошла ошибка при отправке отчета');
            unlockForm('bugReportForm');
        }
    } catch (error) {
        console.error('Error:', error);
        displayFormErrors(errorMessages, errorList, 'Произошла ошибка сети. Попробуйте позже.');
        unlockForm('bugReportForm');
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonHTML;
    }
});

document.getElementById('bugReportModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeBugReportModal();
    }
});

function openConsultationModal() {
    const modal = document.getElementById('consultationModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    closeAllDropdowns();
    closeMobileMenu();
    closeDesktopBurgerMenu();
    
    const form = document.getElementById('consultationForm');
    const successMessage = document.getElementById('consultationSuccessMessage');
    const errorMessages = document.getElementById('consultationErrorMessages');
    
    if (form && successMessage && errorMessages) {
        successMessage.classList.add('hidden');
        errorMessages.classList.add('hidden');
    }
}

function closeConsultationModal() {
    const modal = document.getElementById('consultationModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

function openPdfModal(pdfUrl, title) {
    const modal = document.getElementById('pdfModal');
    if (!modal) return;
    
    const iframe = modal.querySelector('#pdfIframe');
    if (iframe) {
        iframe.src = pdfUrl;
    }
    
    const titleEl = modal.querySelector('#pdfModalTitle');
    if (titleEl) {
        titleEl.textContent = title || 'Документ';
    }
    
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    closeAllDropdowns();
    closeMobileMenu();
    closeDesktopBurgerMenu();
}

function closePdfModal() {
    const modal = document.getElementById('pdfModal');
    const iframe = document.getElementById('pdfIframe');
    
    modal.classList.remove('show');
    iframe.src = '';
    document.body.style.overflow = '';
}

function openReceptionModal() {
    const modal = document.getElementById('receptionModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    closeAllDropdowns();
    closeMobileMenu();
    closeDesktopBurgerMenu();
}

function closeReceptionModal() {
    const modal = document.getElementById('receptionModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

function handleReceptionImageError(img) {
    img.style.display = 'none';
    const container = img.parentElement;
    const fallback = document.createElement('div');
    fallback.className = 'contacts-content';
    fallback.innerHTML = `
        <div class="contacts-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <h2 class="contacts-title"></h2>
        
        <div class="contacts-info">
            <div class="contact-item">
                <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                <div class="contact-text">
                    <div class="contact-label"></div>
                    <div class="contact-value"></div>
                </div>
            </div>
            
            <div class="contact-item">
                <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <div class="contact-text">
                    <div class="contact-label"></div>
                    <div class="contact-value">
                        <a href="tel:" class="contact-link"></a><br>
                        <a href="tel:" class="contact-link"></a>
                    </div>
                </div>
            </div>
            
            <div class="contact-item">
                <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <div class="contact-text">
                    <div class="contact-label"></div>
                    <div class="contact-value">
                        <a href="mailto:" class="contact-link"></a>
                    </div>
                </div>
            </div>
            
            <div class="contact-item">
                <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="contact-text">
                    <div class="contact-label"></div>
                    <div class="contact-value"></div>
                </div>
            </div>
        </div>
    `;
    container.appendChild(fallback);
}

function openCallCenterModal() {
    const modal = document.getElementById('callCenterModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    closeAllDropdowns();
    closeMobileMenu();
    closeDesktopBurgerMenu();
}

function closeCallCenterModal() {
    const modal = document.getElementById('callCenterModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

function openSupportModal() {
    const modal = document.getElementById('supportModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    closeAllDropdowns();
    closeMobileMenu();
    closeDesktopBurgerMenu();
}

function closeSupportModal() {
    const modal = document.getElementById('supportModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

function openContactsModal() {
    const modal = document.getElementById('contactsModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    closeAllDropdowns();
    closeMobileMenu();
    closeDesktopBurgerMenu();
}

function closeContactsModal() {
    const modal = document.getElementById('contactsModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

document.getElementById('consultationForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Проверка honeypot и предотвращение двойной отправки
    if (!validateFormBeforeSubmit(e, 'consultationForm')) {
        return;
    }
    
    const submitBtn = this.querySelector('.submit-btn');
    const successMessage = document.getElementById('consultationSuccessMessage');
    const errorMessages = document.getElementById('consultationErrorMessages');
    const errorList = document.getElementById('consultationErrorList');
    
    successMessage.classList.add('hidden');
    errorMessages.classList.add('hidden');

    submitBtn.disabled = true;
    const originalButtonText = submitBtn.innerHTML;
    submitBtn.innerHTML = '';
    
    try {
        const formData = new FormData(this);
        
        const response = await fetch('/consultation/request', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            successMessage.classList.remove('hidden');
            this.reset();
            
            // На мобильных устройствах скроллим к успеху
            if (window.innerWidth < 768) {
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            setTimeout(() => {
                closeConsultationModal();
                unlockForm('consultationForm');
            }, 3000);
        } else {
            displayFormErrors(errorMessages, errorList, data.errors || data.message || 'Произошла ошибка при отправке заявки');
            unlockForm('consultationForm');
        }
    } catch (error) {
        console.error('Error:', error);
        displayFormErrors(errorMessages, errorList, 'Произошла ошибка сети. Попробуйте позже.');
        unlockForm('consultationForm');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalButtonText;
    }
});

function updateMobileWeatherWidget() {
    const desktopWeather = document.querySelector('.compact-weather');
    const desktopError = document.querySelector('.weather-error');
    
    const mobileWidget = document.getElementById('mobile-weather-widget');
    const mobileError = document.getElementById('mobile-weather-error');
    const mobileIcon = document.getElementById('mobile-weather-icon');
    const mobileTemp = document.getElementById('mobile-weather-temp');
    const mobileDesc = document.getElementById('mobile-weather-desc');
    
    // Guard against missing elements
    if (!mobileWidget || !mobileIcon || !mobileTemp || !mobileDesc || !mobileError) {
        console.warn('Mobile weather widget elements not found');
        return;
    }
    
    if (desktopWeather) {
        const icon = desktopWeather.querySelector('img');
        const tempElement = desktopWeather.querySelector('a[href^="https://openweathermap.org"]');
        const tempText = desktopWeather.textContent;
        
        if (icon || tempElement || tempText) {
            let temperature = '';
            if (tempElement) {
                temperature = tempElement.textContent.trim();
            } else {
                const tempMatch = tempText.match(/(\d+)°/);
                if (tempMatch) {
                    temperature = tempMatch[1] + '°';
                }
            }
            
            if (icon) {
                mobileIcon.src = icon.src;
            } else {
                mobileIcon.src = 'https://openweathermap.org/img/wn/02d.png';
            }
            
            if (temperature) {
                mobileTemp.textContent = temperature;
                
                if (tempElement && tempElement.href) {
                    mobileWidget.href = tempElement.href;
                } else {
                    mobileWidget.href = 'https://openweathermap.org/city/1520240';
                }
                mobileWidget.target = '_blank';
                
                mobileWidget.classList.remove('hidden');
                mobileError.classList.add('hidden');
                return;
            }
        }
    }
    
    if (desktopError) {
        mobileWidget.classList.add('hidden');
        mobileError.classList.remove('hidden');
    } else {
        mobileWidget.classList.add('hidden');
        mobileError.classList.remove('hidden');
    }
}

function closeAllDropdowns() {
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.classList.remove('show');
        menu.classList.add('opacity-0', 'invisible');
    });
    
    document.querySelectorAll('.dropdown-icon').forEach(icon => {
        icon.classList.remove('rotate-180');
    });
    
    document.querySelectorAll('.nav-dropdown-click button').forEach(button => {
        button.setAttribute('aria-expanded', 'false');
    });
}

/**
 * Переключить dropdown меню при клике на кнопку
 * @param {HTMLElement} button - кнопка dropdown'а
 */
function toggleDropdown(button) {
    if (!button) return;
    
    const dropdown = button.closest('.nav-dropdown-click');
    if (!dropdown) return;
    
    const menu = dropdown.querySelector('.dropdown-menu');
    if (!menu) return;
    
    // Проверить, открыто ли ЭТО меню ПЕРЕД закрытием других
    const isOpen = menu.classList.contains('show');
    
    // Закрыть все dropdown'ы
    closeAllDropdowns();
    
    // Если это меню было открыто, то просто закрыли (toggle off)
    // Если это меню было закрыто, то откроем его (toggle on)
    if (!isOpen) {
        // Открыть текущий dropdown
        menu.classList.add('show');
        button.setAttribute('aria-expanded', 'true');
        
        const icon = button.querySelector('.dropdown-icon');
        if (icon) {
            icon.classList.add('rotate-180');
        }
    }
}


function applyMobileHeaderFix() {
    if (window.innerWidth < 1024) {
        const header = document.querySelector('header');
        const contentWrapper = document.querySelector('.content-wrapper');
        
        if (header && contentWrapper) {
            header.style.position = 'fixed';
            header.style.top = '0';
            header.style.left = '0';
            header.style.right = '0';
            header.style.zIndex = '40';
            
            contentWrapper.style.marginTop = '90px';
            contentWrapper.style.paddingTop = '0';
        }
        
        document.body.style.paddingTop = '0';
        document.body.style.marginTop = '0';
        
        const main = document.querySelector('main');
        if (main) {
            main.style.paddingTop = '0';
            main.style.marginTop = '0';
        }
    } else {
        const header = document.querySelector('header');
        const contentWrapper = document.querySelector('.content-wrapper');
        
        if (header) {
            header.style.position = '';
            header.style.top = '';
            header.style.left = '';
            header.style.right = '';
        }
        
        if (contentWrapper) {
            contentWrapper.style.marginTop = '';
            contentWrapper.style.paddingTop = '';
        }
    }
}

function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    if (!mobileMenu) return;
    
    mobileMenu.style.display = 'none';
    mobileMenu.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = 'auto';
}



function displayFileName(input) {
    const fileNameDiv = document.getElementById('fileName');
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
        fileNameDiv.innerHTML = `
            <div class="flex items-center gap-2 text-gray-700">
                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>${fileName} (${fileSize} MB)</span>
            </div>
        `;
    } else {
        fileNameDiv.innerHTML = '';
    }
}

function toggleScrollArrow() {
    const scrollArrow = document.getElementById('scrollArrow');
    const middleOfPage = document.documentElement.scrollHeight / 2;
    const currentScroll = window.scrollY + window.innerHeight;
    
    if (scrollArrow) {
        if (currentScroll > middleOfPage) {
            scrollArrow.classList.remove('bottom');
            scrollArrow.classList.add('top');
            scrollArrow.innerHTML = `
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
            `;
            scrollArrow.onclick = scrollToTop;
        } 
        else {
            scrollArrow.classList.remove('top');
            scrollArrow.classList.add('bottom');
            scrollArrow.innerHTML = `
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            `;
            scrollArrow.onclick = scrollToBottom;
        }
        
        if (window.scrollY > 100) {
            scrollArrow.classList.add('show');
        } else {
            scrollArrow.classList.remove('show');
        }
    }
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

function scrollToBottom() {
    window.scrollTo({
        top: document.documentElement.scrollHeight,
        behavior: 'smooth'
    });
}

function openWeatherLink() {
    const desktopWeather = document.querySelector('.compact-weather');
    if (desktopWeather) {
        const tempLink = desktopWeather.querySelector('a[href^="https://openweathermap.org"]');
        if (tempLink && tempLink.href) {
            window.open(tempLink.href, '_blank');
        } else {
            window.open('https://openweathermap.org/city/1520240', '_blank');
        }
    }
}

document.getElementById('appealForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Проверка honeypot и предотвращение двойной отправки
    if (!validateFormBeforeSubmit(e, 'appealForm')) {
        return;
    }
    
    const submitButton = document.getElementById('submitButton');
    const successMessage = document.getElementById('appealSuccessMessage');
    const errorMessages = document.getElementById('appealErrorMessages');
    const errorList = document.getElementById('appealErrorList');
    const originalButtonHTML = submitButton.innerHTML;
    
    successMessage.classList.add('hidden');
    errorMessages.classList.add('hidden');

    submitButton.disabled = true;
    submitButton.innerHTML = `
        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 .16 5.333.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.333 11.893-11.893 0-3.18-1.24-6.162-3.495-8.411"/>
        </svg>
        
    `;
    
    try {
        const formData = new FormData(this);
        
        const response = await fetch('/appeals', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            successMessage.classList.remove('hidden');
            this.reset();
            document.getElementById('fileName').innerHTML = '';
            
            // На мобильных скроллим к успеху
            if (window.innerWidth < 768) {
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            setTimeout(() => {
                closeSupportModal();
                unlockForm('appealForm');
            }, 3000);
        } else {
            displayFormErrors(errorMessages, errorList, data.errors || data.message || 'Произошла ошибка при отправке обращения');
            unlockForm('appealForm');
        }
    } catch (error) {
        console.error('Error:', error);
        displayFormErrors(errorMessages, errorList, 'Произошла ошибка сети. Попробуйте позже.');
        unlockForm('appealForm');
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonHTML;
    }
});

document.addEventListener('DOMContentLoaded', function() {
    applyMobileHeaderFix();
    
    window.addEventListener('resize', applyMobileHeaderFix);
    window.addEventListener('load', applyMobileHeaderFix);

    toggleScrollArrow();
    window.addEventListener('scroll', toggleScrollArrow);

    const navDropdowns = document.querySelectorAll('.nav-dropdown-click');

    navDropdowns.forEach(dropdown => {
        const button = dropdown.querySelector('button');
        const menu = dropdown.querySelector('.dropdown-menu');
        const icon = dropdown.querySelector('.dropdown-icon');
        
        if (button) {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                
                if (menu) {
                    const isOpen = menu.classList.contains('show');
                    
                    navDropdowns.forEach(otherDropdown => {
                        const otherMenu = otherDropdown.querySelector('.dropdown-menu');
                        const otherIcon = otherDropdown.querySelector('.dropdown-icon');
                        if (otherMenu) {
                            otherMenu.classList.remove('show');
                            otherMenu.classList.add('opacity-0', 'invisible');
                        }
                        if (otherIcon) {
                            otherIcon.classList.remove('rotate-180');
                        }
                        otherDropdown.querySelector('button')?.setAttribute('aria-expanded', 'false');
                    });
                    
                    if (!isOpen) {
                        menu.classList.remove('opacity-0', 'invisible');
                        menu.classList.add('show');
                        if (icon) icon.classList.add('rotate-180');
                        this.setAttribute('aria-expanded', 'true');
                    }
                }
            });
        }
    });

    document.querySelectorAll('.dropdown-menu button').forEach(button => {
        button.addEventListener('click', function(e) {
            navDropdowns.forEach(dropdown => {
                const menu = dropdown.querySelector('.dropdown-menu');
                const icon = dropdown.querySelector('.dropdown-icon');
                const button = dropdown.querySelector('button');
                
                if (menu) {
                    menu.classList.remove('show');
                    menu.classList.add('opacity-0', 'invisible');
                }
                if (icon) {
                    icon.classList.remove('rotate-180');
                }
                if (button) {
                    button.setAttribute('aria-expanded', 'false');
                }
            });
        });
    });

    document.querySelectorAll('.mobile-dropdown-menu button').forEach(button => {
        button.addEventListener('click', function(e) {
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
        });
    });

    document.querySelectorAll('.rules-link').forEach(link => {
        link.addEventListener('click', function(e) {
            if (!this.getAttribute('href')) {
                e.preventDefault();
            }
            closeAllDropdowns();
            closeMobileMenu();
            closeDesktopBurgerMenu();
        });
    });

    const desktopWeather = document.querySelector('.compact-weather');
    if (desktopWeather) {
        desktopWeather.addEventListener('click', function(e) {
            e.preventDefault();
            openWeatherLink();
        });
    }

    const mobileWeatherWidget = document.getElementById('mobile-weather-widget');
    if (mobileWeatherWidget) {
        mobileWeatherWidget.addEventListener('click', function(e) {
            e.preventDefault();
            openWeatherLink();
        });
    }

    document.addEventListener('click', function(e) {
        let isClickInsideNav = false;
        
        navDropdowns.forEach(dropdown => {
            if (dropdown.contains(e.target)) {
                isClickInsideNav = true;
            }
        });

        if (!isClickInsideNav) {
            navDropdowns.forEach(dropdown => {
                const menu = dropdown.querySelector('.dropdown-menu');
                const icon = dropdown.querySelector('.dropdown-icon');
                if (menu) {
                    menu.classList.remove('show');
                    menu.classList.add('opacity-0', 'invisible');
                }
                if (icon) {
                    icon.classList.remove('rotate-180');
                }
                dropdown.querySelector('button')?.setAttribute('aria-expanded', 'false');
                });
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCallCenterModal();
            closeReceptionModal();
            closeSupportModal();
            closePdfModal();
            closeConsultationModal();
            closeContactsModal();
            closeSituationCenterModal();
            closeStaffSearchModal();
            closeBugReportModal();
            closeMobileMenu();
            closeChat();
            closeDesktopBurgerMenu();
            
            navDropdowns.forEach(dropdown => {
                const menu = dropdown.querySelector('.dropdown-menu');
                const icon = dropdown.querySelector('.dropdown-icon');
                if (menu) {
                    menu.classList.remove('show');
                    menu.classList.add('opacity-0', 'invisible');
                }
                if (icon) {
                    icon.classList.remove('rotate-180');
                }
                dropdown.querySelector('button')?.setAttribute('aria-expanded', 'false');
                });
        }
    });

    ['pdfModal', 'receptionModal', 'callCenterModal', 'supportModal', 'consultationModal', 'contactsModal', 'staffSearchModal', 'situationCenterModal', 'bugReportModal'].forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    if (modalId === 'pdfModal') closePdfModal();
                    if (modalId === 'receptionModal') closeReceptionModal();
                    if (modalId === 'callCenterModal') closeCallCenterModal();
                    if (modalId === 'supportModal') closeSupportModal();
                    if (modalId === 'consultationModal') closeConsultationModal();
                    if (modalId === 'contactsModal') closeContactsModal();
                    if (modalId === 'staffSearchModal') closeStaffSearchModal();
                    if (modalId === 'situationCenterModal') closeSituationCenterModal();
                    if (modalId === 'bugReportModal') closeBugReportModal();
                }
            });
        }
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.includes('#')) {
                e.preventDefault();
                const target = document.querySelector(href.substring(href.indexOf('#')));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    closeMobileMenu();
                    closeDesktopBurgerMenu();
                }
            }
        });
    });

    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const fallback = this.nextElementSibling;
            if (fallback && fallback.classList.contains('hidden')) {
                fallback.style.display = 'flex';
            }
        });
    });

    setTimeout(updateMobileWeatherWidget, 1000);
    setInterval(updateMobileWeatherWidget, 30000);
});

/**
 * Утилиты для защиты форм от спама и улучшения пользовательского опыта
 */

// Объект для хранения состояния блокировки форм (предотвращение двойной отправки)
const formSubmissionState = {
    pendingForms: new Set(),
    
    isLocked(formId) {
        return this.pendingForms.has(formId);
    },
    
    lock(formId) {
        this.pendingForms.add(formId);
    },
    
    unlock(formId) {
        this.pendingForms.delete(formId);
    }
};

/**
 * Инициализировать honeypot поля в формах
 * Honeypot - скрытое поле, которое боты обычно заполняют, но люди нет
 */
function initializeHoneypotFields() {
    const forms = document.querySelectorAll('form[id*="Form"], form[id*="form"]');
    
    forms.forEach(form => {
        // Проверяем, есть ли уже honeypot поля
        if (form.querySelector('input[name="website_url"], input[name="confirm_bot"]')) {
            return; // Уже инициализированы
        }
        
        // Создаем honeypot поля
        const honeypot1 = document.createElement('input');
        honeypot1.type = 'text';
        honeypot1.name = 'website_url';
        honeypot1.style.display = 'none';
        honeypot1.setAttribute('aria-hidden', 'true');
        honeypot1.setAttribute('autocomplete', 'off');
        honeypot1.setAttribute('tabindex', '-1');
        
        const honeypot2 = document.createElement('input');
        honeypot2.type = 'checkbox';
        honeypot2.name = 'confirm_bot';
        honeypot2.style.display = 'none';
        honeypot2.setAttribute('aria-hidden', 'true');
        honeypot2.setAttribute('tabindex', '-1');
        
        // Добавляем honeypot в начало формы (после @csrf)
        const csrfToken = form.querySelector('input[name="_token"]');
        if (csrfToken) {
            csrfToken.parentNode.insertBefore(honeypot1, csrfToken.nextSibling);
            csrfToken.parentNode.insertBefore(honeypot2, csrfToken.nextSibling);
        } else {
            form.insertBefore(honeypot1, form.firstChild);
            form.insertBefore(honeypot2, form.firstChild);
        }
    });
}

/**
 * Валидировать форму на клиенте перед отправкой
 */
function validateFormBeforeSubmit(event, formId) {
    const form = event.target;
    
    // Проверка honeypot
    const websiteUrl = form.querySelector('input[name="website_url"]');
    const confirmBot = form.querySelector('input[name="confirm_bot"]');
    
    if ((websiteUrl && websiteUrl.value) || (confirmBot && confirmBot.checked)) {
        console.warn('[Form Protection] Honeypot detected - preventing submission');
        event.preventDefault();
        return false;
    }
    
    // Предотвращение двойной отправки
    if (formSubmissionState.isLocked(formId)) {
        event.preventDefault();
        return false;
    }
    
    // Проверка обязательных полей
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value || (field.type === 'checkbox' && !field.checked)) {
            isValid = false;
        }
    });
    
    if (!isValid) {
        event.preventDefault();
        return false;
    }
    
    // Блокируем форму от двойной отправки
    formSubmissionState.lock(formId);
    
    return true;
}

/**
 * Разблокировать форму после отправки
 */
function unlockForm(formId) {
    formSubmissionState.unlock(formId);
}

/**
 * Улучшенная обработка ошибок с адаптивностью к мобильным устройствам
 */
function displayFormErrors(errorContainer, errorList, errors) {
    if (!errorContainer || !errorList) {
        return;
    }
    
    errorList.innerHTML = '';
    
    if (typeof errors === 'string') {
        const li = document.createElement('li');
        li.textContent = errors;
        errorList.appendChild(li);
    } else if (typeof errors === 'object') {
        Object.values(errors).forEach(errorArray => {
            if (Array.isArray(errorArray)) {
                errorArray.forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorList.appendChild(li);
                });
            }
        });
    }
    
    errorContainer.classList.remove('hidden');
    
    // На мобильных устройствах скроллим к ошибкам
    if (window.innerWidth < 768) {
        setTimeout(() => {
            errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }
}

/**
 * Получить реальный User-Agent для отправки в форму bug-report
 */
function getBrowserInfo() {
    const userAgent = navigator.userAgent;
    let browser = 'Неизвестный браузер';
    let os = 'Неизвестная ОС';
    
    // Определение браузера
    if (/Chrome/.test(userAgent) && !/Edge|Chromium/.test(userAgent)) {
        browser = 'Chrome';
    } else if (/Firefox/.test(userAgent)) {
        browser = 'Firefox';
    } else if (/Safari/.test(userAgent) && !/Chrome/.test(userAgent)) {
        browser = 'Safari';
    } else if (/Edge/.test(userAgent)) {
        browser = 'Edge';
    } else if (/Opera|OPR/.test(userAgent)) {
        browser = 'Opera';
    }
    
    // Определение ОС
    if (/Windows/.test(userAgent)) {
        os = 'Windows';
    } else if (/Mac/.test(userAgent)) {
        os = 'macOS';
    } else if (/Linux/.test(userAgent) && !/Android/.test(userAgent)) {
        os = 'Linux';
    } else if (/Android/.test(userAgent)) {
        os = 'Android';
    } else if (/iPhone|iPad|iPod/.test(userAgent)) {
        os = 'iOS';
    }
    
    return { browser, os, userAgent };
}

/**
 * Инициализировать все защиты форм при загрузке страницы
 */
document.addEventListener('DOMContentLoaded', function() {
    initializeHoneypotFields();
    
    // Подавляем автозаполнение для скрытых honeypot полей
    const honeypots = document.querySelectorAll('input[name="website_url"], input[name="confirm_bot"]');
    honeypots.forEach(field => {
        field.addEventListener('autofill', (e) => {
            if (e.target.name === 'website_url' || e.target.name === 'confirm_bot') {
                e.preventDefault();
                e.target.value = '';
            }
        });
    });
});

