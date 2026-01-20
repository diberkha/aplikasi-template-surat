<div id="modalPreviewPDF" x-data="previewPDF()" x-show="isOpen" x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-2 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-[95vw] w-full h-[97vh] flex flex-col">

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Preview Surat Keputusan Direktur</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1" x-ref="suratNomor" x-text="nomorSurat || '-'">
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <button @click="print()"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors"
                    title="Cetak PDF">
                    <i class="fas fa-print mr-2"></i>
                    Cetak
                </button>

                <div x-data="{ openDropdown: false }" class="relative">
                    <button @click="openDropdown = !openDropdown"
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors"
                        title="Download">
                        <i class="fas fa-download mr-2"></i>
                        Download
                        <i class="fas fa-chevron-down ml-2 text-xs"></i>
                    </button>

                    <div x-show="openDropdown" @click.outside="openDropdown = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-1 z-50">
                        <a :href="fileUrl" :download="downloadFilename"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-file-pdf text-red-600 mr-3 w-5"></i>
                            PDF
                        </a>
                        <button @click="downloadAs('docx'); openDropdown = false"
                            class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-file-word text-green-600 mr-3 w-5"></i>
                            DOCX
                        </button>
                    </div>
                </div>

                <button @click="close()"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors"
                    title="Tutup">
                    <i class="fas fa-times mr-2"></i>
                    Tutup
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-hidden bg-gray-100 dark:bg-gray-900">
            <iframe x-ref="pdfFrame" src="" frameborder="0" class="w-full h-full"></iframe>
        </div>

        <div
            class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                Surat berhasil dibuat dan disimpan
            </div>
            <a href="{{ route('draft-surat.sk-direktur.index') }}"
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                <i class="fas fa-arrow-right mr-2"></i>
                Lihat Draft
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

            get downloadFilename() {
                if (this.nomorSurat) {
                    const cleanNomor = this.nomorSurat.replace(/[\/\\*:\?"<>|]/g, '-');
                    return `SK Direktur-${cleanNomor}.pdf`;
                }
                return 'SK_Direktur.pdf';
            },

            open(fileUrl, nomorSurat, suratId = null, judulSurat = '', tanggalDibuat = '') {
                this.fileUrl = fileUrl;
                this.nomorSurat = nomorSurat;
                this.suratId = suratId;
                this.judulSurat = judulSurat;
                this.tanggalDibuat = tanggalDibuat;
                this.isOpen = true;
                this.$nextTick(() => {
                    this.$refs.pdfFrame.src = fileUrl;
                    this.$refs.suratNomor.textContent = nomorSurat;
                });
            },

            close() {
                this.isOpen = false;
                if (typeof showNotification === 'function') {
                    showNotification('success', 'Berhasil!', 'Surat berhasil dibuat dan disimpan');
                }
                setTimeout(() => {
                    window.location.href = "{{ route('draft-surat.sk-direktur.index') }}";
                }, 1000);
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

    function openPreviewPDF(fileUrl, nomorSurat, suratId = null, judulSurat = '', tanggalDibuat = '') {
        const modal = Alpine.$data(document.getElementById('modalPreviewPDF'));
        if (modal) {
            modal.open(fileUrl, nomorSurat, suratId, judulSurat, tanggalDibuat);
        }
    }

    function closePreviewPDF() {
        const modal = Alpine.$data(document.getElementById('modalPreviewPDF'));
        if (modal) {
            modal.close();
        }
    }
</script>
