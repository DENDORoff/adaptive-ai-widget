<?php

namespace App\Http\Controllers;

use App\Models\LaborProtectionDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaborProtectionController extends Controller
{

    public function index()
    {
        $documents = LaborProtectionDocument::published()
            ->ordered()
            ->get()
            ->map(function ($document) {
 
                return $document;
            });

        return view('labor-protection.index', [
            'documents' => $documents
        ]);
    }


    public function download(string $document)
    {
        $document = LaborProtectionDocument::where('slug', $document)
            ->where('is_published', true)
            ->firstOrFail();

        $filePath = Storage::disk('public_files')->path($document->pdf_file);

        if (!file_exists($filePath)) {
            abort(404, 'Файл не найден');
        }

        return response()->download(
            $filePath,
            $document->getTranslatedTitle() . '.pdf',
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }


    public function preview(string $document)
    {
        $document = LaborProtectionDocument::where('slug', $document)
            ->where('is_published', true)
            ->firstOrFail();

        $filePath = Storage::disk('public_files')->path($document->pdf_file);

        if (!file_exists($filePath)) {
            abort(404, 'Файл не найден');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document->getTranslatedTitle() . '.pdf"',
        ]);
    }
}