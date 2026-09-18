<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VacancyController extends Controller
{

    public function index()
    {
        $vacancies = Vacancy::published()
            ->orderBy('order', 'asc')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('pages.vacancies.index', compact('vacancies'));
    }


    public function show($slug): BinaryFileResponse
    {
        $vacancy = Vacancy::where('slug', $slug)
            ->published()
            ->firstOrFail();


        if (!$vacancy->pdf_file) {
            abort(404, 'PDF файл не найден');
        }


        $filePath = Storage::disk('public_files')->path($vacancy->pdf_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'PDF файл не найден на сервере');
        }


        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($vacancy->pdf_file) . '"'
        ]);
    }
}