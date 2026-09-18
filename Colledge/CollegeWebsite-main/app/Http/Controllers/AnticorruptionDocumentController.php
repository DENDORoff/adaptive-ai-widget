<?php

namespace App\Http\Controllers;

use App\Models\AnticorruptionDocument;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AnticorruptionDocumentController extends Controller
{

    public function allDocuments()
    {
        $title = __('Документы по противодействию коррупции');
        
        $documents = AnticorruptionDocument::where('is_published', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($document) {

                return [
                    'id' => $document->id,
                    'title' => $document->getTranslatedTitle(),
                    'description' => $document->getTranslatedDescription(),
                    'date' => $document->document_date ? $document->document_date->format('d.m.Y') : $document->created_at->format('d.m.Y'),
                    'type' => $this->getTypeKey($document->type), 
                    'type_icon' => $this->getTypeIcon($document->type),
                    'type_color' => $this->getTypeColor($document->type),
                    'category' => $this->getCategoryKey($document->category), 
                    'category_icon' => $this->getCategoryIcon($document->category),
                    'url' => route('anticorruption.show', ['slug' => $document->slug]),
                    'created_at' => $document->created_at->format('d.m.Y H:i'),
                    'size' => $this->getFileSize($document->pdf_file),
                    'pdf_url' => $document->pdf_url,
                    'original_type' => $this->getTypeKey($document->type),
                    'original_category' => $this->getCategoryKey($document->category),
                ];
            });
        
        $totalDocuments = $documents->count();
        $lawDocuments = 0;
        $reports = 0;
        $informationLists = 0;
        
        foreach ($documents as $doc) {
            if ($doc['original_category'] === 'нормативные документы') {
                $lawDocuments++;
            }
            if ($doc['type'] === 'отчет') {
                $reports++;
            }
            if ($doc['type'] === 'перечень сведений') {
                $informationLists++;
            }
        }
        
        return view('anticorruption.documents', compact(
            'title', 
            'documents', 
            'totalDocuments',
            'lawDocuments',
            'reports',
            'informationLists'
        ));
    }
    

    public function show($slug): BinaryFileResponse
    {
        $document = AnticorruptionDocument::where('slug', $slug)
            ->published()
            ->firstOrFail();

        if (!$document->pdf_file) {
            abort(404, __('PDF файл не найден'));
        }

        $filePath = Storage::disk('public_files')->path($document->pdf_file);
        
        if (!file_exists($filePath)) {
            abort(404, __('PDF файл не найден на сервере'));
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($document->pdf_file) . '"'
        ]);
    }
    

    private function getTypeKey($type): string
    {
        return match ($type) {
            'document' => 'приказ',
            'information' => 'перечень сведений',
            'report' => 'отчет',
            'law' => 'нормативный акт',
            'regulation' => 'положение',
            'instruction' => 'инструкция',
            'plan' => 'план',
            'certificate' => 'справка',
            'protocol' => 'протокол',
            default => 'приказ',
        };
    }
    

    private function getCategoryKey($category): string
    {
        return match ($category) {
            'law' => 'нормативные документы',
            'report' => 'отчетность',
            'info' => 'информационные материалы',
            'order' => 'организационные документы',
            'policy' => 'антикоррупционная политика',
            'plans' => 'планы и программы',
            'methodology' => 'методические материалы',
            'financial' => 'финансовые документы',
            'personnel' => 'кадровые документы',
            'other' => 'прочие документы',
            default => 'организационные документы',
        };
    }
    

    private function getTypeIcon($type): string
    {
        return match ($type) {
            'document' => 'fas fa-file-contract',
            'information' => 'fas fa-list-alt',
            'report' => 'fas fa-chart-line',
            'law' => 'fas fa-gavel',
            'regulation' => 'fas fa-book',
            'instruction' => 'fas fa-book-open',
            'plan' => 'fas fa-calendar-alt',
            'certificate' => 'fas fa-certificate',
            'protocol' => 'fas fa-clipboard-list',
            default => 'fas fa-file',
        };
    }
    

    private function getTypeColor($type): string
    {
        return match ($type) {
            'document' => 'text-blue-400',
            'information' => 'text-green-400',
            'report' => 'text-yellow-400',
            'law' => 'text-red-400',
            'regulation' => 'text-purple-400',
            'instruction' => 'text-pink-400',
            'plan' => 'text-indigo-400',
            'certificate' => 'text-orange-400',
            'protocol' => 'text-teal-400',
            default => 'text-gray-400',
        };
    }
    

    private function getCategoryIcon($category): string
    {
        return match ($category) {
            'law' => 'fas fa-gavel',
            'report' => 'fas fa-chart-line',
            'info' => 'fas fa-info-circle',
            'order' => 'fas fa-file-signature',
            'policy' => 'fas fa-shield-alt',
            'plans' => 'fas fa-calendar-alt',
            'methodology' => 'fas fa-book-open',
            'financial' => 'fas fa-money-bill-wave',
            'personnel' => 'fas fa-users',
            'other' => 'fas fa-folder',
            default => 'fas fa-file',
        };
    }
    

    private function getFileSize($filePath): string
    {
        if (Storage::disk('public_files')->exists($filePath)) {
            $size = Storage::disk('public_files')->size($filePath);
            
            if ($size >= 1048576) {
                return round($size / 1048576, 1) . ' МБ';
            } elseif ($size >= 1024) {
                return round($size / 1024, 1) . ' КБ';
            } else {
                return $size . ' Б';
            }
        }
        
        return 'Неизвестно';
    }
}