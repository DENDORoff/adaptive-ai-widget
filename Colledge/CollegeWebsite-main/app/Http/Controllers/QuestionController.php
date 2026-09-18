<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Services\SpamDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::published()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('questions.index', compact('questions'));
    }

    public function store(Request $request)
    {

        $data = $request->all();
        unset($data['website_url']);
        unset($data['confirm_bot']);
        
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'question' => 'required|string|min:10|max:1000',
        ], [
            'name.required' => 'Пожалуйста, укажите ваше имя',
            'email.required' => 'Пожалуйста, укажите ваш email',
            'email.email' => 'Пожалуйста, укажите корректный email',
            'question.required' => 'Пожалуйста, введите ваш вопрос',
            'question.min' => 'Вопрос должен содержать не менее 10 символов',
            'question.max' => 'Вопрос не должен превышать 1000 символов',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        if (!SpamDetectionService::isValidEmail($request->email)) {
            return back()
                ->withErrors(['email' => 'Введите корректный email адрес'])
                ->withInput();
        }


        $spamCheckName = SpamDetectionService::detectSpam($request->name);
        if ($spamCheckName['is_spam']) {
            Log::warning('Spam detected in question form (name)', [
                'type' => $spamCheckName['type'],
                'ip' => $request->ip(),
                'email' => $request->email,
            ]);

            return back()
                ->withErrors(['name' => 'Введённое имя содержит недопустимый контент'])
                ->withInput();
        }

        $spamCheckQuestion = SpamDetectionService::detectSpam($request->question);
        if ($spamCheckQuestion['is_spam']) {
            Log::warning('Spam detected in question form (question)', [
                'type' => $spamCheckQuestion['type'],
                'ip' => $request->ip(),
                'email' => $request->email,
            ]);

            return back()
                ->withErrors(['question' => 'Ваш вопрос содержит недопустимый контент'])
                ->withInput();
        }

        try {
            Question::create([
                'name' => SpamDetectionService::sanitize($request->name),
                'email' => $request->email,
                'question' => SpamDetectionService::sanitize($request->question),
            ]);

            Log::info('Question form submitted successfully', [
                'email' => $request->email,
                'ip' => $request->ip(),
            ]);

            return back()->with('success', 'Ваш вопрос успешно отправлен! Мы ответим в ближайшее время.');
        } catch (\Exception $e) {
            Log::error('Error creating question', [
                'error' => $e->getMessage(),
                'email' => $request->email,
            ]);

            return back()
                ->withErrors(['general' => 'Произошла ошибка при сохранении вопроса. Попробуйте позже.'])
                ->withInput();
        }
    }
}