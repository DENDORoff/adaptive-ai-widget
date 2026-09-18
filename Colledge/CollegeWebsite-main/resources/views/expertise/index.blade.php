@extends('layouts.app')

@section('title', 'Государственные услуги')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<section class="relative overflow-visible bg-gradient-to-b from-gray-900 to-black pt-24">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-blue-800/20"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600 rounded-full filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="absolute inset-0 opacity-10 overflow-hidden">
        <div class="grid-animation"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 py-12 overflow-visible">
        <div class="max-w-7xl mx-auto overflow-visible">
            {{-- HERO SECTION --}}
            <div class="text-center mb-16" data-animate>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    {{ \App\Models\PageSection::getValue('government_services', 'hero', 'main_title_line1', 'Государственные') }}
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-blue-500 to-cyan-500">
                        {{ \App\Models\PageSection::getValue('government_services', 'hero', 'main_title_line2', 'услуги') }}
                    </span>
                </h1>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-6" data-animate data-delay="100"></div>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto" data-animate data-delay="200">
                    {{ \App\Models\PageSection::getValue('government_services', 'hero', 'description', 'Полный перечень государственных услуг, предоставляемых колледжем') }}
                </p>
            </div>

            {{-- SERVICES GRID --}}
            <div class="services-grid mb-24">
                @forelse($services as $index => $service)
                <div class="service-card" data-service="{{ $index + 1 }}" data-animate data-delay="{{ $index * 50 }}">
                    <div class="service-card-inner">
                        <div class="service-number">{{ $index + 1 }}</div>
                        <h3 class="service-title">{{ $service->getTranslatedTitle() }}</h3>
                        <div class="service-footer">
                            <div class="service-meta">
                                @if($service->application_form_path)
                                <div class="application-form-badge">
                                    <i class="fas fa-file-pdf mr-1"></i>
                                    {{ \App\Models\PageSection::getValue('government_services', 'modal_labels', 'form_badge', 'Есть бланк') }}
                                </div>
                                @endif
                                @if($service->documents_count > 0)
                                <div class="documents-badge">
                                    <i class="fas fa-file-alt mr-1"></i>
                                    {{ $service->documents_count }} 
                                    @if($service->documents_count == 1)
                                        {{ \App\Models\PageSection::getValue('government_services', 'badge_labels', 'document_label', 'документ') }}
                                    @elseif($service->documents_count >= 2 && $service->documents_count <= 4)
                                        {{ \App\Models\PageSection::getValue('government_services', 'badge_labels', 'document_label_2_4', 'документа') }}
                                    @else
                                        {{ \App\Models\PageSection::getValue('government_services', 'badge_labels', 'document_label_5_plus', 'документов') }}
                                    @endif
                                </div>
                                @endif
                            </div>
                            <div class="click-indicator">
                                <span>{{ \App\Models\PageSection::getValue('government_services', 'modal_labels', 'more_info_btn', 'Подробнее') }}</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                {{-- EMPTY STATE --}}
                <div class="col-span-full text-center py-12" data-animate>
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-file-alt text-5xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">
                            {{ \App\Models\PageSection::getValue('government_services', 'empty_state', 'title', 'Услуги не найдены') }}
                        </h3>
                        <p>
                            {{ \App\Models\PageSection::getValue('government_services', 'empty_state', 'description', 'Информация о государственных услугах скоро будет добавлена') }}
                        </p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- MODALS FOR EACH SERVICE --}}
