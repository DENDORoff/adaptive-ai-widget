<div id="contactsModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'title', 'Контакты') }}</h3>
            <button class="modal-close" onclick="closeContactsModal()">&times;</button>
        </div>
        <div class="form-modal-body">
            <div class="contacts-content">
                <div class="contacts-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                
                <h2 class="contacts-title">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'college_name', 'Высший колледж ВКЭиК') }}</h2>
                
                <div class="contacts-info">
                    <div class="contact-item">
                        <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div class="contact-text">
                            <div class="contact-label">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'address_label', 'Адрес') }}</div>
                            <div class="contact-value">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'address_text', 'г. Павлодар, ул. Жүсіпбек Аймауытұлы, 2') }}</div>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <div class="contact-text">
                            <div class="contact-label">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'phones_label', 'Телефоны') }}</div>
                            <div class="contact-value">
                                <a href="tel:{{ \App\Models\PageSection::getValue('modals', 'contacts', 'phone1_number', '+77182338733') }}" class="contact-link">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'phone1_text', '(7182) 33-87-33') }}</a><br>
                                <a href="tel:{{ \App\Models\PageSection::getValue('modals', 'contacts', 'phone2_number', '+77182338440') }}" class="contact-link">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'phone2_text', '(7182) 33-84-40') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div class="contact-text">
                            <div class="contact-label">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'email_label', 'E-mail') }}</div>
                            <div class="contact-value">
                                <a href="mailto:{{ \App\Models\PageSection::getValue('modals', 'contacts', 'email_address', 'vkeik@edu.kz') }}" class="contact-link">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'email_address', 'vkeik@edu.kz') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <div class="contact-text">
                            <div class="contact-label">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'fax_label', 'Факс') }}</div>
                            <div class="contact-value">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'fax_text', '(7182) 33-87-33') }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="contacts-map">
                    <iframe src="https://yandex.ru/map-widget/v1/?ll=76.97822717164688,52.29349433475749&z=15&l=map&pt=76.97822717164688,52.29349433475749,pm2rdm" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
