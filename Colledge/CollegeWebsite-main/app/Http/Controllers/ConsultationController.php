<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Services\SpamDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ConsultationController extends Controller
{

    public function store(Request $request)
    {

        $data = $request->all();
        unset($data['website_url']);
        unset($data['confirm_bot']);
        
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^\+?[0-9\s\-\(\)]+$/'
            ],
            'message' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Пожалуйста, укажите ваше имя',
            'email.required' => 'Пожалуйста, укажите ваш email',
            'email.email' => 'Укажите корректный email адрес',
            'phone.required' => 'Пожалуйста, укажите номер телефона',
            'phone.regex' => 'Введите корректный номер телефона. Допускаются цифры, пробелы, дефисы, скобки и знак плюс в начале',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if (!SpamDetectionService::isValidEmail($request->email)) {
            return response()->json([
                'success' => false,
                'errors' => ['email' => ['Введите корректный email адрес']]
            ], 422);
        }

        $textFields = ['name', 'message'];
        foreach ($textFields as $field) {
            if (!$request->filled($field)) {
                continue;
            }

            $spamCheck = SpamDetectionService::detectSpam($request->input($field));
            if ($spamCheck['is_spam']) {
                Log::warning('Spam detected in consultation form', [
                    'field' => $field,
                    'type' => $spamCheck['type'],
                    'ip' => $request->ip(),
                    'email' => $request->email,
                ]);

                return response()->json([
                    'success' => false,
                    'errors' => [$field => ['Введённые данные содержат недопустимый контент']]
                ], 422);
            }
        }

        if (!SpamDetectionService::isValidPhone($request->phone)) {
            return response()->json([
                'success' => false,
                'errors' => ['phone' => ['Введите корректный номер телефона']]
            ], 422);
        }

        try {
            $cleanPhone = preg_replace('/[^\d+]/', '', $request->phone);
            
            $consultation = Consultation::create([
                'name' => SpamDetectionService::sanitize($request->name),
                'email' => $request->email,
                'phone' => $cleanPhone, 
                'message' => $request->filled('message') 
                    ? SpamDetectionService::sanitize($request->message) 
                    : null,
            ]);

            Log::info('Consultation request submitted successfully', [
                'consultation_id' => $consultation->id,
                'email' => $request->email,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ваша заявка принята! Мы свяжемся с вами в ближайшее время.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating consultation', [
                'error' => $e->getMessage(),
                'email' => $request->email,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка. Попробуйте позже.'
            ], 500);
        }
    }
}