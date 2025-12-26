<div id="modalPreviewPDFPNS" x-data="previewPDFPNS()" x-show="isOpen" x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-2 z-50">
    <!-- Content mirrored from shared preview modal but with scoped ID/Function -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-[95vw] w-full h-[97vh] flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white" x-text="judulSurat ? 'Preview ' + judulSurat : 'Preview Dokumen'"></h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1"><span x-ref="suratNomor" x-text="nomorSurat || '-'"></span></p>
            </div>
            <div class="flex items-center space-x-3">
                <button @click="print()" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-print mr-2"></i> Cetak
                </button>
                <div x-data="{ openDropdown: false }" class="relative">
                    <button @click="openDropdown = !openDropdown" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-download mr-2"></i> Download <i class="fas fa-chevron-down ml-2 text-xs"></i>
                    </button>
                    <div x-show="openDropdown" @click.outside="openDropdown = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-1 z-50">
                         <a :href="fileUrl" :download="downloadFilename" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-file-pdf text-red-600 mr-2 w-4"></i> PDF
                        </a>
                        <a :href="'{{ url('template-surat/cuti/pns/docx') }}/' + suratId" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-file-word text-green-600 mr-2 w-4"></i> DOCX
                        </a>
                    </div>
                </div>
                <button @click="close()" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-times mr-2"></i> Tutup
                </button>
            </div>
        </div>
        <div class="flex-1 overflow-hidden bg-gray-100 dark:bg-gray-900">
            <iframe x-ref="pdfFrame" src="" frameborder="0" class="w-full h-full"></iframe>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                Surat berhasil dibuat dan disimpan
            </div>
            <a href="{{ route('arsip-surat.index') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                <i class="fas fa-arrow-right mr-2"></i> Lihat di Arsip
            </a>
        </div>
    </div>
</div>

<script>
    function previewPDFPNS() {
        return {
            isOpen: false,
            fileUrl: '',
            nomorSurat: '',
            suratId: null,
            judulSurat: '',
            tanggalDibuat: '',
            get downloadFilename() {
                if (this.nomorSurat) {
                    const parts = this.nomorSurat.split('-');
                    const nama = parts[2] ?? 'Dokumen';
                    return `Surat Izin Cuti-PNS-${nama}.pdf`;
                }
                return 'Surat_Izin_Cuti_PNS.pdf';
            },
            open(fileUrl, nomorSurat, suratId = null, judulSurat = '', tanggalDibuat = '') {
                this.fileUrl = fileUrl;
                this.nomorSurat = nomorSurat;
                this.suratId = suratId;
                this.judulSurat = judulSurat;
                this.tanggalDibuat = tanggalDibuat;
                this.isOpen = true;
                this.$nextTick(() => { this.$refs.pdfFrame.src = fileUrl; this.$refs.suratNomor.textContent = nomorSurat; });
            },
            close() { this.isOpen = false; setTimeout(() => window.location.href = "{{ route('arsip-surat.index') }}", 500); },
            print() { if(this.$refs.pdfFrame.contentWindow) this.$refs.pdfFrame.contentWindow.print(); }
        }
    }
    
    function openPreviewPDFPNS(fileUrl, nomorSurat, suratId = null, judulSurat = '', tanggalDibuat = '') {
        const modalEl = document.getElementById('modalPreviewPDFPNS');
        const modal = modalEl ? Alpine.$data(modalEl) : null;
        if (modal) modal.open(fileUrl, nomorSurat, suratId, judulSurat, tanggalDibuat);
    }
</script>
