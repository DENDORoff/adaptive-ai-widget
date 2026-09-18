<div id="pdfModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="pdfModalTitle">{{ \App\Models\PageSection::getValue('modals', 'pdf', 'title', 'Документ') }}</h3>
            <button class="modal-close" onclick="closePdfModal()">&times;</button>
        </div>
        <div class="modal-body">
            <iframe id="pdfIframe" class="pdf-iframe" src=""></iframe>
        </div>
    </div>
</div>
