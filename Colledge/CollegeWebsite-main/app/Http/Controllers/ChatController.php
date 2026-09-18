<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Services\SpamDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{

    public function getSession(Request $request)
    {
        $sessionId = $request->input('session_id');
        
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
        }
        
        $session = ChatSession::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'user_ip' => $request->ip(),
                'status' => 'active',
            ]
        );
        
        return response()->json([
            'session_id' => $session->session_id,
            'status' => $session->status,
        ]);
    }
    

    public function getMessages(Request $request)
    {
        $sessionId = $request->input('session_id');
        
        if (!$sessionId) {
            return response()->json(['messages' => []]);
        }
        
        $messages = ChatMessage::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'is_admin' => $message->is_admin,
                    'created_at' => $message->created_at->format('H:i'),
                    'date' => $message->created_at->format('d.m.Y'),
                ];
            });
        

        ChatMessage::where('session_id', $sessionId)
            ->where('is_admin', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json(['messages' => $messages]);
    }
    

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|string',
            'message' => 'required|string|max:1000|min:2',
            'user_name' => 'nullable|string|max:255',
            'user_email' => 'nullable|email|max:255',
        ]);

        $session = ChatSession::where('session_id', $validated['session_id'])->first();
        
        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }


        $spamCheck = SpamDetectionService::detectSpam($validated['message']);
        if ($spamCheck['is_spam']) {
            Log::warning('Spam detected in chat', [
                'session_id' => $validated['session_id'],
                'type' => $spamCheck['type'],
                'ip' => $request->ip(),
                'user_email' => $validated['user_email'] ?? null,
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Ваше сообщение содержит недопустимый контент.'
            ], 422);
        }


        if (!empty($validated['user_email']) && !SpamDetectionService::isValidEmail($validated['user_email'])) {
            return response()->json([
                'success' => false,
                'message' => 'Пожалуйста, укажите корректный email адрес.'
            ], 422);
        }

        $lastMessages = ChatMessage::where('session_id', $validated['session_id'])
            ->where('is_admin', false)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->pluck('message')
            ->toArray();

        if (count($lastMessages) >= 3 && count(array_unique($lastMessages)) === 1) {
            return response()->json([
                'success' => false,
                'message' => 'Пожалуйста, не отправляйте одинаковые сообщения.'
            ], 429);
        }

        if (strlen($validated['message']) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Сообщение слишком короткое.'
            ], 422);
        }

        $validated['message'] = $this->filterMessage($validated['message']);
        
        if (!empty($validated['user_name']) || !empty($validated['user_email'])) {
            $session->update([
                'user_name' => $validated['user_name'] ?? $session->user_name,
                'user_email' => $validated['user_email'] ?? $session->user_email,
            ]);
        }
        
        $message = ChatMessage::create([
            'session_id' => $validated['session_id'],
            'user_name' => $validated['user_name'] ?? $session->user_name,
            'user_email' => $validated['user_email'] ?? $session->user_email,
            'message' => $validated['message'],
            'is_admin' => false,
            'is_read' => false,
        ]);
        
        $session->update(['last_message_at' => now()]);
        
        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'is_admin' => false,
                'created_at' => $message->created_at->format('H:i'),
            ],
        ]);
    }

    private function filterMessage(string $message): string
    {
        $badWords = ['спам', 'реклама'];
        
        foreach ($badWords as $word) {
            $message = str_ireplace($word, str_repeat('*', mb_strlen($word)), $message);
        }
        
        return $message;
    }
}