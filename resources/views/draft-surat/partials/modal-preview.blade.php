<div id="modalDraftPreview" x-data="draftPreview()" @open-draft-preview.window="open($event.detail)" x-show="isOpen"
    x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-2 z-[70]">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-[95vw] w-full h-[97vh] flex flex-col">

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Preview Draft Surat</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1"><span x-text="nomorSurat || '-'"></span></p>
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
                        <template x-if="docxUrl !== '#'">
                            <a :href="docxUrl" :download="downloadDocxFilename"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-file-word text-green-600 mr-3 w-5"></i>
                                DOCX
                            </a>
                        </template>
                        <template x-if="pdfUrl !== '#'">
                            <a :href="pdfUrl" :download="downloadFilename"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-file-pdf text-red-600 mr-3 w-5"></i>
                                PDF
                            </a>
                        </template>
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

            open(item) {
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
                this.$nextTick(() => {
                    this.$refs.pdfFrame.src = '';
                    this.$refs.pdfFrame.src = this.pdfUrl !== '#' ? this.pdfUrl : this.fileUrl;
                });
            },

            close() {
                this.isOpen = false;
                this.$refs.pdfFrame.src = '';
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

    window.openDraftPreview = (item) => {
        window.dispatchEvent(new CustomEvent('open-draft-preview', { detail: item }));
    }
</script>