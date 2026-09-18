<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Services\SpamDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AppealController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->all();
        unset($data['website_url']);
        unset($data['confirm_bot']);
        
        $validator = Validator::make($data, [
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'type' => 'required|in:complaint,other',
            'message' => 'required|string|min:10|max:5000',
            'consent' => 'required|accepted',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', 
        ], [
            'address.required' => 'Адресат обращения обязателен для заполнения',
            'email.required' => 'E-mail обязателен для заполнения',
            'email.email' => 'Введите корректный E-mail',
            'full_name.required' => 'ФИО обязательно для заполнения',
            'type.required' => 'Выберите тип обращения',
            'message.required' => 'Сообщение обязательно для заполнения',
            'message.min' => 'Сообщение должно содержать не менее 10 символов',
            'consent.required' => 'Вы должны согласиться с условиями',
            'consent.accepted' => 'Вы должны согласиться с условиями',
            'file.mimes' => 'Файл должен быть в формате: pdf, doc, docx, jpg, jpeg, png',
            'file.max' => 'Размер файла не должен превышать 5MB',
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


        $textFields = ['full_name', 'message', 'address'];
        foreach ($textFields as $field) {
            $spamCheck = SpamDetectionService::detectSpam($request->input($field, ''));
            if ($spamCheck['is_spam']) {
                Log::warning('Spam detected in appeal form', [
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


        if ($request->filled('phone') && !SpamDetectionService::isValidPhone($request->phone)) {
            return response()->json([
                'success' => false,
                'errors' => ['phone' => ['Введите корректный номер телефона']]
            ], 422);
        }

        $data = [
            'full_name' => SpamDetectionService::sanitize($request->full_name),
            'email' => $request->email,
            'phone' => $request->phone ? preg_replace('/[^\d+]/', '', $request->phone) : null,
            'category' => $request->type === 'complaint' ? 'Жалоба' : 'Другое',
            'subject' => SpamDetectionService::sanitize($request->address),
            'message' => SpamDetectionService::sanitize($request->message),
            'status' => 'new',
        ];


        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('appeals', $fileName, 'public');
            $data['file_path'] = $filePath;
        }

        try {
            $appeal = Appeal::create($data);

            Log::info('Appeal form submitted successfully', [
                'appeal_id' => $appeal->id,
                'email' => $request->email,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ваше обращение успешно отправлено! Мы свяжемся с вами в ближайшее время.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating appeal', [
                'error' => $e->getMessage(),
                'email' => $request->email,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при сохранении обращения. Попробуйте позже.'
            ], 500);
        }
    }
}