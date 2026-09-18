<x-filament-panels::page>
    @push('styles')
        <style>
            /* --- Page base --- */
            .chat-wrapper {
                background: linear-gradient(180deg, #0b0d0f 0%, #0f1113 100%);
                color: #e6eef8;
                min-height: 60vh;
                border-radius: 12px;
            }

            /* --- Messages container --- */
            .chat-messages-container {
                height: 62vh;
                min-height: 320px;
                max-height: 78vh;
                overflow-y: auto;
                padding: 20px;
                display: flex;
                flex-direction: column;
                gap: 18px;
                transition: background 0.2s ease;
            }

            /* Custom thin scrollbar */
            .chat-messages-container::-webkit-scrollbar { width: 8px; }
            .chat-messages-container::-webkit-scrollbar-track { background: transparent; }
            .chat-messages-container::-webkit-scrollbar-thumb {
                background: linear-gradient(180deg,#2b3036,#1b1d20);
                border-radius: 10px;
                border: 2px solid transparent;
                background-clip: content-box;
            }

            /* Row wrapper helps alignment - let bubbles take available width */
            .message-row {
                display: flex;
                gap: 12px;
                align-items: flex-start; /* allow multiline bubbles to expand vertically */
                max-width: 100%;
            }
            .message-row.user { justify-content: flex-start; }
            .message-row.admin { justify-content: flex-end; }

            /* Avatar */
            .msg-avatar {
                width: 44px;
                height: 44px;
                border-radius: 999px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 1rem;
                flex-shrink: 0;
                box-shadow: 0 6px 18px rgba(2,6,23,0.5);
                border: 2px solid rgba(255,255,255,0.03);
            }
            .avatar-user { background: linear-gradient(135deg,#f8fafc,#e6eef8); color:#0b0d0f; }
            .avatar-admin { background: linear-gradient(135deg,#3b82f6,#60a5fa); color:#ffffff; }

            /* Bubble base - allow bubbles to grow */
            .message-bubble {
                position: relative;
                padding: 12px 14px;
                border-radius: 14px;
                line-height: 1.4;
                word-break: break-word;
                font-size: 0.95rem;
                box-shadow: 0 6px 18px rgba(2,6,23,0.45);
                transition: transform .08s ease, box-shadow .12s ease;
                display: block;
                /* use calc so bubble can take most of the row width but leave space for avatar */
                max-width: calc(100% - 120px);
                min-width: 120px; /* avoid tiny bubbles */
            }
            .message-bubble:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(2,6,23,0.55); }

            /* User bubble (left) */
            .message-user {
                background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
                color: #0b1220;
                border: 1px solid rgba(10,10,10,0.03);
                border-bottom-left-radius: 6px;
            }
            .message-user::after {
                content: "";
                position: absolute;
                left: -8px;
                bottom: 10px;
                width: 14px;
                height: 14px;
                background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
                transform: rotate(45deg);
                border-bottom-left-radius: 2px;
                box-shadow: 0 6px 14px rgba(2,6,23,0.04);
            }

            /* Admin bubble (right) */
            .message-admin {
                background: linear-gradient(180deg,#377ef8,#2b6fe6);
                color: #fff;
                border: 1px solid rgba(255,255,255,0.06);
                border-bottom-right-radius: 6px;
            }
            .message-admin::after {
                content: "";
                position: absolute;
                right: -8px;
                bottom: 10px;
                width: 14px;
                height: 14px;
                background: linear-gradient(180deg,#377ef8,#2b6fe6);
                transform: rotate(45deg);
                border-bottom-right-radius: 2px;
                filter: drop-shadow(0 6px 12px rgba(43,111,230,0.12));
            }

            /* Make sender name less tall and not shrink bubble */
            .message-bubble .sender-name { font-size: 0.82rem; margin-bottom:6px; color: rgba(255,255,255,0.9); }
            .message-bubble .message-body { font-size: 0.95rem; color: inherit; }

            /* Time & meta */
            .time-wrapper {
                display: flex;
                width: 100%;
                margin-top: 6px;
                font-size: 0.78rem;
                color: #98a0a8;
            }
            .time-wrapper.user { justify-content: flex-start; padding-left: 64px; }
            .time-wrapper.admin { justify-content: flex-end; padding-right: 64px; }

            .time-chip {
                display: inline-flex;
                gap: 6px;
                align-items: center;
                padding: 6px 8px;
                border-radius: 999px;
                background: rgba(255,255,255,0.02);
                color: #9aa6b2;
                font-size: 12px;
            }
            .read-indicator { color: rgba(255,255,255,0.85); font-size: 12px; margin-left: 6px; }

            /* System / centered messages */
            .system-message {
                text-align: center;
                color: #9aa6b2;
                font-size: 0.9rem;
                padding: 10px;
                background: rgba(255,255,255,0.02);
                border-radius: 10px;
                max-width: 60%;
                margin: 0 auto;
            }

            /* Input area */
            .chat-input-wrapper {
                border-top: 1px solid rgba(255,255,255,0.03);
                padding: 18px 18px 22px 18px;
                background: linear-gradient(180deg, rgba(255,255,255,0.01), transparent);
            }

            .input-row {
                display: flex;
                gap: 12px;
                align-items: flex-end;
            }

            /* ensure children can shrink correctly */
            .input-row > div { min-width: 0; }

            /* Make textarea truly expand to available space */
            .chat-textarea {
                flex: 1 1 auto;
                width: 100%;
                min-height: 52px;
                max-height: 300px;
                resize: none;
                padding: 14px 14px 14px 56px; /* room for icon */
                border-radius: 12px;
                border: 1px solid rgba(255,255,255,0.04);
                background: rgba(12,14,16,0.75);
                color: #e6eef8;
                font-size: 0.98rem;
                outline: none;
                position: relative;
                transition: box-shadow .12s ease, border-color .12s ease;
            }
            .chat-textarea:focus { box-shadow: 0 8px 30px rgba(40,120,240,0.12); border-color: rgba(79,155,255,0.9); }
            .chat-textarea::placeholder { color: #7b8a95; }

            .textarea-icon {
                position: absolute;
                left: 18px;
                top: 18px;
                pointer-events: none;
                opacity: 0.95;
            }

            .send-button {
                height: 44px;
                border-radius: 12px;
                background: linear-gradient(180deg,#4f9bff,#2878f0);
                color: white;
                box-shadow: 0 8px 30px rgba(40,120,240,0.18);
                border: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0 18px;
                white-space: nowrap;
            }
            .send-button[disabled] {
                opacity: 0.45;
                cursor: not-allowed;
                box-shadow: none;
                background: rgba(255,255,255,0.04);
            }

            .helper-text { color: #89a0ad; font-size: 12px; margin-top: 10px; }

            /* Header / user compact info */
            .user-header {
                display: flex;
                align-items: center;
                gap: 12px;
                width: 100%;
            }
            .user-meta {
                display: flex;
                flex-direction: column;
                gap: 2px;
                min-width: 0;
            }
            .user-name {
                font-weight: 700;
                color: #ffffff;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 320px;
            }
            .user-sub {
                font-size: 0.9rem;
                color: #c6d0da;
            }
            .status-dot {
                width: 10px;
                height: 10px;
                border-radius: 999px;
                display: inline-block;
                margin-right: 8px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.45);
            }

            /* Small devices */
            @media (max-width: 720px) {
                .message-bubble { max-width: 86%; min-width: 90px; }
                .time-wrapper.user { padding-left: 46px; }
                .time-wrapper.admin { padding-right: 46px; }
                .user-name { max-width: 160px; }
                .send-button { padding: 0 10px; min-width: 64px; }
                .msg-avatar { width: 40px; height: 40px; }
                .chat-textarea { min-height: 44px; }
            }
        </style>
    @endpush

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-200">
                {{ $this->getTitle() }}
            </h2>

            @if($record)
                <div class="flex gap-2">
                    <x-filament::button
                        wire:click="$dispatch('open-modal', {id: 'close-chat-confirmation'})"
                        :color="$record->status === 'active' ? 'danger' : 'success'"
                        icon="heroicon-o-chat-bubble-left-right"
                        size="sm">
                        {{ $record->status === 'active' ? 'Закрыть чат' : 'Открыть чат' }}
                    </x-filament::button>

                    <x-filament::button
                        wire:click="$dispatch('open-modal', {id: 'delete-chat-confirmation'})"
                        color="danger"
                        icon="heroicon-o-trash"
                        size="sm">
                        Удалить чат
                    </x-filament::button>
                </div>
            @endif
        </div>
    </x-slot>

    @if(!$record)
        <div class="p-6 text-center text-gray-500">
            Чат не найден
        </div>
    @else
        <!-- Modals (unchanged) -->
        <x-filament::modal id="close-chat-confirmation">
            <x-slot name="heading">
                {{ $record->status === 'active' ? 'Закрыть чат' : 'Открыть чат' }}
            </x-slot>
            <p class="text-gray-600 dark:text-gray-400">
                {{ $record->status === 'active' ? 'Вы уверены, что хотите закрыть этот чат?' : 'Вы уверены, что хотите открыть этот чат?' }}
            </p>
            <x-slot name="footer">
                <x-filament::button color="gray" x-on:click="isOpen = false">Отмена</x-filament::button>
                <x-filament::button wire:click="closeOrOpenChat" :color="$record->status === 'active' ? 'danger' : 'success'">
                    {{ $record->status === 'active' ? 'Закрыть' : 'Открыть' }}
                </x-filament::button>
            </x-slot>
        </x-filament::modal>

        <x-filament::modal id="delete-chat-confirmation">
            <x-slot name="heading">Удалить чат</x-slot>
            <p class="text-gray-600 dark:text-gray-400">Все сообщения будут удалены. Это действие нельзя отменить.</p>
            <x-slot name="footer">
                <x-filament::button color="gray" x-on:click="isOpen = false">Отмена</x-filament::button>
                <x-filament::button wire:click="deleteChat" color="danger">Удалить</x-filament::button>
            </x-slot>
        </x-filament::modal>

        <div class="space-y-4 chat-wrapper p-4">
            <!-- Header / user info -->
            <x-filament::section>
                <div class="user-header">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-700 rounded-full flex items-center justify-center text-white text-lg font-bold shadow-md">
                        {{ strtoupper(substr($record->user_name ?? 'Г', 0, 1)) }}
                    </div>

                    <div class="user-meta">
                        <div class="flex items-center" style="gap:8px;align-items:center;">
                            <span class="status-dot" style="background: {{ $record->status === 'active' ? '#34d399' : '#ef4444' }}"></span>
                            <h3 class="user-name">{{ $record->user_name ?? 'Гость' }}</h3>
                        </div>

                        <div class="flex items-center gap-3">
                            <p class="user-sub truncate">{{ $record->user_email ?? 'Email не указан' }}</p>

                            @if($record->last_active_at)
                                <p class="user-sub">• был(а) {{ $record->last_active_at->diffForHumans() }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="ml-auto">
                        <x-filament::badge :color="$record->status === 'active' ? 'success' : 'danger'">
                            {{ $record->status === 'active' ? 'Активный' : 'Закрыт' }}
                        </x-filament::badge>
                    </div>
                </div>
            </x-filament::section>

            <!-- Chat area -->
            <x-filament::section>
                <div class="border border-gray-800 rounded-xl overflow-hidden">
                    <div id="messagesContainer" class="chat-messages-container" wire:poll.5s="refreshMessages">
                        @forelse($messages as $message)
                            @php
                                $isAdmin = (bool) $message->is_admin;
                                $rowClass = $isAdmin ? 'admin' : 'user';
                                $bubbleClass = $isAdmin ? 'message-admin' : 'message-user';
                                $avatarClass = $isAdmin ? 'avatar-admin' : 'avatar-user';
                                $timeClass = $isAdmin ? 'admin' : 'user';
                            @endphp

                            @if($message->type ?? null === 'system')
                                <div class="system-message">{{ $message->message }}</div>
                            @else
                                <div class="message-row {{ $rowClass }}">
                                    @if(!$isAdmin)
                                        <div class="msg-avatar {{ $avatarClass }}" title="{{ $message->sender_name ?? $record->user_name ?? 'Г' }}">{{ strtoupper(substr($message->sender_name ?? $record->user_name ?? 'Г', 0, 1)) }}</div>
                                    @endif

                                    <div class="message-bubble {{ $bubbleClass }}">
                                        <div class="sender-name"><strong>{{ $message->sender_name ?? ($isAdmin ? 'Админ' : $record->user_name) }}</strong></div>

                                        <div class="message-body">
                                            {!! nl2br(e($message->message)) !!}
                                        </div>
                                    </div>

                                    @if($isAdmin)
                                        <div class="msg-avatar {{ $avatarClass }}" title="{{ $message->sender_name ?? 'A' }}">{{ strtoupper(substr($message->sender_name ?? 'A', 0, 1)) }}</div>
                                    @endif
                                </div>

                                <div class="time-wrapper {{ $timeClass }}">
                                    <div class="time-chip">
                                        {{ $message->created_at->format('H:i') }}
                                        @if($isAdmin && $message->is_read)
                                            <span class="read-indicator">✓✓</span>
                                        @elseif($isAdmin && !$message->is_read)
                                            <span class="read-indicator">✓</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="system-message">Нет сообщений — начните диалог</div>
                        @endforelse
                    </div>

                    <!-- Input -->
                    @if($record->status === 'active')
                        <div class="chat-input-wrapper">
                            <form wire:submit.prevent="sendMessage" class="flex flex-col">
                                <div class="input-row">
                                    <div style="position:relative;flex:1;">
                                        <svg class="textarea-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" style="position:absolute;top:18px;left:18px;opacity:.9">
                                            <path d="M3 8.5C3 7.11929 4.11929 6 5.5 6H18.5C19.8807 6 21 7.11929 21 8.5V15.5C21 16.8807 19.8807 18 18.5 18H5.5C4.11929 18 3 16.8807 3 15.5V8.5Z" stroke="rgba(255,255,255,0.14)" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M8 11.5H16" stroke="rgba(255,255,255,0.14)" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>

                                        <textarea
                                            id="newMessageTextarea"
                                            wire:model.defer="newMessage"
                                            rows="2"
                                            placeholder="Введите сообщение..."
                                            class="chat-textarea"
                                            @keydown.enter.prevent="if(!$event.shiftKey) { $wire.sendMessage(); }"
                                            oninput="autoGrow(this)"></textarea>
                                    </div>

                                    <div style="display:flex;align-items:flex-end;">
                                        <x-filament::button
                                            type="submit"
                                            class="send-button"
                                            :disabled="empty(trim($newMessage))"
                                            icon="heroicon-o-paper-airplane">
                                            Отправить
                                        </x-filament::button>
                                    </div>
                                </div>

                                <div class="helper-text">Enter — отправить, Shift+Enter — новая строка</div>
                            </form>
                        </div>
                    @else
                        <div class="chat-input-wrapper text-center text-gray-400">
                            <x-heroicon-o-lock-closed class="w-5 h-5 inline-block mr-1" />
                            Чат закрыт
                        </div>
                    @endif
                </div>
            </x-filament::section>
        </div>

        <script>
            function autoGrow(el) {
                el.style.height = 'auto';
                const newHeight = Math.min(el.scrollHeight, 300);
                el.style.height = newHeight + 'px';
            }

            document.addEventListener('DOMContentLoaded', function() {
                // init textarea size
                const ta = document.getElementById('newMessageTextarea');
                if (ta) autoGrow(ta);

                function scrollToBottom(smooth = true) {
                    const container = document.getElementById('messagesContainer');
                    if (!container) return;
                    const top = container.scrollHeight - container.clientHeight;
                    if (smooth) container.scrollTo({ top, behavior: 'smooth' });
                    else container.scrollTop = top;
                }

                // initial scroll
                setTimeout(() => scrollToBottom(true), 120);

                // Livewire hook for subsequent updates
                if (window.Livewire) {
                    Livewire.hook('message.processed', () => {
                        // Only auto-scroll if user near bottom
                        const c = document.getElementById('messagesContainer');
                        if (!c) return;
                        const nearBottom = c.scrollHeight - c.scrollTop - c.clientHeight < 200;
                        if (nearBottom) scrollToBottom(true);
                    });
                }

                // Mutation observer fallback
                const container = document.getElementById('messagesContainer');
                if (container && window.MutationObserver) {
                    const obs = new MutationObserver(() => {
                        const nearBottom = container.scrollHeight - container.scrollTop - container.clientHeight < 200;
                        if (nearBottom) scrollToBottom(true);
                    });
                    obs.observe(container, { childList: true, subtree: true });
                }
            });
        </script>
    @endif
</x-filament-panels::page>
