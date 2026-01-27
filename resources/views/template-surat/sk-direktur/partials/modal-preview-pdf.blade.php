<div id="modalPreviewPDF" x-data="previewPDF()" x-show="isOpen" x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-2 z-50">
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-[98vw] sm:max-w-[95vw] w-full h-[98vh] sm:h-[97vh] flex flex-col overflow-hidden">

        <div
            class="px-4 sm:px-6 py-2.5 sm:py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between gap-3">
            <div class="flex-1 min-w-0">
                <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white truncate">Preview SK
                    Direktur</h3>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate mt-0.5" x-ref="suratNomor"
                    x-text="nomorSurat || '-'">
                </p>
            </div>
            <div class="flex items-center space-x-1.5 sm:space-x-3 shrink-0">
                <button @click="print()"
                    class="inline-flex items-center justify-center min-w-[40px] h-10 px-3 sm:px-4 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors whitespace-nowrap text-sm"
                    title="Cetak PDF">
                    <i class="fas fa-print sm:mr-2"></i>
                    <span class="hidden sm:inline">Cetak</span>
                </button>

                <div x-data="{ openDropdown: false }" class="relative">
                    <button @click="openDropdown = !openDropdown"
                        class="inline-flex items-center justify-center min-w-[40px] h-10 px-3 sm:px-4 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors whitespace-nowrap text-sm"
                        title="Download">
                        <i class="fas fa-download sm:mr-2"></i>
                        <span class="hidden sm:inline">Download</span>
                        <i class="fas fa-chevron-down ml-2 text-[10px] hidden sm:inline"></i>
                    </button>

                    <div x-show="openDropdown" @click.outside="openDropdown = false" x-transition x-cloak
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-1 z-[70]">
                        <button @click="downloadAs('docx'); openDropdown = false"
                            class="w-full flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-file-word text-green-600 mr-3 w-5 text-center"></i>
                            DOCX
                        </button>
                        <a :href="fileUrl" :download="downloadFilename"
                            class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-file-pdf text-red-600 mr-3 w-5 text-center"></i>
                            PDF
                        </a>
                    </div>
                </div>

                <button @click="close()"
                    class="inline-flex items-center justify-center min-w-[40px] h-10 px-3 sm:px-4 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors whitespace-nowrap text-sm"
                    title="Tutup">
                    <i class="fas fa-times sm:mr-2"></i>
                    <span class="hidden sm:inline">Tutup</span>
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-hidden bg-gray-100 dark:bg-gray-900">
            <iframe x-ref="pdfFrame" src="" frameborder="0" class="w-full h-full"></iframe>
        </div>

        <div
            class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-2 text-base"></i>
                <span class="font-medium">Surat berhasil dibuat dan disimpan</span>
            </div>
            <a href="{{ route('draft-surat.sk-direktur.index') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all font-semibold text-sm active:scale-95">
                <i class="fas fa-arrow-right mr-2 text-xs"></i> Lihat Draft
            </a>
        </div>
    </div>
</div>

<script>
    function previewPDF() {
        return {
            isOpen: false,
            fileUrl: '',
            nomorSurat: '',
            suratId: null,
            judulSurat: '',
            tanggalDibuat: '',
            shouldReloadOnClose: false,

            get downloadFilename() {
                if (this.nomorSurat) {
                    const cleanNomor = this.nomorSurat.replace(/[\/\\*:\?"<>|]/g, '-');
                    return `SK Direktur-${cleanNomor}.pdf`;
                }
                return 'SK_Direktur.pdf';
            },

            open(fileUrl, nomorSurat, suratId = null, judulSurat = '', tanggalDibuat = '', reloadOnClose = false) {
                this.shouldReloadOnClose = reloadOnClose;
                this.fileUrl = fileUrl;
                this.nomorSurat = nomorSurat;
                this.suratId = suratId;
                this.judulSurat = judulSurat;
                this.tanggalDibuat = tanggalDibuat;
                this.isOpen = true;
                this.$nextTick(() => {
                    const cacheBuster = '?t=' + new Date().getTime();
                    this.$refs.pdfFrame.src = fileUrl + cacheBuster;
                    this.$refs.suratNomor.textContent = nomorSurat;
                });
            },

            close() {
                this.isOpen = false;

                if (this.shouldReloadOnClose) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 300);
                } else {
                    if (typeof showNotification === 'function') {
                        showNotification('success', 'Berhasil!', 'Surat berhasil dibuat dan disimpan');
                    }
                    setTimeout(() => {
                        window.location.href = "{{ route('draft-surat.sk-direktur.index') }}";
                    }, 1000);
                }
            },

            print() {
                const iframe = this.$refs.pdfFrame;
                if (iframe && iframe.contentWindow) {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                }
            },

            downloadAs(format) {
                if (!this.suratId) {
                    const link = document.createElement('a');
                    link.href = this.fileUrl;
                    link.download = this.downloadFilename;
                    link.click();
                    return;
                }

                let downloadUrl = '';
                switch (format) {
                    case 'pdf':
                        downloadUrl = `/arsip-surat/${this.suratId}/download`;
                        break;
                    case 'docx':
                        downloadUrl = `/template-surat/sk-direktur/docx/${this.suratId}`;
                        break;
                    default:
                        downloadUrl = `/arsip-surat/${this.suratId}/download`;
                }

                window.location.href = downloadUrl;
            }
        }
    }

    function openPreviewPDF(fileUrl, nomorSurat, suratId = null, judulSurat = '', tanggalDibuat = '', reloadOnClose = false) {
        const modal = Alpine.$data(document.getElementById('modalPreviewPDF'));
        if (modal) {
            modal.open(fileUrl, nomorSurat, suratId, judulSurat, tanggalDibuat, reloadOnClose);
        }
    }

    function closePreviewPDF() {
        const modal = Alpine.$data(document.getElementById('modalPreviewPDF'));
        if (modal) {
            modal.close();
        }
    }
</script>