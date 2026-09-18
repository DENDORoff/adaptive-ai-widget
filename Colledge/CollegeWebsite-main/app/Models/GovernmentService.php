<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class GovernmentService extends Model
{
    use HasFactory;

    protected $table = 'government_services';

    protected $fillable = [
        'title',
        'description',
        'execution_time',
        'responsible_department',
        'required_documents',
        'application_form_path',
        'order',
        'is_active',
        'is_multilang',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'is_multilang' => 'boolean',
    ];


    public function documents(): HasMany
    {
        return $this->hasMany(ServiceDocument::class, 'government_service_id')->orderBy('order');
    }


    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }


    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    public function hasApplicationForm(): bool
    {
        return !empty($this->application_form_path);
    }


    public function getApplicationFormUrlAttribute(): ?string
    {
        if ($this->hasApplicationForm() && \Storage::disk('public_files')->exists($this->application_form_path)) {
            return \Storage::disk('public_files')->url($this->application_form_path);
        }
        return null;
    }


    public function getDocumentsCountAttribute(): int
    {
        return $this->documents()->count();
    }


    public function visibleDocuments()
    {
        return $this->documents()->where('is_visible', true)->orderBy('order');
    }


    public function getRequiredDocumentsListAttribute(): array
    {
        $documentsText = $this->getTranslatedRequiredDocuments();
        
        if (empty($documentsText)) {
            return [];
        }
        

        $documents = preg_split('/[,;\n]+/', $documentsText);
        

        return array_map('trim', array_filter($documents));
    }


    public function getFormattedRequiredDocumentsAttribute(): string
    {
        $list = $this->getRequiredDocumentsListAttribute();
        
        if (empty($list)) {
            return '<span class="text-gray-500">Не указаны</span>';
        }
        
        $items = array_map(function($item) {
            return "<li class='mb-1'>• {$item}</li>";
        }, $list);
        
        return "<ul class='list-none pl-4'>" . implode('', $items) . "</ul>";
    }


    public function hasDocuments(): bool
    {
        return $this->documents()->count() > 0;
    }


    public function getDocumentsByType(string $type)
    {
        return $this->documents()->where('document_type', $type)->where('is_visible', true)->orderBy('order')->get();
    }


    public function getForLanguage(string $language = 'ru'): array
    {

        if (!$this->is_multilang) {
            return [
                'title' => $this->getRawOriginal('title') ?? '',
                'description' => $this->getRawOriginal('description') ?? '',
                'execution_time' => $this->getRawOriginal('execution_time') ?? '',
                'responsible_department' => $this->getRawOriginal('responsible_department') ?? '',
                'required_documents' => $this->getRawOriginal('required_documents') ?? '',
            ];
        }

        try {

            $titleData = json_decode($this->getRawOriginal('title'), true) ?? [];
            $descriptionData = json_decode($this->getRawOriginal('description'), true) ?? [];
            $executionTimeData = json_decode($this->getRawOriginal('execution_time'), true) ?? [];
            $departmentData = json_decode($this->getRawOriginal('responsible_department'), true) ?? [];
            $documentsData = json_decode($this->getRawOriginal('required_documents'), true) ?? [];
            
            return [
                'title' => $titleData[$language] ?? $titleData['ru'] ?? '',
                'description' => $descriptionData[$language] ?? $descriptionData['ru'] ?? '',
                'execution_time' => $executionTimeData[$language] ?? $executionTimeData['ru'] ?? '',
                'responsible_department' => $departmentData[$language] ?? $departmentData['ru'] ?? '',
                'required_documents' => $documentsData[$language] ?? $documentsData['ru'] ?? '',
            ];
        } catch (\Exception $e) {

            return [
                'title' => '',
                'description' => '',
                'execution_time' => '',
                'responsible_department' => '',
                'required_documents' => '',
            ];
        }
    }


    public function getTranslatedTitle(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['title'];
    }


    public function getTranslatedDescription(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['description'];
    }


    public function getTranslatedExecutionTime(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['execution_time'];
    }


    public function getTranslatedResponsibleDepartment(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['responsible_department'];
    }


    public function getTranslatedRequiredDocuments(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['required_documents'];
    }


    public function getTranslatedRequiredDocumentsList(): array
    {
        $documentsText = $this->getTranslatedRequiredDocuments();
        
        if (empty($documentsText)) {
            return [];
        }
        

        $documents = preg_split('/[,;\n]+/', $documentsText);
        

        return array_map('trim', array_filter($documents));
    }
}