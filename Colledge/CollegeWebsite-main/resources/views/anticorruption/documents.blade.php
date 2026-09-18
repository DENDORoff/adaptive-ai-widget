@extends('layouts.app')

@section('title', \App\Models\PageSection::getValue('documents', 'metadata', 'page_title', 'Все документы по противодействию коррупции'))

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<section class="relative overflow-visible bg-gradient-to-b from-gray-900 to-black pt-24 pb-32 min-h-screen">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-blue-800/20"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600 rounded-full filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="absolute inset-0 opacity-10 overflow-hidden">
        <div class="grid-animation"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 pt-8 overflow-visible">
        <div class="max-w-7xl mx-auto overflow-visible">
            <div class="text-center mb-12" data-animate>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    {{ \App\Models\PageSection::getValue('documents', 'header', 'main_title_part_1', 'Все документы по') }}
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-blue-500 to-cyan-500">
                        {{ \App\Models\PageSection::getValue('documents', 'header', 'main_title_part_2', 'противодействию коррупции') }}
                    </span>
                </h1>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-6" data-animate data-delay="100"></div>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto" data-animate data-delay="200">
                    {{ \App\Models\PageSection::getValue('documents', 'header', 'subtitle', 'Полный архив официальных документов, нормативных актов и отчетов по противодействию коррупции') }}
                </p>
            </div>

            <div class="mb-12" data-animate data-delay="300">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
                    <div class="text-white">
                        <h2 class="text-2xl font-bold mb-2">{{ \App\Models\PageSection::getValue('documents', 'filters', 'archive_title', 'Архив документов') }}</h2>
                        <p class="text-gray-300">{{ \App\Models\PageSection::getValue('documents', 'filters', 'found_documents', 'Найдено документов:') }} <span class="text-blue-400 font-bold">{{ $totalDocuments }}</span></p>
                    </div>
                    
                    <div class="flex flex-wrap gap-4">
                        <div class="filter-badge active" data-filter="all">
                            <i class="fas fa-file-contract mr-2"></i>
                            {{ \App\Models\PageSection::getValue('documents', 'filters', 'all_documents', 'Все документы') }}
                        </div>
                        <div class="filter-badge" data-filter="нормативный акт">
                            <i class="fas fa-gavel mr-2"></i>
                            {{ \App\Models\PageSection::getValue('documents', 'filters', 'regulatory_acts', 'Нормативные акты') }}
                        </div>
                        <div class="filter-badge" data-filter="отчет">
                            <i class="fas fa-chart-line mr-2"></i>
                            {{ \App\Models\PageSection::getValue('documents', 'filters', 'reports', 'Отчеты') }}
                        </div>
                        <div class="filter-badge" data-filter="перечень сведений">
                            <i class="fas fa-list-alt mr-2"></i>
                            {{ \App\Models\PageSection::getValue('documents', 'filters', 'information_lists', 'Перечни сведений') }}
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8" data-animate data-delay="400">
                    <div class="stats-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm">{{ \App\Models\PageSection::getValue('documents', 'stats', 'total_documents_label', 'Документов') }}</p>
                                <p class="text-2xl font-bold text-white">{{ $totalDocuments }}</p>
                            </div>
                            <i class="fas fa-file-alt text-blue-400 text-2xl"></i>
                        </div>
                    </div>
                    
                    <div class="stats-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm">{{ \App\Models\PageSection::getValue('documents', 'stats', 'law_documents_label', 'Нормативные акты') }}</p>
                                <p class="text-2xl font-bold text-white">{{ $lawDocuments }}</p>
                            </div>
                            <i class="fas fa-gavel text-green-400 text-2xl"></i>
                        </div>
                    </div>
                    
                    <div class="stats-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm">{{ \App\Models\PageSection::getValue('documents', 'stats', 'reports_label', 'Отчеты') }}</p>
                                <p class="text-2xl font-bold text-white">{{ $reports }}</p>
                            </div>
                            <i class="fas fa-chart-line text-yellow-400 text-2xl"></i>
                        </div>
                    </div>
                    
                    <div class="stats-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm">{{ \App\Models\PageSection::getValue('documents', 'stats', 'information_lists_label', 'Перечни сведений') }}</p>
                                <p class="text-2xl font-bold text-white">{{ $informationLists }}</p>
                            </div>
                            <i class="fas fa-list-alt text-purple-400 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-16" data-animate data-delay="500">
                <div class="documents-table-container">
                    <div class="overflow-x-auto">
                        <table class="documents-table">
                            <thead>
                                <tr>
                                    <th class="w-12">
                                        <div class="flex items-center justify-center">
                                            <i class="fas fa-hashtag text-gray-400"></i>
                                        </div>
                                    </th>
                                    <th class="min-w-[300px] sortable" data-column="1">{{ \App\Models\PageSection::getValue('documents', 'table', 'title_column', 'Название документа') }}</th>
                                    <th class="min-w-[120px] sortable" data-column="2">{{ \App\Models\PageSection::getValue('documents', 'table', 'type_column', 'Тип') }}</th>
                                    <th class="min-w-[120px] sortable" data-column="3">{{ \App\Models\PageSection::getValue('documents', 'table', 'category_column', 'Категория') }}</th>
                                    <th class="min-w-[100px] sortable" data-column="4">{{ \App\Models\PageSection::getValue('documents', 'table', 'date_column', 'Дата') }}</th>
                                    <th class="min-w-[100px]">{{ \App\Models\PageSection::getValue('documents', 'table', 'size_column', 'Размер') }}</th>
                                    <th class="min-w-[120px]">{{ \App\Models\PageSection::getValue('documents', 'table', 'actions_column', 'Действия') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $index => $document)
                                <tr class="document-row" 
                                    data-index="{{ $index }}"
                                    data-type="{{ $document['type'] }}" 
                                    data-category="{{ $document['category'] }}">
                                    <td class="text-center">
                                        <span class="document-index">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="document-info">
                                            <h4 class="document-title">{{ $document['title'] }}</h4>
                                            <p class="document-description">{{ $document['description'] }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="document-type">
                                            <i class="{{ $document['type_icon'] }} {{ $document['type_color'] }} mr-2"></i>
                                            <span data-translate-type="{{ $document['type'] }}">{{ \App\Models\PageSection::getValue('documents', 'document_types', $document['type'], $document['type']) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="document-category">
                                            <i class="{{ $document['category_icon'] }} text-blue-400 mr-2"></i>
                                            <span data-translate-category="{{ $document['category'] }}">{{ \App\Models\PageSection::getValue('documents', 'document_categories', $document['category'], $document['category']) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="document-date" data-sort-date="{{ $document['date'] }}">
                                            {{ $document['date'] }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="document-size">
                                            <i class="fas fa-file-pdf text-red-400 mr-2"></i>
                                            <span>{{ $document['size'] }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex space-x-3">
                                            <a href="{{ $document['url'] }}" 
                                               target="_blank"
                                               class="document-action-btn view-btn"
                                               title="{{ \App\Models\PageSection::getValue('documents', 'buttons', 'view_button_title', 'Просмотреть PDF') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(!empty($document['pdf_url']))
                                            <a href="{{ $document['pdf_url'] }}" 
                                               download
                                               class="document-action-btn download-btn"
                                               title="{{ \App\Models\PageSection::getValue('documents', 'buttons', 'download_button_title', 'Скачать PDF') }}">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @endif
                                            <button class="document-action-btn info-btn"
                                                    title="{{ \App\Models\PageSection::getValue('documents', 'buttons', 'info_button_title', 'Информация о документе') }}"
                                                    onclick="showDocumentInfo({{ $index }})">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12">
                                        <div class="empty-documents">
                                            <i class="fas fa-folder-open text-blue-400 text-5xl mb-4"></i>
                                            <p class="text-white text-xl mb-2">{{ \App\Models\PageSection::getValue('documents', 'messages', 'no_documents_title', 'Документы не найдены') }}</p>
                                            <p class="text-gray-400">{{ \App\Models\PageSection::getValue('documents', 'messages', 'no_documents_text', 'Документы будут добавлены позже') }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($totalDocuments > 20)
                    <div class="pagination-container mt-8">
                        <div class="flex justify-between items-center">
                            <div class="text-gray-400 text-sm">
                                {{ \App\Models\PageSection::getValue('documents', 'pagination', 'showing_text', 'Показано') }} {{ min(20, $totalDocuments) }} {{ \App\Models\PageSection::getValue('documents', 'pagination', 'of_text', 'из') }} {{ $totalDocuments }} {{ \App\Models\PageSection::getValue('documents', 'pagination', 'documents_text', 'документов') }}
                            </div>
                            <div class="flex space-x-2">
                                <button class="pagination-btn disabled">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="pagination-btn active">1</button>
                                <button class="pagination-btn">2</button>
                                <button class="pagination-btn">3</button>
                                <button class="pagination-btn">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div id="documentModal" class="fixed inset-0 z-[9999] hidden transition-all duration-300">
                <div class="absolute inset-0 bg-black/80 backdrop-blur-md transition-opacity duration-300"></div>
                
                <div class="relative min-h-screen flex items-center justify-center p-4">
                    <div class="document-modal-card">
                        <div class="document-modal-header">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4">
                                    <div class="document-modal-icon">
                                        <i id="modalTypeIcon" class="fas fa-file-contract text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 id="modalTitle" class="document-modal-title"></h3>
                                        <div id="modalSubtitle" class="document-modal-subtitle"></div>
                                    </div>
                                </div>
                                <button type="button" class="document-modal-close" onclick="closeDocumentModal()">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <div class="document-modal-body">
                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                <div class="modal-info-card">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-file-alt text-blue-400 text-xl"></i>
                                        <div>
                                            <p class="modal-info-label">{{ \App\Models\PageSection::getValue('documents', 'modal', 'type_label', 'Тип документа') }}</p>
                                            <p id="modalType" class="modal-info-value"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="modal-info-card">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-tag text-blue-400 text-xl"></i>
                                        <div>
                                            <p class="modal-info-label">{{ \App\Models\PageSection::getValue('documents', 'modal', 'category_label', 'Категория') }}</p>
                                            <p id="modalCategory" class="modal-info-value"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="modal-info-card">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-calendar text-blue-400 text-xl"></i>
                                        <div>
                                            <p class="modal-info-label">{{ \App\Models\PageSection::getValue('documents', 'modal', 'date_label', 'Дата документа') }}</p>
                                            <p id="modalDate" class="modal-info-value"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="modal-info-card">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-weight text-blue-400 text-xl"></i>
                                        <div>
                                            <p class="modal-info-label">{{ \App\Models\PageSection::getValue('documents', 'modal', 'size_label', 'Размер файла') }}</p>
                                            <p id="modalSize" class="modal-info-value"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-8">
                                <h4 class="modal-section-title">{{ \App\Models\PageSection::getValue('documents', 'modal', 'description_label', 'Описание') }}</h4>
                                <p id="modalDescription" class="modal-description"></p>
                            </div>
                            
                            <div class="modal-buttons">
                                <a id="modalViewBtn" 
                                   href="#" 
                                   target="_blank"
                                   class="modal-primary-btn">
                                    <i class="fas fa-eye mr-3"></i>
                                    {{ \App\Models\PageSection::getValue('documents', 'modal', 'view_button', 'Просмотреть PDF') }}
                                </a>
                                <a id="modalDownloadBtn" 
                                   href="#" 
                                   download
                                   class="modal-secondary-btn">
                                    <i class="fas fa-download mr-3"></i>
                                    {{ \App\Models\PageSection::getValue('documents', 'modal', 'download_button', 'Скачать документ') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .documents-table-container {
        background: rgba(30, 41, 59, 0.9);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 16px;
        padding: 24px;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .documents-table {
        width: 100%;
        border-collapse: collapse;
    }

    .documents-table thead {
        border-bottom: 1px solid rgba(59, 130, 246, 0.2);
    }

    .documents-table th {
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        color: #60a5fa;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.05em;
        background: rgba(15, 23, 42, 0.5);
        position: relative;
        cursor: pointer;
        user-select: none;
        transition: background 0.2s ease;
    }

    .documents-table th.sortable:hover {
        background: rgba(59, 130, 246, 0.1);
    }

    .documents-table th.sortable.sorted-asc::after {
        content: " ↑";
        color: #60a5fa;
        font-weight: bold;
    }
    
    .documents-table th.sortable.sorted-desc::after {
        content: " ↓";
        color: #60a5fa;
        font-weight: bold;
    }

    .documents-table td {
        padding: 20px;
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
    }

    .documents-table tbody tr {
        transition: all 0.2s ease;
        background: transparent;
    }

    .documents-table tbody tr:hover {
        background: rgba(59, 130, 246, 0.08);
        transform: translateX(4px);
    }

    .documents-table tbody tr:last-child td {
        border-bottom: none;
    }

    .document-index {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: rgba(59, 130, 246, 0.1);
        color: #60a5fa;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
    }

    .document-info {
        max-width: 400px;
    }

    .document-title {
        font-size: 16px;
        font-weight: 600;
        color: white;
        margin-bottom: 8px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .document-description {
        font-size: 14px;
        color: #94a3b8;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .document-type, .document-category, .document-date, .document-size {
        display: flex;
        align-items: center;
        font-size: 14px;
        color: #cbd5e1;
    }

    .document-action-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s ease;
        font-size: 16px;
    }

    .view-btn {
        background: rgba(59, 130, 246, 0.1);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .download-btn {
        background: rgba(34, 197, 94, 0.1);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .info-btn {
        background: rgba(168, 85, 247, 0.1);
        color: #a855f7;
        border: 1px solid rgba(168, 85, 247, 0.2);
    }

    .document-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .stats-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 14px;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        border-color: rgba(59, 130, 246, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
    }

    .filter-badge {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 10px;
        color: #cbd5e1;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-badge:hover, .filter-badge.active {
        background: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
        color: white;
    }

    .empty-documents {
        text-align: center;
        padding: 60px 20px;
    }

    .pagination-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 10px;
        color: #cbd5e1;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .pagination-btn:hover, .pagination-btn.active {
        background: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
        color: white;
    }

    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .document-modal {
        opacity: 0;
        pointer-events: none;
        z-index: 9999 !important;
    }

    .document-modal.active {
        opacity: 1;
        pointer-events: auto;
        display: block !important;
    }

    .document-modal-card {
        background: rgba(30, 41, 59, 0.95);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 20px;
        width: 100%;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        backdrop-filter: blur(20px);
        transform: translateY(20px) scale(0.98);
        opacity: 0;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .document-modal.active .document-modal-card {
        transform: translateY(0) scale(1);
        opacity: 1;
    }

    .document-modal-header {
        background: rgba(15, 23, 42, 0.9);
        border-bottom: 1px solid rgba(59, 130, 246, 0.2);
        padding: 28px 32px;
        border-radius: 20px 20px 0 0;
    }

    .document-modal-icon {
        width: 56px;
        height: 56px;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .document-modal-title {
        font-size: 24px;
        font-weight: 600;
        color: white;
        line-height: 1.4;
        margin-bottom: 8px;
    }

    .document-modal-subtitle {
        font-size: 16px;
        color: #94a3b8;
    }

    .document-modal-close {
        color: #94a3b8;
        background: rgba(30, 41, 59, 0.8);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        padding: 12px;
        transition: all 0.3s ease;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .document-modal-close:hover {
        color: white;
        background: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
        transform: rotate(90deg);
    }

    .document-modal-body {
        padding: 32px;
    }

    .modal-info-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        padding: 20px;
    }

    .modal-info-label {
        font-size: 12px;
        color: #60a5fa;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }

    .modal-info-value {
        font-size: 16px;
        color: white;
        font-weight: 500;
    }

    .modal-section-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin-bottom: 16px;
    }

    .modal-description {
        color: #cbd5e1;
        font-size: 16px;
        line-height: 1.6;
        padding: 20px;
        background: rgba(15, 23, 42, 0.5);
        border-radius: 12px;
        border: 1px solid rgba(59, 130, 246, 0.1);
    }

    .modal-buttons {
        display: flex;
        gap: 16px;
        margin-top: 32px;
    }

    .modal-primary-btn, .modal-secondary-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 18px 24px;
        font-weight: 600;
        font-size: 16px;
        border-radius: 14px;
        border: none;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
    }

    .modal-primary-btn {
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: white;
    }

    .modal-primary-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(59, 130, 246, 0.3);
    }

    .modal-secondary-btn {
        background: rgba(30, 41, 59, 0.8);
        color: #22d3ee;
        border: 1px solid rgba(34, 211, 238, 0.3);
    }

    .modal-secondary-btn:hover {
        border-color: rgba(34, 211, 238, 0.5);
        background: rgba(30, 41, 59, 0.9);
        transform: translateY(-2px);
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

    .grid-animation {
        background-image: 
            linear-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        width: 100%;
        height: 100%;
        animation: gridMove 20s linear infinite;
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

    @media (max-width: 768px) {
        .documents-table {
            display: block;
        }
        
        .documents-table thead {
            display: none;
        }
        
        .documents-table tbody tr {
            display: block;
            margin-bottom: 16px;
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 12px;
            padding: 16px;
        }
        
        .documents-table td {
            display: block;
            padding: 12px 0;
            border-bottom: 1px solid rgba(59, 130, 246, 0.1);
        }
        
        .documents-table td:before {
            content: attr(data-label);
            font-weight: 600;
            color: #60a5fa;
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
            text-transform: uppercase;
        }
        
        .documents-table td:last-child {
            border-bottom: none;
        }
        
        .modal-buttons {
            flex-direction: column;
        }
        
        .stats-card {
            padding: 16px;
        }
    }
</style>

<script>
    
    const documentsData = @json($documents);
    
    
    const sortKeys = {
        types: {
            'нормативный акт': 1,
            'отчет': 2,
            'перечень сведений': 3,
            'приказ': 4,
            'положение': 5,
            'регламент': 6,
            'инструкция': 7,
            'план': 8,
            'справка': 9,
            'протокол': 10
        },
        categories: {
            'антикоррупционная политика': 1,
            'нормативные документы': 2,
            'отчетность': 3,
            'планы и программы': 4,
            'методические материалы': 5,
            'организационные документы': 6,
            'информационные материалы': 7,
            'финансовые документы': 8,
            'кадровые документы': 9,
            'прочие документы': 10
        }
    };
    
    function sortTable(columnIndex, direction = 'asc') {
        const table = document.querySelector('.documents-table');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('.document-row'));
        
        
        const rowsWithData = rows.map(row => {
            const index = parseInt(row.getAttribute('data-index'));
            return {
                element: row,
                data: documentsData[index],
                index: index
            };
        });
        
        rowsWithData.sort((a, b) => {
            let aValue, bValue;
            
            switch(columnIndex) {
                case 1: 
                    aValue = a.data['title'].toLowerCase();
                    bValue = b.data['title'].toLowerCase();
                    break;
                case 2: 
                    
                    aValue = a.data['type'];
                    bValue = b.data['type'];
                    
                    
                    if (sortKeys.types[aValue] && sortKeys.types[bValue]) {
                        aValue = sortKeys.types[aValue];
                        bValue = sortKeys.types[bValue];
                    }
                    break;
                case 3: 
                    
                    aValue = a.data['category'];
                    bValue = b.data['category'];
                    
                    
                    if (sortKeys.categories[aValue] && sortKeys.categories[bValue]) {
                        aValue = sortKeys.categories[aValue];
                        bValue = sortKeys.categories[bValue];
                    }
                    break;
                case 4: 
                    
                    const dateA = a.data['date'].split('.').reverse().join('');
                    const dateB = b.data['date'].split('.').reverse().join('');
                    aValue = dateA;
                    bValue = dateB;
                    break;
                default:
                    return 0;
            }
            
            
            if (typeof aValue === 'string' && typeof bValue === 'string') {
                aValue = aValue.toLowerCase();
                bValue = bValue.toLowerCase();
            }
            
            if (direction === 'asc') {
                return aValue > bValue ? 1 : aValue < bValue ? -1 : 0;
            } else {
                return aValue < bValue ? 1 : aValue > bValue ? -1 : 0;
            }
        });
        
        
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }
        
        
        rowsWithData.forEach((rowData, newIndex) => {
            const row = rowData.element;
            
            
            row.querySelector('.document-index').textContent = newIndex + 1;
            
            
            const typeKey = rowData.data['type'];
            const categoryKey = rowData.data['category'];
            
            const typeSpan = row.querySelector('[data-translate-type]');
            const categorySpan = row.querySelector('[data-translate-category]');
            
            if (typeSpan) {
                typeSpan.setAttribute('data-translate-type', typeKey);
                
            }
            
            if (categorySpan) {
                categorySpan.setAttribute('data-translate-category', categoryKey);
                
            }
            
            tbody.appendChild(row);
        });
    }
    
    function updateSortIndicator(columnIndex, direction) {
        
        document.querySelectorAll('.documents-table th.sortable').forEach(th => {
            th.classList.remove('sorted-asc', 'sorted-desc');
            th.removeAttribute('data-sort');
        });
        
        
        const currentTh = document.querySelector(`.documents-table th.sortable[data-column="${columnIndex}"]`);
        if (currentTh) {
            currentTh.classList.add(direction === 'asc' ? 'sorted-asc' : 'sorted-desc');
            currentTh.setAttribute('data-sort', direction);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        
        document.querySelectorAll('.documents-table th.sortable').forEach(th => {
            th.addEventListener('click', () => {
                const columnIndex = parseInt(th.getAttribute('data-column'));
                const currentSort = th.getAttribute('data-sort');
                const newDirection = currentSort === 'asc' ? 'desc' : 'asc';
                
                updateSortIndicator(columnIndex, newDirection);
                sortTable(columnIndex, newDirection);
            });
        });

        const animateOnScroll = () => {
            document.querySelectorAll('[data-animate]').forEach(element => {
                const rect = element.getBoundingClientRect();
                if (rect.top < window.innerHeight * 0.9 && rect.bottom > 0) {
                    const delay = element.getAttribute('data-delay') || 0;
                    setTimeout(() => element.classList.add('animated'), parseInt(delay));
                }
            });
        };
        
        const filterBadges = document.querySelectorAll('.filter-badge');
        const documentRows = document.querySelectorAll('.document-row');
        
        filterBadges.forEach(badge => {
            badge.addEventListener('click', function() {
                filterBadges.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                
                documentRows.forEach(row => {
                    const rowType = row.getAttribute('data-type');
                    const rowCategory = row.getAttribute('data-category');
                    
                    if (filter === 'all' || 
                        rowType.includes(filter) || 
                        rowCategory.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
        
        animateOnScroll();
        window.addEventListener('scroll', animateOnScroll);
    });
    
    function showDocumentInfo(index) {
        if (index >= documentsData.length) return;
        
        const document = documentsData[index];
        
        document.getElementById('modalTitle').textContent = document.title;
        document.getElementById('modalSubtitle').textContent = document.description;
        document.getElementById('modalDescription').textContent = document.description;
        document.getElementById('modalType').textContent = document.type;
        document.getElementById('modalCategory').textContent = document.category;
        document.getElementById('modalDate').textContent = document.date;
        document.getElementById('modalSize').textContent = document.size;
        document.getElementById('modalTypeIcon').className = document.type_icon + ' ' + document.type_color + ' text-2xl';
        
        document.getElementById('modalViewBtn').href = document.url;
        document.getElementById('modalDownloadBtn').href = document.pdf_url || document.url;
        
        const modal = document.getElementById('documentModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeDocumentModal() {
        const modal = document.getElementById('documentModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    document.getElementById('documentModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDocumentModal();
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDocumentModal();
        }
    });
</script>
@endsection