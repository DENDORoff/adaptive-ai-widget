<div id="supportModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">{{ \App\Models\PageSection::getValue('modals', 'support', 'title', 'Форма обращения') }}</h3>
            <button class="modal-close" onclick="closeSupportModal()">&times;</button>
        </div>
        
        <form id="appealForm" class="form-modal-body space-y-5">
            @csrf
            
            <div id="appealSuccessMessage" class="hidden bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ \App\Models\PageSection::getValue('modals', 'support', 'success_message', 'Ваше обращение успешно отправлено!') }}</span>
                </div>
            </div>

            <div id="appealErrorMessages" class="hidden bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <ul id="appealErrorList" class="text-sm space-y-1"></ul>
                </div>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-blue-600 mb-2">
                    {{ \App\Models\PageSection::getValue('modals', 'support', 'address_label', 'Адресат обращения') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="address" 
                       name="address" 
                       value="{{ \App\Models\PageSection::getValue('modals', 'support', 'address_default', 'Администрация колледжа') }}"
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-900"
                       required>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-blue-600 mb-2">
                    {{ \App\Models\PageSection::getValue('modals', 'support', 'email_label', 'E-mail') }} <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-900"
                       required>
            </div>

            <div>
                <label for="full_name" class="block text-sm font-medium text-blue-600 mb-2">
                    {{ \App\Models\PageSection::getValue('modals', 'support', 'full_name_label', 'Ваше ФИО') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="full_name" 
                       name="full_name" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-900"
                       required>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-blue-600 mb-2">
                    {{ \App\Models\PageSection::getValue('modals', 'support', 'phone_label', 'Телефон') }}
                </label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-900">
            </div>

            <div>
                <label for="type" class="block text-sm font-medium text-blue-600 mb-2">
                    {{ \App\Models\PageSection::getValue('modals', 'support', 'type_label', 'Тип обращения') }} <span class="text-red-500">*</span>
                </label>
                <select id="type" 
                        name="type" 
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-900"
                        required>
                    <option value="">{{ \App\Models\PageSection::getValue('modals', 'support', 'type_select', 'Выберите тип') }}</option>
                    <option value="complaint">{{ \App\Models\PageSection::getValue('modals', 'support', 'type_complaint', 'Жалоба') }}</option>
                    <option value="other">{{ \App\Models\PageSection::getValue('modals', 'support', 'type_other', 'Другое') }}</option>
                </select>
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-blue-600 mb-2">
                    {{ \App\Models\PageSection::getValue('modals', 'support', 'message_label', 'Сообщение') }} <span class="text-red-500">*</span>
                </label>
                <textarea id="message" 
                          name="message" 
                          rows="6" 
                          class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none text-gray-900"
                          required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-blue-600 mb-2 cursor-pointer hover:text-blue-700 transition">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>{{ \App\Models\PageSection::getValue('modals', 'support', 'file_label', 'Добавить файл') }}</span>
                    </div>
                    <input type="file" 
                           id="file" 
                           name="file" 
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                           class="hidden"
                           onchange="displayFileName(this)">
                </label>
                <div id="fileName" class="mt-2 text-sm text-gray-600"></div>
                <p class="mt-1 text-xs text-gray-500">
                    {{ \App\Models\PageSection::getValue('modals', 'support', 'file_requirements', 'Допустимые форматы: PDF, DOC, DOCX, JPG, PNG. Максимальный размер: 5MB') }}
                </p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" 
                           id="consent" 
                           name="consent" 
                           class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                           required>
                    <span class="text-sm text-gray-700">
                        {{ \App\Models\PageSection::getValue('modals', 'support', 'consent_text', 'Я предупрежден об уголовной ответственности за подачу заведомо ложных сведений') }}
                    </span>
                </label>
                
                <div class="mt-3 text-xs text-gray-600 space-y-2">
                    <p><strong>{{ \App\Models\PageSection::getValue('modals', 'support', 'article_419', 'Статья 419.') }}</strong> {{ \App\Models\PageSection::getValue('modals', 'support', 'article_title', 'Заведомо ложный донос') }}</p>
                    <p><strong>1.</strong> {{ \App\Models\PageSection::getValue('modals', 'support', 'paragraph_1', 'Заведомо ложный донос о совершении уголовного проступка - наказывается штрафом в размере до двухсот месячных расчетных показателей либо исправительными работами в том же размере, либо привлечением к общественным работам на срок до двухсот часов.') }}</p>
                    <p><strong>2.</strong> {{ \App\Models\PageSection::getValue('modals', 'support', 'paragraph_2', 'Заведомо ложный донос о совершении преступления - наказывается штрафом в размере до четырех тысяч месячных расчетных показателей либо исправительными работами в том же размере, либо привлечением к общественных работ на срок до одной тысячи часов, либо ограничением свободы на срок до пяти лет, либо лишением свободы на тот же срок.') }}</p>
                    <p><strong>3.</strong> {{ \App\Models\PageSection::getValue('modals', 'support', 'paragraph_3', 'Деяние, предусмотренное частью второй настоящей статьи, соединенное с обвинением лица в совершении коррупционного, тяжкого или особо тяжкого преступления либо совершенное из корыстных побуждений, - наказывается лишением свободы на срок от трех до восьми лет.') }}</p>
                    <p><strong>4.</strong> {{ \App\Models\PageSection::getValue('modals', 'support', 'paragraph_4', 'Деяния, предусмотренные частями второй или третьей настоящей статьи, совершенные в интересах преступной группы, - наказываются лишением свободы на срок от пяти до двенадцати лет.') }}</p>
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" 
                        id="submitButton"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    {{ \App\Models\PageSection::getValue('modals', 'support', 'submit_button', 'Отправить') }}
                </button>
                <button type="button" 
                        onclick="closeSupportModal()"
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                    {{ \App\Models\PageSection::getValue('modals', 'support', 'cancel_button', 'Отмена') }}
                </button>
            </div>
        </form>
    </div>
</div>
