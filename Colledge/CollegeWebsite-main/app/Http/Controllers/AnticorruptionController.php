<?php

namespace App\Http\Controllers;

use App\Models\AnticorruptionDocument;
use Illuminate\Http\Request;

class AnticorruptionController extends Controller
{
    public function allDocuments()
    {
        $title = 'Все документы по противодействию коррупции';
        

        $documents = AnticorruptionDocument::where('is_published', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();
        

        $groupedDocuments = $documents->groupBy('type');
        

        $transformedDocuments = [];
        foreach ($documents as $document) {
            $transformedDocuments[] = [
                'id' => $document->id,
                'title' => $document->title,
                'description' => $document->description,
                'date' => $document->document_date ? $document->document_date->format('d.m.Y') : $document->created_at->format('d.m.Y'),
                'type' => $this->getTypeLabel($document->type),
                'type_icon' => $this->getTypeIcon($document->type),
                'type_color' => $this->getTypeColor($document->type),
                'category' => $this->getCategoryLabel($document->category),
                'category_icon' => $this->getCategoryIcon($document->category),
                'url' => $document->pdf_path,
                'created_at' => $document->created_at->format('d.m.Y H:i'),
                'size' => $this->getRandomFileSize() 
            ];
        }
        
        return view('anticorruption.documents', compact('title', 'transformedDocuments', 'groupedDocuments'));
    }
    
    private function getTypeLabel($type)
    {
        return match ($type) {
            'document' => 'Документ',
            'information' => 'Перечень сведений',
            default => 'Документ',
        };
    }
    
    private function getTypeIcon($type)
    {
        return match ($type) {
            'document' => 'fas fa-file-contract',
            'information' => 'fas fa-list-alt',
            default => 'fas fa-file',
        };
    }
    
    private function getTypeColor($type)
    {
        return match ($type) {
            'document' => 'text-blue-400',
            'information' => 'text-green-400',
            default => 'text-gray-400',
        };
    }
    
    private function getCategoryLabel($category)
    {
        return match ($category) {
            'law' => 'Нормативный акт',
            'report' => 'Отчет',
            'info' => 'Информация',
            'order' => 'Распоряжение',
            default => 'Документ',
        };
    }
    
    private function getCategoryIcon($category)
    {
        return match ($category) {
            'law' => 'fas fa-gavel',
            'report' => 'fas fa-chart-line',
            'info' => 'fas fa-info-circle',
            'order' => 'fas fa-file-signature',
            default => 'fas fa-file',
        };
    }
    
    private function getRandomFileSize()
    {
        $sizes = ['2.4 МБ', '1.8 МБ', '3.2 МБ', '4.1 МБ', '5.6 МБ', '780 КБ'];
        return $sizes[array_rand($sizes)];
    }
}