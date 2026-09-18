<?php

namespace App\Http\Controllers;

use App\Models\CollegeDocument;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CollegeDocumentController extends Controller
{

    public function show($type): BinaryFileResponse
    {

        $document = CollegeDocument::active()
            ->ofType($type)
            ->orderBy('order', 'asc')
            ->firstOrFail();


        if (!$document->pdf_file) {
            abort(404, 'PDF файл не найден');
        }


        $filePath = Storage::disk('public_files')->path($document->pdf_file);
        

        if (!file_exists($filePath)) {
            abort(404, 'PDF файл не найден на сервере');
        }


        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($document->pdf_file) . '"'
        ]);
    }
}