<div id="callCenterModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">{{ \App\Models\PageSection::getValue('modals', 'call_center', 'title', 'CALL-ЦЕНТР') }}</h3>
            <button class="modal-close" onclick="closeCallCenterModal()">&times;</button>
        </div>
        <div class="form-modal-body">
            <div class="contacts-content">
                <div class="contacts-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                
                <h2 class="contacts-title">{{ \App\Models\PageSection::getValue('modals', 'call_center', 'title', 'CALL-ЦЕНТР') }}</h2>
                
                <div class="contacts-info">
                    <div class="contact-item">
                        <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <div class="contact-text">
                            <div class="contact-label">{{ \App\Models\PageSection::getValue('modals', 'call_center', 'mobile_phone_label', 'Сотовый телефон') }}</div>
                            <div class="contact-value">
                                <a href="tel:{{ \App\Models\PageSection::getValue('modals', 'call_center', 'mobile_phone_number', '+77014900566') }}" class="contact-link">{{ \App\Models\PageSection::getValue('modals', 'call_center', 'mobile_phone_number', '+7 701 490 05 66') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <div class="contact-text">
                            <div class="contact-label">{{ \App\Models\PageSection::getValue('modals', 'call_center', 'work_phone_label', 'Рабочий телефон') }}</div>
                            <div class="contact-value">
                                <a href="tel:{{ \App\Models\PageSection::getValue('modals', 'call_center', 'work_phone_number', '+77182338733') }}" class="contact-link">{{ \App\Models\PageSection::getValue('modals', 'call_center', 'work_phone_number', '+7 (7182) 33-87-33') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="contact-text">
                            <div class="contact-label">{{ \App\Models\PageSection::getValue('modals', 'call_center', 'schedule_label', 'График работы') }}</div>
                            <div class="contact-value">{{ \App\Models\PageSection::getValue('modals', 'call_center', 'schedule_text', 'Пн-Пт: 8:00 - 17:00<br>Сб,Вс: выходной') }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-blue-800 text-sm">
                        {{ \App\Models\PageSection::getValue('modals', 'call_center', 'description', 'Наш CALL-ЦЕНТР готов ответить на все ваши вопросы, касающиеся поступления, обучения, расписания и других аспектов работы колледжа.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
