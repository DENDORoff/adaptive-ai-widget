@extends('layouts.app')

@section('title', 'Советы при колледже')

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
            
            <div class="text-center mb-16" data-animate>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    {{ \App\Models\PageSection::getValue('councils', 'hero', 'main_title_1', 'Советы при') }}
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-blue-500 to-cyan-500">
                        {{ \App\Models\PageSection::getValue('councils', 'hero', 'main_title_2', 'колледже') }}
                    </span>
                </h1>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-6" data-animate data-delay="100"></div>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto" data-animate data-delay="200">
                    {{ \App\Models\PageSection::getValue('councils', 'hero', 'subtitle', 'Структурные подразделения колледжа, обеспечивающие развитие образовательного процесса') }}
                </p>
            </div>

            
            <div class="councils-grid mb-24">
                @forelse($councils as $index => $council)
                <div class="council-card" data-council="{{ $index + 1 }}" data-animate data-delay="{{ $index * 50 }}">
                    <div class="council-card-inner">
                        <div class="council-icon">
                            <i class="{{ $council->icon ?? 'fas fa-user-group' }} text-2xl"></i>
                        </div>
                        <h3 class="council-title">{{ $council->title ?? 'Совет' }}</h3>
                        <p class="council-description">{{ Str::limit($council->description ?? 'Описание совета', 120) }}</p>
                        <div class="council-footer">
                            <div class="documents-count">
                                <i class="fas fa-file-pdf mr-2"></i>
                                @php
                                    $docCount = $council->documents ? $council->documents->where('is_visible', true)->count() : 0;
                                @endphp
                                {{ $docCount }} {{ trans_choice('документ|документа|документов', $docCount) }}
                            </div>
                            <div class="click-indicator">
                                <span>{{ \App\Models\PageSection::getValue('councils', 'council_card', 'view_button', 'Подробнее') }}</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                
                <div class="col-span-full text-center py-12" data-animate>
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-user-group text-5xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">
                            {{ \App\Models\PageSection::getValue('councils', 'empty_state', 'title', 'Советы не найдены') }}
                        </h3>
                        <p>
                            {{ \App\Models\PageSection::getValue('councils', 'empty_state', 'message', 'Информация о советах при колледже скоро будет добавлена') }}
                        </p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>


