<div id="receptionModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">{{ \App\Models\PageSection::getValue('modals', 'reception', 'title', 'График приема граждан') }}</h3>
            <button class="modal-close" onclick="closeReceptionModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="reception-image-container">
                <img src="{{ asset(\App\Models\PageSection::getValue('modals', 'reception', 'image_url', 'images/reception-schedule.jpg')) }}" alt="{{ \App\Models\PageSection::getValue('modals', 'reception', 'image_alt', 'График приема граждан') }}" class="reception-image" loading="lazy" onerror="handleReceptionImageError(this)">
            </div>
        </div>
    </div>
</div>
