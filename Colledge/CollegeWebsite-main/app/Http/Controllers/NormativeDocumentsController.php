<?php

namespace App\Http\Controllers;

use App\Models\NormativeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NormativeDocumentsController extends Controller
{

    public function index()
    {
        $documents = NormativeDocument::published()
            ->ordered()
            ->get()
            ->map(function ($document) {

                return $document;
            });

        return view('normative.normative-documents', [
            'documents' => $documents
        ]);
    }


    public function download(string $document)
    {
        $document = NormativeDocument::where('slug', $document)
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
        $document = NormativeDocument::where('slug', $document)
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