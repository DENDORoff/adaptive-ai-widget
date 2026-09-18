<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use App\Services\SpamDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BugReportController extends Controller
{

    public function store(Request $request)
    {

        $data = $request->all();
        unset($data['website_url']);
        unset($data['confirm_bot']);
        
        $validator = Validator::make($data, [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'page_url' => 'nullable|url|max:500',
            'title' => 'required|string|max:255|min:5',
            'description' => 'required|string|min:20|max:5000',
            'steps_to_reproduce' => 'nullable|array',
            'steps_to_reproduce.*' => 'string|max:500',
            'expected_result' => 'nullable|string|max:1000',
            'actual_result' => 'nullable|string|max:1000',
            'priority' => 'nullable|in:low,medium,high,critical',
        ], [
            'full_name.required' => 'ФИО обязательно для заполнения',
            'email.required' => 'E-mail обязателен для заполнения',
            'email.email' => 'Введите корректный E-mail',
            'title.required' => 'Заголовок ошибки обязателен для заполнения',
            'title.min' => 'Заголовок должен содержать не менее 5 символов',
            'description.required' => 'Описание ошибки обязательно для заполнения',
            'description.min' => 'Описание должно содержать не менее 20 символов',
            'page_url.url' => 'Введите корректный URL страницы',
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


        $textFields = ['full_name', 'title', 'description', 'expected_result', 'actual_result'];
        foreach ($textFields as $field) {
            if (!$request->filled($field)) {
                continue;
            }

            $spamCheck = SpamDetectionService::detectSpam($request->input($field));
            if ($spamCheck['is_spam']) {
                Log::warning('Spam detected in bug report form', [
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

        try {

            $userAgent = $request->header('User-Agent') ?? '';
            $browser = $this->getBrowser($userAgent);
            $os = $this->getOperatingSystem($userAgent);
            $device = $this->getDeviceType($userAgent);


            $steps = [];
            if ($request->has('steps_to_reproduce') && is_array($request->steps_to_reproduce)) {
                foreach ($request->steps_to_reproduce as $step) {
                    if (!empty(trim($step))) {
                        $spamCheck = SpamDetectionService::detectSpam($step);
                        if ($spamCheck['is_spam']) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Один из шагов содержит недопустимый контент'
                            ], 422);
                        }
                        $steps[] = SpamDetectionService::sanitize($step);
                    }
                }
            }

            $data = [
                'user_id' => Auth::id(),
                'full_name' => SpamDetectionService::sanitize($request->full_name),
                'email' => $request->email,
                'phone' => $request->filled('phone') ? preg_replace('/[^\d+]/', '', $request->phone) : null,
                'page_url' => $request->page_url,
                'browser' => $browser,
                'os' => $os,
                'device' => $device,
                'title' => SpamDetectionService::sanitize($request->title),
                'description' => SpamDetectionService::sanitize($request->description),
                'steps_to_reproduce' => !empty($steps) ? $steps : null,
                'expected_result' => $request->filled('expected_result') 
                    ? SpamDetectionService::sanitize($request->expected_result)
                    : null,
                'actual_result' => $request->filled('actual_result') 
                    ? SpamDetectionService::sanitize($request->actual_result)
                    : null,
                'priority' => $request->priority ?? 'medium',
                'status' => 'new',
            ];

            $bugReport = BugReport::create($data);

            Log::info('Bug report submitted successfully', [
                'bug_report_id' => $bugReport->id,
                'email' => $request->email,
                'priority' => $data['priority'],
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Спасибо за ваш отчет! Мы рассмотрим его в ближайшее время.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating bug report', [
                'error' => $e->getMessage(),
                'email' => $request->email,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при сохранении отчета. Попробуйте позже.'
            ], 500);
        }
    }


    private function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'Edge') !== false) return 'Edge';
        if (strpos($userAgent, 'Opera') !== false) return 'Opera';
        return 'Неизвестный';
    }


    private function getOperatingSystem($userAgent)
    {
        if (strpos($userAgent, 'Windows') !== false) return 'Windows';
        if (strpos($userAgent, 'Mac OS') !== false) return 'macOS';
        if (strpos($userAgent, 'Linux') !== false) return 'Linux';
        if (strpos($userAgent, 'Android') !== false) return 'Android';
        if (strpos($userAgent, 'iOS') !== false) return 'iOS';
        return 'Неизвестная';
    }


    private function getDeviceType($userAgent)
    {
        if (strpos($userAgent, 'Mobile') !== false) return 'mobile';
        if (strpos($userAgent, 'Tablet') !== false) return 'tablet';
        return 'desktop';
    }
}