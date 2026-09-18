<?php

namespace App\Http\Controllers;

use App\Models\GovernmentService;
use Illuminate\Http\Request;

class ExpertiseController extends Controller
{
    public function index()
    {

        $services = GovernmentService::with(['documents' => function($query) {
                $query->where('is_visible', true)->orderBy('order');
            }])
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->each(function ($service) {

                $service->documents_count = $service->documents->count();
            });


        if ($services->isEmpty()) {
            $services = collect([
                (object)[
                    'id' => 1,
                    'title' => 'Предоставление общежития обучающимся в колледже',
                    'description' => 'Услуга по предоставлению места в общежитии для иногородних студентов...',
                    'execution_time' => '15 рабочих дней',
                    'responsible_department' => 'Деканат',
                    'documents_count' => 3,
                    'hasApplicationForm' => function() { return true; },
                    'application_form_url' => '#',
                    'visibleDocuments' => collect(),
                    'required_documents' => 'Паспорт, заявление, медицинская справка',
                ],
                (object)[
                    'id' => 2,
                    'title' => 'Прием документов в приемную комиссию',
                    'description' => 'Организация приема документов от абитуриентов...',
                    'execution_time' => '10 рабочих дней',
                    'responsible_department' => 'Приемная комиссия',
                    'documents_count' => 2,
                    'hasApplicationForm' => function() { return true; },
                    'application_form_url' => '#',
                    'visibleDocuments' => collect(),
                    'required_documents' => 'Аттестат, паспорт, фото',
                ],
                (object)[
                    'id' => 3,
                    'title' => 'Предоставление бесплатного и льготного питания',
                    'description' => 'Организация питания для студентов из социально незащищенных слоев населения...',
                    'execution_time' => '5 рабочих дней',
                    'responsible_department' => 'Деканат',
                    'documents_count' => 1,
                    'hasApplicationForm' => function() { return false; },
                    'application_form_url' => null,
                    'visibleDocuments' => collect(),
                    'required_documents' => 'Документ о льготах, заявление',
                ],
            ]);
        }

        return view('expertise.index', compact('services'));
    }
}