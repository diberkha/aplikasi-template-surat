<!-- Modal Preview PDF -->
<div id="modalPreviewPDF" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-2 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-[95vw] w-full h-[97vh] flex flex-col">
        
        <!-- HEADER -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Preview Surat Hukum</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1" id="suratNomorPreview">-</p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="printPDFPreview()" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
                    title="Cetak PDF">
                    <i class="fas fa-print mr-2"></i>
                    Cetak
                </button>
                <a id="downloadPDFPreview" href="#" download
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors"
                    title="Download PDF">
                    <i class="fas fa-download mr-2"></i>
                    Download
                </a>
                <button onclick="closePreviewPDF()"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors"
                    title="Tutup">
                    <i class="fas fa-times mr-2"></i>
                    Tutup
                </button>
            </div>
        </div>

        <!-- PDF VIEWER -->
        <div class="flex-1 overflow-hidden bg-gray-100 dark:bg-gray-900">
            <iframe id="pdfFramePreview" src="" frameborder="0" class="w-full h-full"></iframe>
        </div>

        <!-- FOOTER -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                Surat berhasil dibuat dan disimpan
            </div>
            <a href="{{ route('arsip-surat.index') }}"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                <i class="fas fa-arrow-right mr-2"></i>
                Lihat di Arsip
            </a>
        </div>
    </div>
</div>

<script>
    // Open preview modal
    function openPreviewPDF(fileUrl, nomorSurat) {
        document.getElementById('pdfFramePreview').src = fileUrl;
        document.getElementById('suratNomorPreview').textContent = nomorSurat;
        document.getElementById('downloadPDFPreview').href = fileUrl;
        document.getElementById('downloadPDFPreview').download = nomorSurat + '.pdf';
        document.getElementById('modalPreviewPDF').classList.remove('hidden');
    }

    // Close preview modal
    function closePreviewPDF() {
        document.getElementById('modalPreviewPDF').classList.add('hidden');
        // Show success notification and refresh
        if (typeof showNotification === 'function') {
            showNotification('success', 'Berhasil!', 'Surat berhasil dibuat dan disimpan');
        }
        setTimeout(() => {
            window.location.href = "{{ route('arsip-surat.index') }}";
        }, 1000);
    }

    // Print PDF
    function printPDFPreview() {
        const iframe = document.getElementById('pdfFramePreview');
        if (iframe) {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }
    }

    // Prevent closing modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !document.getElementById('modalPreviewPDF').classList.contains('hidden')) {
            event.preventDefault();
        }
    });

    // Prevent closing modal by clicking outside
    document.getElementById('modalPreviewPDF').addEventListener('click', function(event) {
        if (event.target === this) {
            event.preventDefault();
        }
    });
</script>
