<?php

namespace App\Filament\Resources\ChatSessions\Pages;

use App\Filament\Resources\ChatSessions\ChatSessionResource;
use App\Models\ChatMessage;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewChatSession extends ViewRecord
{
    protected static string $resource = ChatSessionResource::class;
    
    protected static ?string $title = 'Чат с пользователем';

    public $newMessage = '';

    // Укажите правильный layout для Filament
    protected static string $layout = 'filament-panels::components.layout.base';

    public function mount(int | string $record): void
    {
        parent::mount($record);

        if ($this->record) {
            $this->record->messages()
                ->where('is_admin', false)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }
    }

    public function closeOrOpenChat()
    {
        if (!$this->record) return;
        
        $newStatus = $this->record->status === 'active' ? 'closed' : 'active';
        $this->record->update(['status' => $newStatus]);

        Notification::make()
            ->success()
            ->title($newStatus === 'closed' ? 'Чат закрыт' : 'Чат открыт')
            ->send();

        $this->refreshRecord();
        
        $this->dispatch('chat-closed');
    }

    public function deleteChat()
    {
        if (!$this->record) return;
        
        $this->record->messages()->delete();
        $this->record->delete();

        Notification::make()
            ->success()
            ->title('Чат удален')
            ->send();
            
        $this->dispatch('chat-deleted');
    }

    public function sendMessage()
    {
        if (empty($this->newMessage) || !$this->record) {
            return;
        }

        ChatMessage::create([
            'session_id' => $this->record->session_id,
            'message' => $this->newMessage,
            'is_admin' => true,
            'is_read' => false,
        ]);

        $this->record->update(['last_message_at' => now()]);

        $this->newMessage = '';

        Notification::make()
            ->success()
            ->title('Сообщение отправлено')
            ->send();

        $this->refreshRecord();
    }

    public function refreshMessages()
    {
        if (!$this->record) {
            return;
        }
        
        $this->record->messages()
            ->where('is_admin', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->refreshRecord();
    }

    private function refreshRecord()
    {
        if ($this->record) {
            $this->record = $this->record->fresh();
            $this->record->load('messages');
        }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        // Используем Filament layout
        $view = view('filament.resources.chat-sessions.pages.view-chat', [
            'record' => $this->record,
            'messages' => $this->record ? $this->record->messages()->orderBy('created_at', 'asc')->get() : [],
        ]);
        
        // Указываем layout для Filament
        return $view->layout(static::$layout);
    }
}