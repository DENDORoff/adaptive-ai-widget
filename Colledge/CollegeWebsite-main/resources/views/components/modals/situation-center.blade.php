<div id="situationCenterModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">{{ \App\Models\PageSection::getValue('modals', 'situation_center', 'title', 'Ситуационный центр') }}</h3>
            <button class="modal-close" onclick="closeSituationCenterModal()">&times;</button>
        </div>
        <div class="form-modal-body">
            <div class="contacts-content">
                <div class="contacts-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                
                <h2 class="contacts-title">{{ \App\Models\PageSection::getValue('modals', 'situation_center', 'title', 'Ситуационный центр') }}</h2>
                
                <div class="contacts-info">
                    <div class="contact-item">
                        <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div class="contact-text">
                            <div class="contact-label">{{ \App\Models\PageSection::getValue('modals', 'situation_center', 'control_label', 'Оперативный контроль') }}</div>
                            <div class="contact-value">{{ \App\Models\PageSection::getValue('modals', 'situation_center', 'control_text', 'Мониторинг и управление образовательным процессом в реальном времени') }}</div>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <div class="contact-text">
                            <div class="contact-label">{{ \App\Models\PageSection::getValue('modals', 'situation_center', 'security_label', 'Безопасность') }}</div>
                            <div class="contact-value">{{ \App\Models\PageSection::getValue('modals', 'situation_center', 'security_text', 'Система видеонаблюдения и контроля доступа') }}</div>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <div class="contact-text">
                            <div class="contact-label">{{ \App\Models\PageSection::getValue('modals', 'situation_center', 'response_label', 'Быстрое реагирование') }}</div>
                            <div class="contact-value">{{ \App\Models\PageSection::getValue('modals', 'situation_center', 'response_text', 'Решение оперативных вопросов и инцидентов') }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-blue-800 text-sm text-center">
                        {{ \App\Models\PageSection::getValue('modals', 'situation_center', 'description', 'Ситуационный центр обеспечивает оперативное управление, мониторинг и безопасность образовательного процесса в колледже.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
