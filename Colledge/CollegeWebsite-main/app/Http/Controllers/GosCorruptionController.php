<?php

namespace App\Http\Controllers;

use App\Models\AnticorruptionDocument;
use Illuminate\Support\Facades\File;

class GosCorruptionController extends Controller
{
    public function index()
    {
        $title = 'Противодействие коррупции';


        $posters = [
            [
                'id' => 1,
                'title' => 'Неприятие коррупции',
                'image_path' => 'images/gos/poster1.jpg',
                'icon' => 'fas fa-shield-alt',
                'icon_color' => 'text-red-500'
            ],
            [
                'id' => 2,
                'title' => 'Противодействие коррупции',
                'image_path' => 'images/gos/poster2.jpg',
                'icon' => 'fas fa-balance-scale',
                'icon_color' => 'text-blue-500'
            ],
            [
                'id' => 3,
                'title' => 'Борьба с коррупцией',
                'image_path' => 'images/gos/poster3.jpg',
                'icon' => 'fas fa-gavel',
                'icon_color' => 'text-yellow-500'
            ],
            [
                'id' => 3,
                'title' => 'Борьба с коррупцией',
                'image_path' => 'images/gos/poster4.jpg',
                'icon' => 'fas fa-gavel',
                'icon_color' => 'text-yellow-500'
            ],
            [
                'id' => 3,
                'title' => 'Борьба с коррупцией',
                'image_path' => 'images/gos/poster5.jpg',
                'icon' => 'fas fa-gavel',
                'icon_color' => 'text-yellow-500'
            ],
        ];


        $imagePaths = [];
        foreach ($posters as $poster) {
            $fullPath = public_path($poster['image_path']);
            $imagePaths[$poster['id']] = File::exists($fullPath);
        }


        $documents = AnticorruptionDocument::published()
            ->ofType('document')
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get()
            ->map(function($doc) {
                return [
                    'title' => $doc->title,
                    'description' => $doc->description ?? 'Нет описания',
                    'date' => $doc->document_date ? $doc->document_date->format('d.m.Y') : $doc->created_at->format('d.m.Y'),
                    'type' => $doc->type_name,
                    'type_icon' => $doc->category_icon,
                    'type_color' => $doc->category_color,
                    'url' => route('anticorruption.show', $doc->slug),
                ];
            })
            ->toArray();


        $information = AnticorruptionDocument::published()
            ->ofType('information')
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get()
            ->map(function($doc) {
                return [
                    'title' => $doc->title,
                    'description' => $doc->description ?? 'Нет описания',
                    'date' => $doc->document_date ? $doc->document_date->format('d.m.Y') : $doc->created_at->format('d.m.Y'),
                    'type' => $doc->type_name,
                    'type_icon' => $doc->category_icon,
                    'type_color' => $doc->category_color,
                    'url' => route('anticorruption.show', $doc->slug),
                ];
            })
            ->toArray();

        return view('goscorruption.index', compact(
            'title',
            'posters',
            'imagePaths',
            'documents',
            'information'
        ));
    }
}