@foreach($services as $index => $service)
<div id="modal-{{ $index + 1 }}" class="service-modal fixed inset-0 z-[9999] hidden transition-all duration-300">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-md transition-opacity duration-300"></div>
    
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="service-modal-card">
            <div class="service-modal-header">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="service-modal-number">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="service-modal-title">{{ $service->getTranslatedTitle() }}</h3>
                        </div>
                    </div>
                    <button type="button" class="service-modal-close" title="{{ \App\Models\PageSection::getValue('government_services', 'button_labels', 'close_btn', 'Закрыть') }}">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="service-modal-body">
                @if($service->getTranslatedDescription())
                <div class="mb-8">
                    <h4 class="section-title mb-4">
                        <i class="fas fa-align-left mr-3"></i>
                        {{ \App\Models\PageSection::getValue('government_services', 'modal_labels', 'description_title', 'Описание услуги') }}
                    </h4>
                    <div class="service-modal-description">
                        {{ $service->getTranslatedDescription() }}
                    </div>
                </div>
                @endif

                <div class="service-features-grid mb-8">
                    {{-- Execution Time --}}
                    <div class="service-feature-card">
                        <div class="flex items-start space-x-4">
                            <div class="service-feature-icon">
                                <i class="fas fa-clock text-blue-400 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="service-feature-title">
                                    {{ \App\Models\PageSection::getValue('government_services', 'modal_labels', 'execution_time_title', 'Срок выполнения') }}
                                </h4>
                                <p class="service-feature-text">
                                    {{ $service->getTranslatedExecutionTime() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Responsible Department --}}
                    <div class="service-feature-card">
                        <div class="flex items-start space-x-4">
                            <div class="service-feature-icon">
                                <i class="fas fa-user-check text-blue-400 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="service-feature-title">
                                    {{ \App\Models\PageSection::getValue('government_services', 'modal_labels', 'responsible_department_title', 'Ответственный отдел') }}
                                </h4>
                                <p class="service-feature-text">
                                    {{ $service->getTranslatedResponsibleDepartment() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Documents Count --}}
                    <div class="service-feature-card">
                        <div class="flex items-start space-x-4">
                            <div class="service-feature-icon">
                                <i class="fas fa-file-alt text-blue-400 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="service-feature-title">
                                    {{ \App\Models\PageSection::getValue('government_services', 'modal_labels', 'documents_count_title', 'Документов') }}
                                </h4>
                                <p class="service-feature-text">
                                    {{ $service->documents->where('is_visible', true)->count() }} 
                                    {{ \App\Models\PageSection::getValue('government_services', 'badge_labels', 'files_label', 'файлов') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Required Documents --}}
                @if($service->getTranslatedRequiredDocuments())
                <div class="mb-8">
                    <h4 class="section-title mb-4">
                        <i class="fas fa-list-check mr-3"></i>
                        {{ \App\Models\PageSection::getValue('government_services', 'modal_labels', 'required_documents_title', 'Необходимые документы') }}
                    </h4>
                    <div class="documents-list">
                        @foreach($service->getTranslatedRequiredDocumentsList() as $doc)
                        <div class="document-item">
                            <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                            <span>{{ $doc }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Downloadable Documents --}}
                @if($service->documents->where('is_visible', true)->count() > 0)
                <div class="mb-8">
                    <h4 class="section-title mb-4">
                        <i class="fas fa-folder-open mr-3"></i>
                        {{ \App\Models\PageSection::getValue('government_services', 'modal_labels', 'download_documents_title', 'Документы для скачивания') }}
                    </h4>
                    <div class="documents-grid">
                        @foreach($service->documents->where('is_visible', true)->sortBy('order') as $document)
                        <div class="download-document-card">
                            <div class="document-info">
                                <div class="flex items-start space-x-3">
                                    <div class="document-type-badge">
                                        <i class="fas fa-file-pdf text-red-400"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="document-name">{{ $document->name }}</h5>
                                        <div class="document-meta">
                                            <span class="document-type">
                                                @switch($document->document_type)
                                                    @case('info')
                                                        {{ \App\Models\PageSection::getValue('government_services', 'document_types', 'info_document', 'Информационный документ') }}
                                                    @break
                                                    @case('form')
                                                        {{ \App\Models\PageSection::getValue('government_services', 'document_types', 'form_document', 'Форма/Бланк') }}
                                                    @break
                                                    @case('regulation')
                                                        {{ \App\Models\PageSection::getValue('government_services', 'document_types', 'regulation_document', 'Регламент') }}
                                                    @break
                                                    @case('instruction')
                                                        {{ \App\Models\PageSection::getValue('government_services', 'document_types', 'instruction_document', 'Инструкция') }}
                                                    @break
                                                    @default
                                                        {{ \App\Models\PageSection::getValue('government_services', 'document_types', 'default_document', 'Документ') }}
                                                @endswitch
                                            </span>
                                            @if($document->file_path)
                                            @php
                                                $filePath = storage_path('app/' . $document->file_path);
                                                $size = 0;
                                                if (file_exists($filePath)) {
                                                    $size = filesize($filePath);
                                                    $size = $size > 0 ? number_format($size / 1048576, 2) : 0;
                                                }
                                            @endphp
                                            @if($size > 0)
                                            <span class="document-size">
                                                <i class="fas fa-database mr-1"></i>
                                                {{ $size }} МБ
                                            </span>
                                            @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($document->file_path)
                            <a href="{{ Storage::disk('public_files')->url($document->file_path) }}" 
                               download="{{ Illuminate\Support\Str::slug($document->name) }}.pdf" 
                               class="download-action-btn">
                                <i class="fas fa-download mr-2"></i>
                                {{ \App\Models\PageSection::getValue('government_services', 'modal_labels', 'download_btn', 'Скачать') }}
                            </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="service-modal-buttons">
                    @if($service->application_form_path)
                    <a href="{{ Storage::disk('public_files')->url($service->application_form_path) }}" 
                       download="{{ Illuminate\Support\Str::slug($service->getTranslatedTitle()) }}-blank.pdf" 
                       class="service-primary-btn">
                        <i class="fas fa-download mr-3"></i>
                        {{ \App\Models\PageSection::getValue('government_services', 'modal_labels', 'download_form_btn', 'Скачать бланк заявления') }}
                    </a>
                    @endif
                    <button class="service-secondary-btn contact-btn" data-service-title="{{ $service->getTranslatedTitle() }}">
                        <i class="fas fa-question-circle mr-3"></i>
                        {{ \App\Models\PageSection::getValue('government_services', 'modal_labels', 'ask_question_btn', 'Задать вопрос') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- CSS STYLES --}}
