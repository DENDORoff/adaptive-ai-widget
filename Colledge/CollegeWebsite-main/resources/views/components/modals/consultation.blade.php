<div id="consultationModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">{{ \App\Models\PageSection::getValue('modals', 'consultation', 'title', 'Консультация с приемной комиссией') }}</h3>
            <button class="modal-close" onclick="closeConsultationModal()">&times;</button>
        </div>
        <div class="form-modal-body">
            <div class="form-header">
                <div class="form-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h4 class="modal-title">{{ \App\Models\PageSection::getValue('modals', 'consultation', 'form_title', 'Заявка на консультацию') }}</h4>
                <p class="form-subtitle">{{ \App\Models\PageSection::getValue('modals', 'consultation', 'form_subtitle', 'Заполните форму и мы свяжемся с вами в ближайшее время') }}</p>
            </div>
            
            <form id="consultationForm" class="consultation-form">
                @csrf
                
                <div id="consultationSuccessMessage" class="hidden bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ \App\Models\PageSection::getValue('modals', 'consultation', 'success_message', 'Ваша заявка успешно отправлена!') }}</span>
                    </div>
                </div>

                <div id="consultationErrorMessages" class="hidden bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <ul id="consultationErrorList" class="text-sm space-y-1"></ul>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="consultation_name">{{ \App\Models\PageSection::getValue('modals', 'consultation', 'name_label', 'ФИО') }} *</label>
                    <input type="text" id="consultation_name" name="name" required placeholder="{{ \App\Models\PageSection::getValue('modals', 'consultation', 'name_placeholder', 'Введите ваше полное имя') }}">
                </div>
                
                <div class="form-group">
                    <label for="consultation_phone">{{ \App\Models\PageSection::getValue('modals', 'consultation', 'phone_label', 'Телефон') }} *</label>
                    <input type="tel" id="consultation_phone" name="phone" required placeholder="{{ \App\Models\PageSection::getValue('modals', 'consultation', 'phone_placeholder', '+7 (XXX) XXX-XX-XX') }}">
                </div>
                
                <div class="form-group">
                    <label for="consultation_email">{{ \App\Models\PageSection::getValue('modals', 'consultation', 'email_label', 'Email') }} *</label>
                    <input type="email" id="consultation_email" name="email" required placeholder="{{ \App\Models\PageSection::getValue('modals', 'consultation', 'email_placeholder', 'example@email.com') }}">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="submit-btn">{{ \App\Models\PageSection::getValue('modals', 'consultation', 'submit_button', 'Отправить заявку на консультацию') }}</button>
                </div>
                
                <div class="consultation-info">
                    <p>{{ \App\Models\PageSection::getValue('modals', 'consultation', 'info_text', 'Наш специалист свяжется с вами в течение 24 часов для консультации по вопросам поступления.') }}</p>
                </div>
            </form>
        </div>
    </div>
</div>
