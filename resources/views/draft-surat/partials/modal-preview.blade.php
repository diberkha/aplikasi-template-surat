<div id="modalDraftPreview" x-data="draftPreview()"
    @open-draft-preview.window="$event.detail.item ? open($event.detail.item, $event.detail.reloadOnClose) : open($event.detail)"
    x-show="isOpen" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-2 z-[70]">
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-[98vw] sm:max-w-[95vw] w-full h-[98vh] sm:h-[97vh] flex flex-col overflow-hidden">

        <div
            class="px-4 sm:px-6 py-2.5 sm:py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between gap-3 bg-gray-50 dark:bg-gray-700/50">
            <div class="flex-1 min-w-0">
                <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white truncate">Preview Draft
                    Surat</h3>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate mt-0.5"><span
                        x-text="nomorSurat || '-'"></span></p>
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
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-1 z-[80]">
                        <template x-if="docxUrl !== '#'">
                            <a :href="docxUrl" :download="downloadDocxFilename"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-file-word text-green-600 mr-3 w-5"></i>
                                DOCX
                            </a>
                        </template>
                        <template x-if="pdfUrl !== '#'">
                            <a :href="pdfUrl" :download="downloadFilename"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-file-pdf text-red-600 mr-3 w-5"></i>
                                PDF
                            </a>
                        </template>
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
            class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center rounded-b-xl">
            <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                Draft ini belum diarsipkan
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('draftPreview', () => ({
            isOpen: false,
            fileUrl: '',
            nomorSurat: '',
            suratId: null,
            judulSurat: '',
            pdfUrl: '#',
            docxUrl: '#',
            docType: 'draft',
            shouldReloadOnClose: false,

            get downloadFilename() {
                if (!this.nomorSurat) return 'Draft.pdf';
                const cleanNomor = this.nomorSurat.replace(/[\/\\*:\?"<>|]/g, '-');
                if (this.docType === 'sop') return `SOP-${cleanNomor}.pdf`;
                if (this.docType === 'sk') return `SK-Direktur-${cleanNomor}.pdf`;
                return `Draft-${cleanNomor}.pdf`;
            },

            get downloadDocxFilename() {
                if (!this.nomorSurat) return 'Draft.docx';
                const cleanNomor = this.nomorSurat.replace(/[\/\\*:\?"<>|]/g, '-');
                if (this.docType === 'sop') return `SOP-${cleanNomor}.docx`;
                if (this.docType === 'sk') return `SK-Direktur-${cleanNomor}.docx`;
                return `Draft-${cleanNomor}.docx`;
            },

            open(item, reloadOnClose = false) {
                this.shouldReloadOnClose = reloadOnClose;
                this.suratId = item.id_surat || item.id;
                this.fileUrl = `/arsip-surat/${this.suratId}`;

                this.pdfUrl = '#';
                this.docxUrl = '#';

                const sop = item.sop;
                const sk = item.sk_direktur || item.skDirektur;
                const cuti = item.cuti;

                if (cuti && (cuti.id_cuti || cuti.kategori || cuti.form_data)) {
                    this.docType = 'cuti';
                    const nama = (cuti.form_data && cuti.form_data.nama) ? cuti.form_data.nama : 'Pegawai';
                    this.nomorSurat = nama;
                    this.pdfUrl = `{{ url('template-surat/cuti/pdf') }}/${this.suratId}`;

                    if (cuti.kategori) {
                        const cat = cuti.kategori.toString().toUpperCase();
                        if (cat === 'PNS') this.docxUrl = `{{ url('template-surat/cuti/pns/docx') }}/${this.suratId}`;
                        else if (cat === 'PPPK') this.docxUrl = `{{ url('template-surat/cuti/pppk/docx') }}/${this.suratId}`;
                        else if (cat === 'NON ASN' || cat === 'NONASN') this.docxUrl = `{{ url('template-surat/cuti/nonasn/docx') }}/${this.suratId}`;
                    }
                } else if (sop && (sop.id_sop || sop.nomor_dokumen)) {
                    this.docType = 'sop';
                    this.nomorSurat = sop.nomor_dokumen || item.nomor_surat || '-';
                    this.pdfUrl = `{{ url('template-surat/sop/file') }}/${this.suratId}`;
                    this.docxUrl = `{{ url('template-surat/sop/docx') }}/${this.suratId}`;
                } else if (sk && (sk.id_sk_direktur || sk.nomor_surat)) {
                    this.docType = 'sk';
                    this.nomorSurat = sk.nomor_surat || item.nomor_surat || '-';
                    this.pdfUrl = `{{ url('template-surat/sk-direktur/file') }}/${this.suratId}`;
                    this.docxUrl = `{{ url('template-surat/sk-direktur/docx') }}/${this.suratId}`;
                } else {
                    this.docType = 'draft';
                    this.nomorSurat = item.nomor_surat || '-';
                    this.pdfUrl = `/arsip-surat/${this.suratId}/download`;
                    this.docxUrl = item.docx_url || '#';
                }

                let judul = item.nama_surat;
                if (!judul && cuti && cuti.form_data) judul = cuti.form_data.nama + ' - ' + cuti.kategori;
                if (!judul && sop) judul = sop.judul_sop;
                if (!judul && sk) judul = sk.tentang;

                this.judulSurat = judul || '-';

                this.isOpen = true;
                window.dispatchEvent(new CustomEvent('modal-state-changed'));
                this.$nextTick(() => {
                    this.$refs.pdfFrame.src = '';
                    const cacheBuster = '?t=' + new Date().getTime();
                    const urlToLoad = this.pdfUrl !== '#' ? this.pdfUrl : this.fileUrl;
                    this.$refs.pdfFrame.src = urlToLoad + cacheBuster;
                });
            },

            close() {
                this.isOpen = false;
                this.$refs.pdfFrame.src = '';
                window.dispatchEvent(new CustomEvent('modal-state-changed'));

                if (this.shouldReloadOnClose) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 300);
                }
            },

            print() {
                const iframe = this.$refs.pdfFrame;
                if (iframe && iframe.contentWindow) {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                }
            }
        }));
    });

    window.openDraftPreview = (item, reloadOnClose = false) => {
        window.dispatchEvent(new CustomEvent('open-draft-preview', { detail: { item, reloadOnClose } }));
    }
</script>