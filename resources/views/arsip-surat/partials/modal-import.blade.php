<div id="modalImportSurat" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalImportSurat')"></div>

        <div
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-lg w-full overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700">

            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Import Surat</h3>
                <button onclick="closeModal('modalImportSurat')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form action="{{ route('arsip-surat.import') }}" method="POST" enctype="multipart/form-data"
                class="flex flex-col flex-1 overflow-hidden" x-data="{ 
                                                            openTipe: false, 
                                                            tipeSurat: '',
                                                            tipeSuratLabel: '',
                                                            options: [
                                                                { value: 'Surat Keputusan Direktur', label: 'Surat Keputusan Direktur' },
                                                                { value: 'Standar Operasional Prosedur (SOP)', label: 'Standar Operasional Prosedur (SOP)' },
                                                                { value: 'Surat Izin Cuti', label: 'Surat Izin Cuti' },
                                                            ],
                                                            openJenis: false,
                                                            jenisPegawai: '',
                                                            jenisPegawaiLabel: '',
                                                            jenisOptions: [
                                                                { value: 'PNS', label: 'PNS' },
                                                                { value: 'PPPK', label: 'PPPK' },
                                                                { value: 'NON ASN', label: 'NON ASN' },
                                                            ],
                                                            selectTipe(opt) {
                                                                this.tipeSurat = opt.value;
                                                                this.tipeSuratLabel = opt.label;
                                                                this.openTipe = false;
                                                            },
                                                            selectJenis(opt) {
                                                                this.jenisPegawai = opt.value;
                                                                this.jenisPegawaiLabel = opt.label;
                                                                this.openJenis = false;
                                                                this.resetPegawai();
                                                            },
                                                            pegawaiSearchTerm: '',
                                                            pegawaiResults: [],
                                                            isSearching: false,
                                                            isPegawaiSelected: false,
                                                            debounceTimer: null,
                                                            searchPegawai() {
                                                                if (this.pegawaiSearchTerm.length < 2) {
                                                                    this.pegawaiResults = [];
                                                                    return;
                                                                }
                                                                clearTimeout(this.debounceTimer);
                                                                this.isSearching = true;
                                                                this.debounceTimer = setTimeout(() => {
                                                                    fetch(`/api/pegawai/search?term=${this.pegawaiSearchTerm}&type=${this.jenisPegawai}`)
                                                                        .then(r => r.json())
                                                                        .then(data => {
                                                                            this.pegawaiResults = data;
                                                                            this.isSearching = false;
                                                                        });
                                                                }, 300);
                                                            },
                                                            selectPegawai(p) {
                                                                this.pegawaiSearchTerm = p.nama;
                                                                this.isPegawaiSelected = true;
                                                                this.pegawaiResults = [];
                                                            },
                                                            resetPegawai() {
                                                                this.pegawaiSearchTerm = '';
                                                                this.isPegawaiSelected = false;
                                                                this.pegawaiResults = [];
                                                            },
                                                            resetForm() {
                                                                this.tipeSurat = '';
                                                                this.tipeSuratLabel = '';
                                                                this.jenisPegawai = '';
                                                                this.jenisPegawaiLabel = '';
                                                                this.resetPegawai();
                                                            }
                                                        }" @reset="resetForm()">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Tipe Surat <span
                                class="text-red-500">*</span></label>

                        <div class="relative" @click.outside="openTipe = false">
                            <input type="hidden" name="tipe_surat" :value="tipeSurat" required>

                            <button type="button" @click="openTipe = !openTipe"
                                class="w-full px-4 py-2 text-left border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white flex justify-between items-center transition-all focus:ring-2 focus:ring-green-500 outline-none">
                                <span x-text="tipeSuratLabel || 'Pilih Tipe Surat'"
                                    :class="!tipeSuratLabel && 'text-gray-400 font-normal'"
                                    class="text-gray-700 dark:text-gray-300"></span>
                                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                                    :class="openTipe && 'rotate-180'"></i>
                            </button>

                            <div x-show="openTipe" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                class="absolute z-[9999] mt-1 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-2xl overflow-hidden"
                                style="display: none;">
                                <ul class="py-1">
                                    <template x-for="opt in options" :key="opt.value">
                                        <li>
                                            <button type="button" @click="selectTipe(opt)"
                                                class="w-full px-4 py-2.5 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20 hover:text-green-600 dark:hover:text-green-400 transition-colors flex items-center justify-between group">
                                                <span x-text="opt.label"></span>
                                                <i class="fas fa-check text-green-500 opacity-0 group-hover:opacity-100 transition-opacity"
                                                    x-show="tipeSurat === opt.value"></i>
                                            </button>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div x-show="tipeSurat === 'Surat Izin Cuti'"
                        class="space-y-4 pt-2 border-t border-gray-100 dark:border-gray-700 mt-2">
                        <div>
                            <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Jenis Pegawai <span
                                    class="text-red-500">*</span></label>

                            <div class="relative" @click.outside="openJenis = false">
                                <input type="hidden" name="kategori_pegawai" :value="jenisPegawai"
                                    :required="tipeSurat === 'Surat Izin Cuti'">

                                <button type="button" @click="openJenis = !openJenis"
                                    class="w-full px-4 py-2 text-left border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white flex justify-between items-center transition-all focus:ring-2 focus:ring-green-500 outline-none">
                                    <span x-text="jenisPegawaiLabel || 'Pilih Jenis Pegawai'"
                                        :class="!jenisPegawaiLabel && 'text-gray-400 font-normal'"
                                        class="text-gray-700 dark:text-gray-300"></span>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                                        :class="openJenis && 'rotate-180'"></i>
                                </button>

                                <div x-show="openJenis" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-end="opacity-0 transform scale-95"
                                    class="absolute z-[9999] mt-1 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-2xl overflow-hidden"
                                    style="display: none;">
                                    <ul class="py-1">
                                        <template x-for="opt in jenisOptions" :key="opt.value">
                                            <li>
                                                <button type="button" @click="selectJenis(opt)"
                                                    class="w-full px-4 py-2.5 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20 hover:text-green-600 dark:hover:text-green-400 transition-colors flex items-center justify-between group">
                                                    <span x-text="opt.label"></span>
                                                    <i class="fas fa-check text-green-500 opacity-0 group-hover:opacity-100 transition-opacity"
                                                        x-show="jenisPegawai === opt.value"></i>
                                                </button>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Nama Pegawai <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-search text-xs"></i>
                                </div>
                                <input type="text" name="pegawai_nama" x-model="pegawaiSearchTerm"
                                    @input="searchPegawai()"
                                    :readonly="isPegawaiSelected"
                                    :required="tipeSurat === 'Surat Izin Cuti'"
                                    :class="isPegawaiSelected ? 'bg-gray-100 dark:bg-gray-600 cursor-not-allowed' : 'bg-white dark:bg-gray-700'"
                                    class="w-full pl-9 pr-10 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:text-white focus:ring-green-500 focus:border-green-500 text-sm transition-all"
                                    placeholder="Cari nama pegawai...">
                                
                                <button type="button" x-show="isPegawaiSelected" @click="resetPegawai()"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                                    <i class="fas fa-times-circle"></i>
                                </button>

                                <div x-show="pegawaiResults.length > 0" 
                                    class="absolute z-[100] mt-1 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-2xl overflow-hidden max-h-48 overflow-y-auto"
                                    style="display: none;">
                                    <ul class="py-1">
                                        <template x-for="p in pegawaiResults" :key="p.id">
                                            <li>
                                                <button type="button" @click="selectPegawai(p)"
                                                    class="w-full px-4 py-2.5 text-left hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors border-b border-gray-50 dark:border-gray-700 last:border-0">
                                                    <div class="font-medium text-sm text-gray-900 dark:text-white" x-text="p.nama"></div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="p.nip ? p.nip + ' | ' + (p.jabatan || '-') : (p.jabatan || '-')"></div>
                                                </button>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                
                                <div x-show="isSearching" class="absolute right-3 top-3">
                                    <i class="fas fa-spinner fa-spin text-gray-400 text-xs"></i>
                                </div>
                            </div>
                            <p class="mt-1 text-[10px] text-gray-500 dark:text-gray-400" x-show="!isPegawaiSelected">
                                <i class="fas fa-info-circle mr-1"></i> Ketik minimal 2 karakter
                            </p>
                        </div>
                    </div>

                    <div x-show="tipeSurat !== 'Surat Izin Cuti'">
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Nama Surat <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_surat"
                            :required="tipeSurat !== 'Surat Izin Cuti' && tipeSurat !== ''"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-green-500 focus:border-green-500"
                            placeholder="Masukkan nama surat">
                    </div>

                    <div x-show="tipeSurat !== 'Surat Izin Cuti'">
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Nomor Surat
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_surat"
                            :required="tipeSurat !== 'Surat Izin Cuti' && tipeSurat !== ''"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-green-500 focus:border-green-500"
                            placeholder="Masukkan nomor surat">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Tanggal Surat <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_dibuat" required
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">File Surat
                            <span class="text-red-500">*</span></label>
                        <input type="file" name="file_surat" accept=".pdf" required
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-900 dark:file:text-green-300 border border-gray-300 dark:border-gray-600 rounded-lg p-1">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: PDF. Max 10MB.</p>
                    </div>
                </div>

                <div
                    class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex justify-end space-x-3 flex-shrink-0">
                    <button type="reset"
                        class="px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors text-sm">
                        Reset
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-normal transition-colors text-sm">
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>