<style>
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 24px;
        margin-top: 20px;
    }

    .service-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 16px;
        padding: 24px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-8px);
        border-color: rgba(59, 130, 246, 0.4);
        box-shadow: 0 20px 40px rgba(59, 130, 246, 0.15);
    }

    .service-card:hover::before {
        transform: scaleX(1);
    }

    .service-card-inner {
        position: relative;
        z-index: 1;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .service-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 18px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        flex-shrink: 0;
    }

    .service-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin-bottom: 20px;
        line-height: 1.5;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .service-footer {
        border-top: 1px solid rgba(59, 130, 246, 0.1);
        padding-top: 16px;
        margin-top: auto;
    }

    .service-meta {
        display: flex;
        gap: 10px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .application-form-badge,
    .documents-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .application-form-badge {
        background: rgba(239, 68, 68, 0.1);
        color: #fca5a5;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .documents-badge {
        background: rgba(59, 130, 246, 0.1);
        color: #93c5fd;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .click-indicator {
        color: #60a5fa;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: color 0.3s ease;
    }

    .service-card:hover .click-indicator {
        color: #93c5fd;
    }

    .service-card:hover .click-indicator i {
        transform: translateX(4px);
    }

    .click-indicator i {
        transition: transform 0.3s ease;
    }

    [data-animate] {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.4s ease, transform 0.4s ease;
    }

    [data-animate].animated {
        opacity: 1;
        transform: translateY(0);
    }

    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(15px, -30px) scale(1.05); }
        50% { transform: translate(-15px, 15px) scale(0.95); }
        75% { transform: translate(30px, 30px) scale(1.03); }
    }

    .animate-blob {
        animation: blob 8s infinite ease-in-out;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .animation-delay-4000 {
        animation-delay: 4s;
    }

    .grid-animation {
        background-image: 
            linear-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        width: 100%;
        height: 100%;
        animation: gridMove 20s linear infinite;
    }

    @keyframes gridMove {
        0% {
            transform: translateY(0) translateX(0);
        }
        100% {
            transform: translateY(50px) translateX(50px);
        }
    }

    .service-modal {
        opacity: 0;
        pointer-events: none;
        z-index: 9999 !important;
    }

    .service-modal.active {
        opacity: 1;
        pointer-events: auto;
        display: block !important;
    }

    .service-modal-card {
        background: rgba(30, 41, 59, 0.95);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 20px;
        width: 100%;
        max-width: 900px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        backdrop-filter: blur(20px);
        transform: translateY(20px) scale(0.98);
        opacity: 0;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease;
        box-shadow: 
            0 25px 50px -12px rgba(0, 0, 0, 0.5),
            0 0 100px rgba(59, 130, 246, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .service-modal.active .service-modal-card {
        transform: translateY(0) scale(1);
        opacity: 1;
    }

    .service-modal-header {
        background: rgba(15, 23, 42, 0.9);
        border-bottom: 1px solid rgba(59, 130, 246, 0.2);
        padding: 28px 32px;
        border-radius: 20px 20px 0 0;
        position: sticky;
        top: 0;
        z-index: 10;
        backdrop-filter: blur(10px);
    }

    .service-modal-number {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: white;
        width: 56px;
        height: 56px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 24px;
        flex-shrink: 0;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .service-modal-title {
        font-size: 24px;
        font-weight: 600;
        color: white;
        line-height: 1.4;
        margin-top: 8px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .service-modal-close {
        color: #94a3b8;
        background: rgba(30, 41, 59, 0.8);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        padding: 12px;
        transition: all 0.3s ease;
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 20px;
    }

    .service-modal-close:hover {
        color: white;
        background: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
        transform: rotate(90deg);
    }

    .service-modal-body {
        padding: 32px;
    }

    .service-modal-description {
        color: #cbd5e1;
        font-size: 17px;
        line-height: 1.7;
        padding: 20px;
        background: rgba(15, 23, 42, 0.5);
        border-radius: 12px;
        border: 1px solid rgba(59, 130, 246, 0.1);
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
    }

    .documents-list {
        background: rgba(15, 23, 42, 0.5);
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 12px;
        padding: 20px;
    }

    .document-item {
        display: flex;
        align-items: flex-start;
        color: #cbd5e1;
        margin-bottom: 10px;
        padding: 8px 0;
        border-bottom: 1px solid rgba(59, 130, 246, 0.05);
        line-height: 1.5;
    }

    .document-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .documents-grid {
        display: grid;
        gap: 12px;
        margin-bottom: 20px;
    }

    .download-document-card {
        background: rgba(15, 23, 42, 0.5);
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        transition: all 0.3s ease;
        gap: 16px;
    }

    @media (min-width: 768px) {
        .download-document-card {
            align-items: center;
        }
    }

    .download-document-card:hover {
        border-color: rgba(59, 130, 246, 0.3);
        background: rgba(15, 23, 42, 0.7);
    }

    .document-info {
        flex: 1;
        min-width: 0;
    }

    .document-type-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 1px solid rgba(239, 68, 68, 0.3);
        background: rgba(239, 68, 68, 0.1);
        flex-shrink: 0;
        margin-top: 2px;
    }

    .document-name {
        font-size: 15px;
        font-weight: 500;
        color: white;
        margin-bottom: 4px;
        line-height: 1.4;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .document-meta {
        display: flex;
        gap: 16px;
        font-size: 13px;
        color: #94a3b8;
        flex-wrap: wrap;
    }

    .download-action-btn {
        background: rgba(34, 197, 94, 0.1);
        color: #86efac;
        border: 1px solid rgba(34, 197, 94, 0.3);
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
        white-space: nowrap;
    }

    .download-action-btn:hover {
        background: rgba(34, 197, 94, 0.2);
        border-color: rgba(34, 197, 94, 0.5);
        color: #bbf7d0;
    }

    .service-features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .service-feature-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 16px;
        padding: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }

    .service-feature-card:hover {
        transform: translateY(-4px);
        border-color: rgba(59, 130, 246, 0.4);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
    }

    .service-feature-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(59, 130, 246, 0.1);
        width: 48px;
        height: 48px;
        border-radius: 12px;
        flex-shrink: 0;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .service-feature-title {
        font-size: 14px;
        font-weight: 600;
        color: #60a5fa;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }

    .service-feature-text {
        color: #e2e8f0;
        font-size: 16px;
        line-height: 1.5;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .service-modal-buttons {
        display: flex;
        gap: 16px;
        margin-top: 32px;
    }

    .service-primary-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 18px 24px;
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: white;
        font-weight: 600;
        font-size: 16px;
        border-radius: 14px;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        text-align: center;
        min-height: 56px;
    }

    .service-primary-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.7s ease;
    }

    .service-primary-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(59, 130, 246, 0.3);
    }

    .service-primary-btn:hover::before {
        left: 100%;
    }

    .service-secondary-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 18px 24px;
        background: rgba(30, 41, 59, 0.8);
        color: #22d3ee;
        font-weight: 600;
        font-size: 16px;
        border-radius: 14px;
        border: 1px solid rgba(34, 211, 238, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        backdrop-filter: blur(10px);
        text-align: center;
        min-height: 56px;
    }

    .service-secondary-btn:hover {
        transform: translateY(-2px);
        border-color: rgba(34, 211, 238, 0.5);
        background: rgba(30, 41, 59, 0.9);
        box-shadow: 0 8px 25px rgba(34, 211, 238, 0.15);
    }

    @keyframes modalAppear {
        from {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .service-modal.active .service-modal-card {
        animation: modalAppear 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    @media (max-width: 768px) {
        .services-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .service-title {
            min-height: auto;
            font-size: 17px;
            -webkit-line-clamp: 3;
        }

        .service-modal-card {
            max-width: 95%;
            margin: 20px;
        }

        .service-modal-header {
            padding: 20px 24px;
        }

        .service-modal-body {
            padding: 24px;
        }

        .service-modal-title {
            font-size: 20px;
        }

        .service-modal-number {
            width: 48px;
            height: 48px;
            font-size: 20px;
        }

        .service-modal-description {
            font-size: 16px;
            padding: 16px;
        }

        .service-features-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .service-modal-buttons {
            flex-direction: column;
        }

        .service-primary-btn,
        .service-secondary-btn {
            padding: 16px 20px;
            font-size: 15px;
        }

        .download-document-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .download-action-btn {
            align-self: flex-start;
        }
    }

    @media (max-width: 480px) {
        .service-card {
            padding: 20px;
        }

        .service-modal-header {
            padding: 16px 20px;
        }

        .service-modal-body {
            padding: 20px;
        }

        .service-modal-title {
            font-size: 18px;
        }

        .service-modal-description {
            font-size: 15px;
            padding: 14px;
        }

        .service-modal-close {
            width: 44px;
            height: 44px;
            font-size: 18px;
        }

        .service-title {
            -webkit-line-clamp: 2;
        }
    }
</style>

{{-- JavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceCards = document.querySelectorAll('.service-card');
        const closeButtons = document.querySelectorAll('.service-modal-close');
        const contactButtons = document.querySelectorAll('.contact-btn');
        
        const animateOnScroll = () => {
            document.querySelectorAll('[data-animate]').forEach(element => {
                const rect = element.getBoundingClientRect();
                if (rect.top < window.innerHeight * 0.9 && rect.bottom > 0) {
                    const delay = element.getAttribute('data-delay') || 0;
                    setTimeout(() => element.classList.add('animated'), parseInt(delay));
                }
            });
        };
        
        serviceCards.forEach(card => {
            card.addEventListener('click', function() {
                const serviceId = this.getAttribute('data-service');
                const modal = document.getElementById(`modal-${serviceId}`);
                
                if (modal) {
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    document.body.style.paddingRight = window.innerWidth - document.documentElement.clientWidth + 'px';
                }
            });
        });
        
        contactButtons.forEach(button => {
            button.addEventListener('click', function() {
                const serviceTitle = this.getAttribute('data-service-title');
                const email = 'info@college.kz';
                const subject = encodeURIComponent(`Вопрос по государственной услуге: ${serviceTitle}`);
                window.location.href = `mailto:${email}?subject=${subject}`;
            });
        });
        
        function closeModal() {
            const modals = document.querySelectorAll('.service-modal.active');
            modals.forEach(modal => {
                modal.classList.remove('active');
            });
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }
        
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modal = this.closest('.service-modal');
                if (modal) {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                }
            });
        });
        
        document.querySelectorAll('.service-modal').forEach(modal => {
            modal.addEventListener('click', function(event) {
                if (event.target === this || event.target.classList.contains('bg-black/80')) {
                    closeModal();
                }
            });
        });
        
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
        
        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll();
        
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.body.style.paddingRight = '';
            }
        });
    });
</script>
@endsection