@foreach($councils as $index => $council)
<div id="modal-{{ $index + 1 }}" class="council-modal fixed inset-0 z-[9999] hidden transition-all duration-300">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-md transition-opacity duration-300"></div>
    
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="council-modal-card">
            <div class="council-modal-header">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="council-modal-icon">
                            <i class="{{ $council->icon ?? 'fas fa-user-group' }} text-2xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="council-modal-title">{{ $council->title ?? 'Совет' }}</h3>
                            <p class="council-modal-subtitle">{{ $council->description ?? 'Описание совета' }}</p>
                        </div>
                    </div>
                    <button type="button" class="council-modal-close">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="council-modal-body">
                @if($council->documents && $council->documents->where('is_visible', true)->count() > 0)
                <div class="documents-section mb-8">
                    <h4 class="section-title">
                        <i class="fas fa-folder-open mr-3"></i>
                        {{ \App\Models\PageSection::getValue('councils', 'modal', 'documents_title', 'Документы совета') }}
                    </h4>
                    
                    <div class="documents-grid">
                        @foreach($council->documents->where('is_visible', true)->sortBy('order') as $document)
                        <div class="document-card">
                            <div class="document-header">
                                <div class="document-icon">
                                    <i class="fas fa-file-pdf text-red-400 text-xl"></i>
                                </div>
                                <div class="document-info">
                                    <h5 class="document-name">{{ $document->name ?? 'Документ' }}</h5>
                                    <div class="document-meta">
                                        @if($document->file_path)
                                        @php
                                            $size = 0;
                                            if (Storage::disk('public')->exists($document->file_path)) {
                                                $size = Storage::disk('public')->size($document->file_path);
                                                $size = $size > 0 ? round($size / 1048576, 1) : 0;
                                            }
                                        @endphp
                                        @if($size > 0)
                                        <span class="document-size">
                                            <i class="fas fa-database mr-1"></i>
                                            {{ $size }} МБ
                                        </span>
                                        @endif
                                        @endif
                                        <span class="document-format">
                                            <i class="fas fa-file-alt mr-1"></i>
                                            PDF
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if($document->file_path)
                            @php
                                $downloadName = Str::slug($document->name ?? 'document') . '.pdf';
                            @endphp
                            <div class="document-actions">
                                <a href="{{ route('council.document.view', ['id' => $document->id]) }}" 
                                   target="_blank"
                                   class="preview-btn">
                                    <i class="fas fa-eye mr-2"></i>
                                    {{ \App\Models\PageSection::getValue('councils', 'modal', 'preview_button', 'Просмотреть') }}
                                </a>
                                <a href="{{ route('council.document.download', ['id' => $document->id]) }}" 
                                   class="download-btn">
                                    <i class="fas fa-download mr-2"></i>
                                    {{ \App\Models\PageSection::getValue('councils', 'modal', 'download_button', 'Скачать') }}
                                </a>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="council-info-grid mb-8">
                    @if($council->work_period)
                    <div class="info-card">
                        <div class="flex items-start space-x-4">
                            <div class="info-icon">
                                <i class="fas fa-calendar-alt text-blue-400 text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="info-title">{{ \App\Models\PageSection::getValue('councils', 'modal', 'work_period_label', 'Период работы') }}</h4>
                                <p class="info-text">{{ $council->work_period }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($council->chairman)
                    <div class="info-card">
                        <div class="flex items-start space-x-4">
                            <div class="info-icon">
                                <i class="fas fa-user-tie text-blue-400 text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="info-title">{{ \App\Models\PageSection::getValue('councils', 'modal', 'chairman_label', 'Председатель') }}</h4>
                                <p class="info-text">{{ $council->chairman }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($council->meeting_frequency)
                    <div class="info-card">
                        <div class="flex items-start space-x-4">
                            <div class="info-icon">
                                <i class="fas fa-clock text-blue-400 text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="info-title">{{ \App\Models\PageSection::getValue('councils', 'modal', 'meetings_label', 'Заседания') }}</h4>
                                <p class="info-text">{{ $council->meeting_frequency }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($council->contact_email)
                    <div class="info-card">
                        <div class="flex items-start space-x-4">
                            <div class="info-icon">
                                <i class="fas fa-envelope text-blue-400 text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="info-title">{{ \App\Models\PageSection::getValue('councils', 'modal', 'email_label', 'Email для связи') }}</h4>
                                <p class="info-text">{{ $council->contact_email }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                @if($council->contact_email)
                <div class="council-modal-buttons">
                    <a href="mailto:{{ $council->contact_email }}?subject={{ urlencode('Вопрос по совету: ' . ($council->title ?? 'Совет')) }}" class="council-contact-btn">
                        <i class="fas fa-envelope mr-3"></i>
                        {{ \App\Models\PageSection::getValue('councils', 'modal', 'contact_button', 'Связаться с советом') }}
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach


<div id="pdf-modal" class="pdf-viewer-modal fixed inset-0 z-[10000] hidden transition-all duration-300">
    <div class="absolute inset-0 bg-black/90 backdrop-blur-md transition-opacity duration-300"></div>
    
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="pdf-viewer-card">
            <div class="pdf-viewer-header">
                <div class="flex items-center justify-between">
                    <h3 class="pdf-viewer-title">
                        <i class="fas fa-file-pdf mr-3 text-red-400"></i>
                        <span id="pdf-document-name">
                            {{ \App\Models\PageSection::getValue('councils', 'pdf_viewer', 'title', 'Просмотр документа') }}
                        </span>
                    </h3>
                    <button type="button" class="pdf-viewer-close">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="pdf-viewer-body">
                <div class="pdf-container">
                    <iframe id="pdf-frame" class="pdf-frame" src="" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="pdf-controls">
                    <button class="pdf-control-btn" onclick="changePdfZoom(0.8)" title="{{ \App\Models\PageSection::getValue('councils', 'pdf_viewer', 'zoom_out', 'Уменьшить') }}">
                        <i class="fas fa-search-minus"></i>
                    </button>
                    <button class="pdf-control-btn" onclick="changePdfZoom(1)" title="{{ \App\Models\PageSection::getValue('councils', 'pdf_viewer', 'normal_size', 'Нормальный размер') }}">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="pdf-control-btn" onclick="changePdfZoom(1.2)" title="{{ \App\Models\PageSection::getValue('councils', 'pdf_viewer', 'zoom_in', 'Увеличить') }}">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <a id="pdf-download-btn" href="#" download class="pdf-control-btn" title="{{ \App\Models\PageSection::getValue('councils', 'pdf_viewer', 'download', 'Скачать PDF') }}">
                        <i class="fas fa-download"></i>
                        {{ \App\Models\PageSection::getValue('councils', 'pdf_viewer', 'download_text', 'Скачать') }}
                    </a>
                    <button class="pdf-control-btn" onclick="printPdf()" title="{{ \App\Models\PageSection::getValue('councils', 'pdf_viewer', 'print', 'Печать') }}">
                        <i class="fas fa-print"></i>
                        {{ \App\Models\PageSection::getValue('councils', 'pdf_viewer', 'print_text', 'Печать') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .councils-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 24px;
        margin-top: 20px;
    }

    .council-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 16px;
        padding: 28px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        display: flex;
        flex-direction: column;
        min-height: 280px;
    }

    .council-card::before {
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

    .council-card:hover {
        transform: translateY(-8px);
        border-color: rgba(59, 130, 246, 0.4);
        box-shadow: 0 20px 40px rgba(59, 130, 246, 0.15);
    }

    .council-card:hover::before {
        transform: scaleX(1);
    }

    .council-card-inner {
        position: relative;
        z-index: 1;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .council-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: white;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        flex-shrink: 0;
    }

    .council-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin-bottom: 12px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .council-description {
        color: #cbd5e1;
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .council-footer {
        border-top: 1px solid rgba(59, 130, 246, 0.1);
        padding-top: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .documents-count {
        color: #93c5fd;
        font-size: 13px;
        font-weight: 500;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }

    .click-indicator {
        color: #60a5fa;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: color 0.3s ease;
        white-space: nowrap;
    }

    .council-card:hover .click-indicator {
        color: #93c5fd;
    }

    .council-card:hover .click-indicator i {
        transform: translateX(4px);
    }

    .click-indicator i {
        transition: transform 0.3s ease;
    }

    .council-modal {
        opacity: 0;
        pointer-events: none;
        z-index: 9999 !important;
    }

    .council-modal.active {
        opacity: 1;
        pointer-events: auto;
        display: block !important;
    }

    .council-modal-card {
        background: rgba(30, 41, 59, 0.95);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 20px;
        width: 100%;
        max-width: 1000px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        backdrop-filter: blur(20px);
        transform: translateY(20px) scale(0.98);
        opacity: 0;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 100px rgba(59, 130, 246, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .council-modal.active .council-modal-card {
        transform: translateY(0) scale(1);
        opacity: 1;
    }

    .council-modal-header {
        background: rgba(15, 23, 42, 0.9);
        border-bottom: 1px solid rgba(59, 130, 246, 0.2);
        padding: 28px 32px;
        border-radius: 20px 20px 0 0;
        position: sticky;
        top: 0;
        z-index: 10;
        backdrop-filter: blur(10px);
    }

    .council-modal-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: white;
        width: 56px;
        height: 56px;
        border-radius: 14px;
        flex-shrink: 0;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .council-modal-title {
        font-size: 22px;
        font-weight: 600;
        color: white;
        line-height: 1.4;
        margin-bottom: 6px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
        min-width: 0;
    }

    .council-modal-subtitle {
        color: #cbd5e1;
        font-size: 15px;
        line-height: 1.5;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
        min-width: 0;
    }

    .council-modal-close {
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

    .council-modal-close:hover {
        color: white;
        background: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
        transform: rotate(90deg);
    }

    .council-modal-body {
        padding: 32px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .documents-grid {
        display: grid;
        gap: 16px;
        margin-bottom: 32px;
    }

    .document-card {
        background: rgba(15, 23, 42, 0.5);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 14px;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .document-card:hover {
        border-color: rgba(59, 130, 246, 0.4);
        background: rgba(15, 23, 42, 0.7);
        transform: translateY(-2px);
    }

    .document-header {
        display: flex;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .document-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(239, 68, 68, 0.1);
        width: 48px;
        height: 48px;
        border-radius: 10px;
        margin-right: 16px;
        border: 1px solid rgba(239, 68, 68, 0.2);
        flex-shrink: 0;
    }

    .document-info {
        flex: 1;
        min-width: 0;
    }

    .document-name {
        font-size: 16px;
        font-weight: 500;
        color: white;
        margin-bottom: 6px;
        line-height: 1.4;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .document-meta {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .document-size,
    .document-format {
        color: #94a3b8;
        font-size: 13px;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }

    .document-actions {
        display: flex;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px solid rgba(59, 130, 246, 0.1);
    }

    .preview-btn {
        flex: 1;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        white-space: nowrap;
        text-decoration: none;
        border: 1px solid transparent;
        min-height: 44px;
        background: rgba(59, 130, 246, 0.1);
        color: #60a5fa;
        border-color: rgba(59, 130, 246, 0.3);
    }

    .preview-btn:hover {
        background: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.5);
        transform: translateY(-2px);
    }

    .download-btn {
        flex: 1;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        white-space: nowrap;
        text-decoration: none;
        border: 1px solid transparent;
        min-height: 44px;
        background: rgba(34, 197, 94, 0.1);
        color: #86efac;
        border-color: rgba(34, 197, 94, 0.3);
    }

    .download-btn:hover {
        background: rgba(34, 197, 94, 0.2);
        border-color: rgba(34, 197, 94, 0.5);
        transform: translateY(-2px);
    }

    .council-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .info-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        min-height: 120px;
    }

    .info-card:hover {
        border-color: rgba(59, 130, 246, 0.4);
        transform: translateY(-2px);
    }

    .info-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(59, 130, 246, 0.1);
        width: 44px;
        height: 44px;
        border-radius: 10px;
        flex-shrink: 0;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .info-title {
        font-size: 13px;
        font-weight: 600;
        color: #93c5fd;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .info-text {
        color: #e2e8f0;
        font-size: 15px;
        line-height: 1.4;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .council-modal-buttons {
        display: flex;
        gap: 16px;
    }

    .council-contact-btn {
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
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        text-align: center;
        min-height: 56px;
    }

    .council-contact-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(59, 130, 246, 0.3);
    }

    .pdf-viewer-modal {
        opacity: 0;
        pointer-events: none;
        z-index: 10000 !important;
    }

    .pdf-viewer-modal.active {
        opacity: 1;
        pointer-events: auto;
        display: block !important;
    }

    .pdf-viewer-card {
        background: rgba(30, 41, 59, 0.95);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 20px;
        width: 100%;
        max-width: 1200px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        backdrop-filter: blur(20px);
        transform: translateY(20px) scale(0.98);
        opacity: 0;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 100px rgba(59, 130, 246, 0.3);
    }

    .pdf-viewer-modal.active .pdf-viewer-card {
        transform: translateY(0) scale(1);
        opacity: 1;
    }

    .pdf-viewer-header {
        background: rgba(15, 23, 42, 0.9);
        border-bottom: 1px solid rgba(59, 130, 246, 0.2);
        padding: 20px 24px;
        border-radius: 20px 20px 0 0;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .pdf-viewer-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
        display: flex;
        align-items: center;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    .pdf-viewer-close {
        color: #94a3b8;
        background: rgba(30, 41, 59, 0.8);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 10px;
        padding: 10px;
        transition: all 0.3s ease;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 18px;
        flex-shrink: 0;
    }

    .pdf-viewer-close:hover {
        color: white;
        background: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
    }

    .pdf-viewer-body {
        padding: 0;
    }

    .pdf-container {
        height: 600px;
        padding: 20px;
        background: rgba(15, 23, 42, 0.5);
        position: relative;
        overflow: hidden;
    }

    .pdf-frame {
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 8px;
        background: white;
        transition: transform 0.3s ease;
    }

    .pdf-controls {
        display: flex;
        gap: 12px;
        padding: 16px 24px;
        background: rgba(15, 23, 42, 0.9);
        border-top: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 0 0 20px 20px;
        flex-wrap: wrap;
    }

    .pdf-control-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: rgba(30, 41, 59, 0.8);
        color: #94a3b8;
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        text-decoration: none;
    }

    .pdf-control-btn:hover {
        background: rgba(59, 130, 246, 0.1);
        color: #93c5fd;
        border-color: rgba(59, 130, 246, 0.4);
    }

    /* Анимации */
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

    /* Адаптивность */
    @media (max-width: 768px) {
        .councils-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .council-card {
            padding: 24px;
            min-height: 260px;
        }

        .council-modal-card {
            max-width: 95%;
            margin: 20px;
        }

        .council-modal-header {
            padding: 20px 24px;
        }

        .council-modal-body {
            padding: 24px;
        }

        .council-modal-title {
            font-size: 20px;
        }

        .documents-grid {
            grid-template-columns: 1fr;
        }

        .document-actions {
            flex-direction: row;
        }

        .preview-btn,
        .download-btn {
            padding: 10px 12px;
            font-size: 13px;
        }

        .council-info-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .council-modal-buttons {
            flex-direction: column;
        }

        .council-contact-btn {
            padding: 16px 20px;
            font-size: 15px;
        }

        .pdf-viewer-card {
            max-width: 95%;
            margin: 20px;
        }

        .pdf-container {
            height: 400px;
        }

        .pdf-controls {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .council-card {
            padding: 20px;
            min-height: 240px;
        }

        .council-modal-header {
            padding: 16px 20px;
        }

        .council-modal-body {
            padding: 20px;
        }

        .council-modal-title {
            font-size: 18px;
        }

        .council-modal-icon {
            width: 48px;
            height: 48px;
            font-size: 18px;
        }

        .document-header {
            flex-direction: column;
            gap: 12px;
        }

        .document-icon {
            align-self: flex-start;
        }

        .document-actions {
            flex-direction: column;
            gap: 8px;
        }

        .preview-btn,
        .download-btn {
            padding: 12px 16px;
            font-size: 14px;
        }

        .info-card {
            flex-direction: row;
            gap: 16px;
        }

        .pdf-container {
            height: 300px;
            padding: 10px;
        }

        .pdf-control-btn {
            padding: 8px 12px;
            font-size: 12px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const councilCards = document.querySelectorAll('.council-card');
        const closeButtons = document.querySelectorAll('.council-modal-close, .pdf-viewer-close');
        const previewButtons = document.querySelectorAll('.preview-btn');
        let currentZoom = 1;
        let currentPdfUrl = '';
        
        
        const animateOnScroll = () => {
            document.querySelectorAll('[data-animate]').forEach(element => {
                const rect = element.getBoundingClientRect();
                if (rect.top < window.innerHeight * 0.9 && rect.bottom > 0) {
                    const delay = element.getAttribute('data-delay') || 0;
                    setTimeout(() => element.classList.add('animated'), parseInt(delay));
                }
            });
        };
        
        
        councilCards.forEach(card => {
            card.addEventListener('click', function() {
                const councilId = this.getAttribute('data-council');
                const modal = document.getElementById(`modal-${councilId}`);
                
                if (modal) {
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    document.body.style.paddingRight = window.innerWidth - document.documentElement.clientWidth + 'px';
                }
            });
        });
        
        
        previewButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation(); 
                
            });
        });
        
       
        function closeAllModals() {
            const councilModals = document.querySelectorAll('.council-modal.active');
            const pdfModal = document.getElementById('pdf-modal');
            
            councilModals.forEach(modal => modal.classList.remove('active'));
            if (pdfModal) {
                pdfModal.classList.remove('active');
                
                const pdfFrame = document.getElementById('pdf-frame');
                if (pdfFrame) {
                    pdfFrame.src = '';
                }
            }
            
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }
        
        
        closeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const modal = this.closest('.council-modal, .pdf-viewer-modal');
                if (modal) {
                    modal.classList.remove('active');
                    if (modal.classList.contains('pdf-viewer-modal')) {
                        const pdfFrame = document.getElementById('pdf-frame');
                        if (pdfFrame) {
                            pdfFrame.src = '';
                        }
                    }
                    
                    if (!document.querySelector('.council-modal.active, .pdf-viewer-modal.active')) {
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }
                }
            });
        });
        
        
        document.querySelectorAll('.council-modal, .pdf-viewer-modal').forEach(modal => {
            modal.addEventListener('click', function(event) {
                if (event.target === this || event.target.classList.contains('bg-black/80')) {
                    closeAllModals();
                }
            });
        });
        
        
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAllModals();
            }
        });
        
        
        window.changePdfZoom = function(zoom) {
            const pdfFrame = document.getElementById('pdf-frame');
            if (pdfFrame) {
                currentZoom = zoom;
                pdfFrame.style.transform = `scale(${zoom})`;
                pdfFrame.style.transformOrigin = 'top left';
                pdfFrame.style.width = `${100/zoom}%`;
                pdfFrame.style.height = `${100/zoom}%`;
            }
        };
        
        function resetPdfZoom() {
            const pdfFrame = document.getElementById('pdf-frame');
            if (pdfFrame) {
                currentZoom = 1;
                pdfFrame.style.transform = 'scale(1)';
                pdfFrame.style.transformOrigin = 'top left';
                pdfFrame.style.width = '100%';
                pdfFrame.style.height = '100%';
            }
        }
        
        window.printPdf = function() {
            const pdfFrame = document.getElementById('pdf-frame');
            if (pdfFrame && pdfFrame.contentWindow) {
                try {
                    pdfFrame.contentWindow.focus();
                    pdfFrame.contentWindow.print();
                } catch (e) {
                    console.error('Ошибка при печати PDF:', e);
                    
                    window.open(currentPdfUrl, '_blank');
                }
            }
        };
        
        
        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll();
        
        
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.body.style.paddingRight = '';
            }
        });
        
        
        document.querySelectorAll('iframe').forEach(iframe => {
            iframe.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    });
</script>
@endsection