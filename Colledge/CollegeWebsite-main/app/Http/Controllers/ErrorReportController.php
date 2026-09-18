<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\ErrorReportMail;

class ErrorReportController extends Controller
{
    public function create()
    {
        return view('error-report.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'error_type' => 'required|string|in:technical,content,design,other',
            'page' => 'required|string|max:500',
            'description' => 'required|string|min:10|max:2000',
            'browser' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Пожалуйста, укажите ваше имя',
            'email.required' => 'Пожалуйста, укажите ваш email',
            'email.email' => 'Пожалуйста, укажите корректный email',
            'error_type.required' => 'Пожалуйста, выберите тип ошибки',
            'page.required' => 'Пожалуйста, укажите страницу с ошибкой',
            'description.required' => 'Пожалуйста, опишите ошибку',
            'description.min' => 'Описание ошибки должно содержать не менее 10 символов',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $errorData = $validator->validated();
            

            // $errorReport = ErrorReport::create($errorData);
            

            $adminEmail = config('mail.admin_email', env('MAIL_ADMIN_ADDRESS', 'admin@example.com'));
            
            Mail::to($adminEmail)->send(new ErrorReportMail($errorData));
            

            // Mail::to($errorData['email'])->send(new ErrorReportConfirmationMail($errorData));
            
            return response()->json([
                'success' => true,
                'message' => 'Сообщение об ошибке успешно отправлено. Спасибо за вашу помощь!'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error report submission failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при отправке сообщения. Пожалуйста, попробуйте позже.'
            ], 500);
        }
    }
}