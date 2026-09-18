<div id="bugReportModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">{{ \App\Models\PageSection::getValue('bug_report', 'modal', 'title', 'Сообщить об ошибке на сайте') }}</h3>
            <button class="modal-close" onclick="closeBugReportModal()">&times;</button>
        </div>
        
        <form id="bugReportForm" class="form-modal-body space-y-5">
            @csrf
            
            <div id="bugReportSuccessMessage" class="hidden bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ \App\Models\PageSection::getValue('bug_report', 'messages', 'success', 'Спасибо за ваш отчет! Мы рассмотрим его в ближайшее время.') }}</span>
                </div>
            </div>

            <div id="bugReportErrorMessages" class="hidden bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <ul id="bugReportErrorList" class="text-sm space-y-1"></ul>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="bug_full_name" class="block text-sm font-medium text-blue-600 mb-2">
                        {{ \App\Models\PageSection::getValue('bug_report', 'form', 'full_name_label', 'Ваше ФИО') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="bug_full_name" 
                           name="full_name" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-900"
                           required>
                </div>

                <div>
                    <label for="bug_email" class="block text-sm font-medium text-blue-600 mb-2">
                        {{ \App\Models\PageSection::getValue('bug_report', 'form', 'email_label', 'E-mail') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="bug_email" 
                           name="email" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-900"
                           required>
                </div>
            </div>

            <div>
                <label for="bug_phone" class="block text-sm font-medium text-blue-600 mb-2">
                    {{ \App\Models\PageSection::getValue('bug_report', 'form', 'phone_label', 'Телефон') }}
                </label>
                <input type="tel" 
                       id="bug_phone" 
                       name="phone" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-900">
            </div>

            <div>
                <label for="bug_page_url" class="block text-sm font-medium text-blue-600 mb-2">
                    {{ \App\Models\PageSection::getValue('bug_report', 'form', 'page_url_label', 'URL страницы с ошибкой') }}
                </label>
                <input type="url" 
                       id="bug_page_url" 
                       name="page_url" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-900"
                       value="{{ url()->current() }}">
            </div>

            <div>
                <label for="bug_title" class="block text-sm font-medium text-blue-600 mb-2">
                    {{ \App\Models\PageSection::getValue('bug_report', 'form', 'title_label', 'Краткое описание ошибки') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="bug_title" 
                       name="title" 
                       placeholder="{{ \App\Models\PageSection::getValue('bug_report', 'form', 'title_placeholder', 'Например: \"Не открывается страница контактов\" или \"Ошибка в форме отправки\"') }}"
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-900"
                       required>
            </div>

            <div>
                <label for="bug_description" class="block text-sm font-medium text-blue-600 mb-2">
                    {{ \App\Models\PageSection::getValue('bug_report', 'form', 'description_label', 'Подробное описание ошибки') }} <span class="text-red-500">*</span>
                </label>
                <textarea id="bug_description" 
                          name="description" 
                          rows="4" 
                          placeholder="{{ \App\Models\PageSection::getValue('bug_report', 'form', 'description_placeholder', 'Опишите ошибку максимально подробно. Что вы делали, когда возникла ошибка? Что ожидали увидеть и что увидели вместо этого?') }}"
                          class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none text-gray-900"
                          required></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="bug_expected_result" class="block text-sm font-medium text-blue-600 mb-2">
                        {{ \App\Models\PageSection::getValue('bug_report', 'form', 'expected_result_label', 'Ожидаемый результат') }}
                    </label>
                    <textarea id="bug_expected_result" 
                              name="expected_result" 
                              rows="3" 
                              placeholder="{{ \App\Models\PageSection::getValue('bug_report', 'form', 'expected_result_placeholder', 'Что должно было произойти?') }}"
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none text-gray-900"></textarea>
                </div>

                <div>
                    <label for="bug_actual_result" class="block text-sm font-medium text-blue-600 mb-2">
                        {{ \App\Models\PageSection::getValue('bug_report', 'form', 'actual_result_label', 'Фактический результат') }}
                    </label>
                    <textarea id="bug_actual_result" 
                              name="actual_result" 
                              rows="3" 
                              placeholder="{{ \App\Models\PageSection::getValue('bug_report', 'form', 'actual_result_placeholder', 'Что произошло на самом деле?') }}"
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none text-gray-900"></textarea>
                </div>
            </div>

            <div>
                <label for="bug_steps_to_reproduce" class="block text-sm font-medium text-blue-600 mb-2">
                    {{ \App\Models\PageSection::getValue('bug_report', 'form', 'steps_label', 'Шаги для воспроизведения ошибки') }}
                </label>
                <div id="bugStepsContainer" class="space-y-2 mb-3">
                </div>
                <button type="button" 
                        onclick="addBugStep()" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ \App\Models\PageSection::getValue('bug_report', 'form', 'add_step_button', 'Добавить шаг') }}
                </button>
            </div>

            <div>
                <label for="bug_priority" class="block text-sm font-medium text-blue-600 mb-2">
                    {{ \App\Models\PageSection::getValue('bug_report', 'form', 'priority_label', 'Приоритет ошибки') }}
                </label>
                <select id="bug_priority" 
                        name="priority" 
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-900">
                    <option value="medium">{{ \App\Models\PageSection::getValue('bug_report', 'form', 'priority_medium', 'Средний (функционал работает, но есть проблемы)') }}</option>
                    <option value="high">{{ \App\Models\PageSection::getValue('bug_report', 'form', 'priority_high', 'Высокий (серьезная проблема, мешающая использованию)') }}</option>
                    <option value="critical">{{ \App\Models\PageSection::getValue('bug_report', 'form', 'priority_critical', 'Критический (сайт не работает)') }}</option>
                    <option value="low">{{ \App\Models\PageSection::getValue('bug_report', 'form', 'priority_low', 'Низкий (косметическая проблема)') }}</option>
                </select>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg mt-6">
                <h4 class="font-medium text-gray-900 mb-3">{{ \App\Models\PageSection::getValue('bug_report', 'form', 'tech_info_title', 'Техническая информация (собирается автоматически)') }}</h4>
                <div class="grid grid-cols-2 gap-3 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">{{ \App\Models\PageSection::getValue('bug_report', 'form', 'browser_label', 'Браузер:') }}</span>
                        <span id="bug_browser_info" class="ml-2">{{ \App\Models\PageSection::getValue('bug_report', 'form', 'detecting_text', 'Определяется...') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">{{ \App\Models\PageSection::getValue('bug_report', 'form', 'os_label', 'ОС:') }}</span>
                        <span id="bug_os_info" class="ml-2">{{ \App\Models\PageSection::getValue('bug_report', 'form', 'detecting_text', 'Определяется...') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">{{ \App\Models\PageSection::getValue('bug_report', 'form', 'device_label', 'Устройство:') }}</span>
                        <span id="bug_device_info" class="ml-2">{{ \App\Models\PageSection::getValue('bug_report', 'form', 'detecting_text', 'Определяется...') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">{{ \App\Models\PageSection::getValue('bug_report', 'form', 'time_label', 'Время:') }}</span>
                        <span id="bug_time_info" class="ml-2">{{ now()->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" 
                        id="bugReportSubmitButton"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    {{ \App\Models\PageSection::getValue('bug_report', 'form', 'submit_button', 'Отправить отчет') }}
                </button>
                <button type="button" 
                        onclick="closeBugReportModal()"
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                    {{ \App\Models\PageSection::getValue('bug_report', 'form', 'cancel_button', 'Отмена') }}
                </button>
            </div>
        </form>
    </div>
</div>
