<?php

namespace App\Http\Controllers;

use App\Models\CouncilDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class CouncilDocumentController extends Controller
{

    public function view($id)
    {
        $document = CouncilDocument::with('council')
            ->where('is_visible', true)
            ->findOrFail($id);
        

        $path = $document->file_path;
        

        if (Storage::disk('public_files')->exists($path)) {
            $file = Storage::disk('public_files')->get($path);
            $mimeType = Storage::disk('public_files')->mimeType($path);
            
            return Response::make($file, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $this->sanitizeFilename($document->name) . '.pdf"',
            ]);
        }
        

        if (Storage::disk('public')->exists($path)) {
            $file = Storage::disk('public')->get($path);
            $mimeType = Storage::disk('public')->mimeType($path);
            
            return Response::make($file, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $this->sanitizeFilename($document->name) . '.pdf"',
            ]);
        }
        

        $fullPath = storage_path('app/public/files/' . ltrim($path, '/'));
        if (file_exists($fullPath)) {
            return response()->file($fullPath, [
                'Content-Disposition' => 'inline; filename="' . $this->sanitizeFilename($document->name) . '.pdf"',
            ]);
        }
        

        $altPath = storage_path('app/public/' . ltrim($path, '/'));
        if (file_exists($altPath)) {
            return response()->file($altPath, [
                'Content-Disposition' => 'inline; filename="' . $this->sanitizeFilename($document->name) . '.pdf"',
            ]);
        }
        
        abort(404, 'Файл не найден: ' . $path);
    }


    public function download($id)
    {
        $document = CouncilDocument::with('council')
            ->where('is_visible', true)
            ->findOrFail($id);
        
        $path = $document->file_path;
        

        if (Storage::disk('public_files')->exists($path)) {
            return Storage::disk('public_files')->download(
                $path,
                $this->sanitizeFilename($document->name) . '.pdf'
            );
        }
        

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download(
                $path,
                $this->sanitizeFilename($document->name) . '.pdf'
            );
        }
        

        $fullPath = storage_path('app/public/files/' . ltrim($path, '/'));
        if (file_exists($fullPath)) {
            return response()->download(
                $fullPath,
                $this->sanitizeFilename($document->name) . '.pdf'
            );
        }
        

        $altPath = storage_path('app/public/' . ltrim($path, '/'));
        if (file_exists($altPath)) {
            return response()->download(
                $altPath,
                $this->sanitizeFilename($document->name) . '.pdf'
            );
        }
        
        abort(404, 'Файл не найден для скачивания: ' . $path);
    }


    private function sanitizeFilename($filename)
    {
        $filename = preg_replace('/[^\p{L}\p{N}\s\-_\.]/u', '_', $filename);
        $filename = preg_replace('/\s+/', '_', $filename);
        return trim($filename, '._-');
    }
}