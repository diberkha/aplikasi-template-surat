<div id="modalCreateCutiNonASN"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full overflow-hidden">
        <div
            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modalTitleNonASN">Buat Surat Izin Cuti
                Non ASN</h3>
            <button onclick="closeModal('modalCreateCutiNonASN')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form action="{{ route('template-surat.cuti.store') }}" method="POST" id="cutiFormNonASN"
            onsubmit="submitCutiFormNonASN(event)" x-data="{ openJenisCuti: false, jenisCuti: '', jenisCutiLabel: '', jenisCutiOptions: [
                { value: 'Cuti Tahunan', label: '1. Cuti Tahunan' },
                { value: 'Cuti Besar', label: '2. Cuti Besar' },
                { value: 'Cuti Melahirkan', label: '3. Cuti Melahirkan' }
            ] }">
            @csrf
            <input type="hidden" name="template_id" id="template_surat_cuti_nonasn">
            <input type="hidden" name="kategori" id="kategori_cuti_nonasn" value="NON ASN">
            <input type="hidden" name="form[pegawai_id]" id="pegawai_id_nonasn">

            <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">

                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Tempat <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="form[tempat_surat]" value="Sragen" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Surat <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="form[tanggal_surat]" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">I. DATA PEGAWAI</h4>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-4">
                            <div class="relative">
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Pegawai <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    <input type="text" id="pegawai_search_nonasn" autocomplete="off"
                                        class="w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all"
                                        placeholder="Cari nama...">
                                    <button type="button" id="pegawai_reset_nonasn"
                                        class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <i class="fas fa-times-circle text-lg"></i>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Ketik minimal 2 karakter
                                </p>
                                <input type="hidden" name="form[nama]" id="nama_pegawai_nonasn">
                                <div id="pegawai_results_nonasn"
                                    class="hidden absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto mt-1">
                                </div>
                            </div>

                            <div id="nip_container_nonasn" style="display: none;">
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">NIP</label>
                                <input type="text" name="form[nip]" id="nip_pegawai_nonasn" readonly
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Jabatan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="form[jabatan]" id="jabatan_pegawai_nonasn" readonly
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Masa Kerja <span
                                        class="text-red-500">*</span></label>
                                <div class="flex items-center space-x-2">
                                    <input type="number" name="form[masa_kerja_tahun]" id="masa_kerja_tahun_nonasn"
                                        readonly
                                        class="w-24 px-3 py-2 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed" />
                                    <span class="text-sm text-gray-600 dark:text-gray-300">tahun</span>
                                    <input type="number" name="form[masa_kerja_bulan]" id="masa_kerja_bulan_nonasn"
                                        readonly
                                        class="w-24 px-3 py-2 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed" />
                                    <span class="text-sm text-gray-600 dark:text-gray-300">bulan</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Unit Kerja <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="form[unit]" value="RSUD dr. Soeratno Gemolong" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">II. JENIS CUTI YANG DIAMBIL</h4>
                    </div>
                    <div class="p-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Pilih Jenis Cuti <span
                                    class="text-red-500">*</span></label>
                            
                            <div class="relative" @click.outside="openJenisCuti = false">
                                <input type="hidden" name="form[jenis_cuti]" id="jenis_cuti_nonasn" :value="jenisCuti" required>

                                <button type="button" @click="openJenisCuti = !openJenisCuti"
                                    class="w-full px-4 py-3 text-left border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white flex justify-between items-center transition-all focus:ring-2 focus:ring-green-500 outline-none">
                                    <span x-text="jenisCutiLabel || 'Pilih Jenis Cuti'"
                                        :class="!jenisCutiLabel && 'text-gray-400 font-normal'"
                                        class="text-gray-700 dark:text-gray-300"></span>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                                        :class="openJenisCuti && 'rotate-180'"></i>
                                </button>

                                <div x-show="openJenisCuti" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-end="opacity-0 transform scale-95"
                                    class="absolute z-[9999] mt-1 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-2xl overflow-hidden"
                                    style="display: none;">
                                    <ul class="py-1">
                                        <template x-for="opt in jenisCutiOptions" :key="opt.value">
                                            <li>
                                                <button type="button" @click="jenisCuti = opt.value; jenisCutiLabel = opt.label; openJenisCuti = false"
                                                    class="w-full px-4 py-2.5 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20 hover:text-green-600 dark:hover:text-green-400 transition-colors flex items-center justify-between group">
                                                    <span x-text="opt.label"></span>
                                                    <i class="fas fa-check text-green-500 opacity-0 group-hover:opacity-100 transition-opacity"
                                                        x-show="jenisCuti === opt.value"></i>
                                                </button>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">III. ALASAN CUTI <span
                                class="text-red-500">*</span></h4>
                    </div>
                    <div class="p-4">
                        <div>
                            <textarea name="form[alasan]" required rows="3"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-info-circle mr-1"></i>
                                Jelaskan alasan cuti secara singkat dan jelas
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">IV. LAMANYA CUTI</h4>
                    </div>
                    <div class="p-4">
                        <input type="hidden" name="form[rentang_cuti_json]" id="rentang_cuti_json_nonasn">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Selama (hari) <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="form[lama_cuti]" id="lama_cuti_nonasn" required min="1" readonly
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Cuti <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="text" id="tanggal_cuti_multi_nonasn" placeholder="Pilih tanggal cuti"
                                        class="w-full px-4 py-3 pr-10 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                    <button type="button" id="clear_tanggal_cuti_nonasn"
                                        class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                                        aria-label="Clear tanggal cuti">
                                        <i class="fas fa-times-circle text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="form[mulai]" id="mulai_cuti_nonasn" required>
                        <input type="hidden" name="form[sampai]" id="sampai_cuti_nonasn" required>
                    </div>
                </div>

                <div id="sisa_cuti_container_nonasn"
                    class="hidden border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">V. CATATAN CUTI</h4>
                    </div>
                    <div class="p-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Sisa Cuti Tahunan</label>
                            <div class="relative">
                                <input type="text" id="sisa_cuti_display_nonasn" readonly
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed"
                                    value="0 Hari">
                                <div id="calc_preview_nonasn"
                                    class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-lg hidden">
                                    <p class="text-xs font-semibold text-red-700 dark:text-red-300 mb-2">Peringatan:</p>
                                    <div class="space-y-1 text-xs text-red-600 dark:text-red-400"
                                        id="calc_details_nonasn">
                                    </div>
                                </div>
                                <input type="hidden" name="form[sisa_cuti_tahunan]"
                                    id="sisa_cuti_tahunan_hidden_nonasn">
                                <input type="hidden" name="form[catatan_n]" id="catatan_n_hidden_nonasn">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Keterangan <span
                                    class="text-gray-500 text-xs">(Opsional)</span></label>
                            <textarea name="form[catatan_n_keterangan]" rows="2"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">VI. ALAMAT SELAMA MENJALANKAN CUTI</h4>
                    </div>
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Alamat Lengkap <span
                                    class="text-red-500">*</span></label>
                            <textarea name="form[alamat]" required rows="3"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-info-circle mr-1"></i>
                                Alamat lengkap selama menjalankan cuti
                            </p>
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Nomor Telepon <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" name="form[telp]" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-info-circle mr-1"></i>
                                Nomor yang dapat dihubungi saat cuti
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">VII. PERTIMBANGAN ATASAN LANGSUNG</h4>
                    </div>
                    <div class="p-4 space-y-4">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Atasan Langsung <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    <input type="text" id="atasan_search_nonasn" autocomplete="off" required
                                        class="w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all"
                                        placeholder="Cari nama...">
                                    <button type="button" id="atasan_reset_nonasn"
                                        class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <i class="fas fa-times-circle text-lg"></i>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Ketik minimal 2 karakter
                                </p>
                                <input type="hidden" name="form[nama_atasan]" id="nama_atasan_nonasn">
                                <div id="atasan_results_nonasn"
                                    class="hidden absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto mt-1">
                                </div>
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">NIP Atasan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="form[nip_atasan]" id="nip_atasan_nonasn" readonly
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Jabatan Atasan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="form[jabatan_atasan]" id="jabatan_atasan_nonasn" readonly
                                class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-3 rounded-b-xl">
                <button type="button" @click="document.getElementById('cutiFormNonASN').reset(); jenisCuti = ''; jenisCutiLabel = ''"
                    class="px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    Reset
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-normal transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

</script>
<script>
    (function () {
        let sisaCutiGlobal = 0;

        const searchInput = document.getElementById('pegawai_search_nonasn');
        const resultsContainer = document.getElementById('pegawai_results_nonasn');
        let dobounceTimer;

        if (!searchInput || !resultsContainer) return;

        searchInput.addEventListener('input', function (e) {
            clearTimeout(dobounceTimer);
            const term = e.target.value;
            if (term.length < 2) {
                resultsContainer.classList.add('hidden');
            }

            const resetBtn = document.getElementById('pegawai_reset_nonasn');
            if (resetBtn) {
                if (term.length > 0) resetBtn.classList.remove('hidden');
                else resetBtn.classList.add('hidden');
            }

            if (term.length < 2) return;

            dobounceTimer = setTimeout(() => {
                const data = window.masterPegawais.filter(p =>
                    (p.nama && p.nama.toLowerCase().includes(term.toLowerCase())) ||
                    (p.nip && p.nip.includes(term))
                ).filter(p => p.jenis_pegawai === 'NON ASN').slice(0, 10);

                resultsContainer.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(p => {
                        const div = document.createElement('div');
                        div.className = 'px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 transition-all';
                        const details = p.nip ? `${p.nip} | ${p.jabatan || '-'}` : (p.jabatan || '-');
                        div.innerHTML = `
                            <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm">${p.nama}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">${details}</div>
                        `;
                        div.onclick = () => selectPegawai(p.id);
                        resultsContainer.appendChild(div);
                    });
                    resultsContainer.classList.remove('hidden');
                } else {
                    resultsContainer.classList.add('hidden');
                }
            }, 300);
        });

        document.addEventListener('click', function (e) {
            if (searchInput && !searchInput.contains(e.target) && resultsContainer && !resultsContainer.contains(e.target)) {
                resultsContainer.classList.add('hidden');
            }
        });

        function selectPegawai(id) {
            const data = window.masterPegawais.find(p => p.id == id);
            if (data) {
                document.getElementById('nama_pegawai_nonasn').value = data.nama;
                document.getElementById('pegawai_id_nonasn').value = data.id;
                document.getElementById('pegawai_search_nonasn').value = data.nama;
                document.getElementById('pegawai_search_nonasn').readOnly = true;
                document.getElementById('pegawai_search_nonasn').classList.add('bg-gray-100', 'cursor-not-allowed');
                document.getElementById('pegawai_reset_nonasn').classList.remove('hidden');

                const nipContainer = document.getElementById('nip_container_nonasn');
                const nipInput = document.getElementById('nip_pegawai_nonasn');
                if (data.nip && data.nip.trim() !== '') {
                    nipInput.value = data.nip;
                    if (nipContainer) nipContainer.style.display = 'block';
                } else {
                    nipInput.value = '';
                    if (nipContainer) nipContainer.style.display = 'none';
                }

                if (data.masa_kerja) {
                    const tmt = new Date(data.masa_kerja);
                    const now = new Date();
                    let years = now.getFullYear() - tmt.getFullYear();
                    let months = now.getMonth() - tmt.getMonth();
                    if (months < 0) {
                        years--;
                        months += 12;
                    }
                    document.getElementById('masa_kerja_tahun_nonasn').value = years;
                    document.getElementById('masa_kerja_bulan_nonasn').value = months;
                } else {
                    document.getElementById('masa_kerja_tahun_nonasn').value = 0;
                    document.getElementById('masa_kerja_bulan_nonasn').value = 0;
                }
                document.getElementById('jabatan_pegawai_nonasn').value = data.jabatan || '';

                sisaCutiGlobal = data.sisa_cuti_tahunan || 0;
                updateSisaCutiDisplay();
                resultsContainer.classList.add('hidden');
            }
        }

        const resetBtn = document.getElementById('pegawai_reset_nonasn');
        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                document.getElementById('nama_pegawai_nonasn').value = '';
                document.getElementById('pegawai_id_nonasn').value = '';
                document.getElementById('pegawai_search_nonasn').value = '';
                document.getElementById('pegawai_search_nonasn').readOnly = false;
                document.getElementById('pegawai_search_nonasn').classList.remove('bg-gray-100', 'cursor-not-allowed');
                this.classList.add('hidden');

                const nipContainer = document.getElementById('nip_container_nonasn');
                if (nipContainer) nipContainer.style.display = 'none';
                document.getElementById('nip_pegawai_nonasn').value = '';
                document.getElementById('jabatan_pegawai_nonasn').value = '';
                document.getElementById('masa_kerja_tahun_nonasn').value = '';
                document.getElementById('masa_kerja_bulan_nonasn').value = '';

                sisaCutiGlobal = 0;
                updateSisaCutiDisplay();
                searchInput.focus();
            });
        }

        const atasanSearchInput = document.getElementById('atasan_search_nonasn');
        const atasanResultsContainer = document.getElementById('atasan_results_nonasn');
        let atasanDebounceTimer;

        if (atasanSearchInput && atasanResultsContainer) {
            atasanSearchInput.addEventListener('input', function (e) {
                clearTimeout(atasanDebounceTimer);
                const term = e.target.value;

                const atasanResetBtn = document.getElementById('atasan_reset_nonasn');
                if (atasanResetBtn) {
                    if (term.length > 0) atasanResetBtn.classList.remove('hidden');
                    else atasanResetBtn.classList.add('hidden');
                }

                if (term.length < 2) {
                    atasanResultsContainer.classList.add('hidden');
                    return;
                }

                atasanDebounceTimer = setTimeout(() => {
                    const structuralKeywords = ['direktur', 'kepala bidang', 'kabid', 'kepala seksi', 'kasi', 'kepala sub bagian', 'kasubbag', 'kepala bagian', 'kabag', 'ketua'];

                    const data = window.masterPegawais.filter(p => {
                        const matchesTerm = (p.nama && p.nama.toLowerCase().includes(term.toLowerCase())) ||
                            (p.nip && p.nip.includes(term));

                        if (!matchesTerm) return false;

                        const jabatan = (p.jabatan || '').toLowerCase();
                        return structuralKeywords.some(keyword => jabatan.includes(keyword));
                    }).slice(0, 10);

                    atasanResultsContainer.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(p => {
                            const div = document.createElement('div');
                            div.className = 'px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 transition-all';
                            const details = p.nip ? `${p.nip} | ${p.jabatan || '-'}` : (p.jabatan || '-');
                            div.innerHTML = `
                                <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm">${p.nama}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">${details}</div>
                            `;
                            div.onclick = () => selectAtasan(p.id);
                            atasanResultsContainer.appendChild(div);
                        });
                        atasanResultsContainer.classList.remove('hidden');
                    } else {
                        atasanResultsContainer.classList.add('hidden');
                    }
                }, 300);
            });

            document.addEventListener('click', function (e) {
                if (atasanSearchInput && !atasanSearchInput.contains(e.target) && atasanResultsContainer && !atasanResultsContainer.contains(e.target)) {
                    atasanResultsContainer.classList.add('hidden');
                }
            });
        }

        function selectAtasan(id) {
            const data = window.masterPegawais.find(p => p.id == id);
            if (data) {
                document.getElementById('nama_atasan_nonasn').value = data.nama;
                document.getElementById('atasan_search_nonasn').value = data.nama;
                document.getElementById('atasan_search_nonasn').readOnly = true;
                document.getElementById('atasan_search_nonasn').classList.add('bg-gray-100', 'cursor-not-allowed');
                document.getElementById('atasan_reset_nonasn').classList.remove('hidden');

                document.getElementById('nip_atasan_nonasn').value = data.nip || '';
                document.getElementById('jabatan_atasan_nonasn').value = data.jabatan || '';
                atasanResultsContainer.classList.add('hidden');
            }
        }

        const atasanResetBtn = document.getElementById('atasan_reset_nonasn');
        if (atasanResetBtn) {
            atasanResetBtn.addEventListener('click', function () {
                document.getElementById('nama_atasan_nonasn').value = '';
                document.getElementById('atasan_search_nonasn').value = '';
                document.getElementById('atasan_search_nonasn').readOnly = false;
                document.getElementById('atasan_search_nonasn').classList.remove('bg-gray-100', 'cursor-not-allowed');
                this.classList.add('hidden');

                document.getElementById('nip_atasan_nonasn').value = '';
                document.getElementById('jabatan_atasan_nonasn').value = '';
                atasanSearchInput.focus();
            });
        }

        const jenisCutiSelect = document.getElementById('jenis_cuti_nonasn');
        const lamaCutiInput = document.getElementById('lama_cuti_nonasn');
        const sisaCutiContainer = document.getElementById('sisa_cuti_container_nonasn');
        const sisaCutiDisplay = document.getElementById('sisa_cuti_display_nonasn');

        if (jenisCutiSelect) {
            jenisCutiSelect.addEventListener('change', function (e) {
                updateSisaCutiDisplay();
            });
        }

        if (lamaCutiInput) {
            lamaCutiInput.addEventListener('input', function (e) {
                updateSisaCutiDisplay();
            });
        }

        function updateSisaCutiDisplay() {
            if (!jenisCutiSelect || !sisaCutiContainer || !sisaCutiDisplay) return;

            const selected = jenisCutiSelect.value;
            const sisaCutiHidden = document.getElementById('sisa_cuti_tahunan_hidden_nonasn');
            const lamaCutiValue = parseInt(lamaCutiInput ? lamaCutiInput.value : 0) || 0;

            if (selected === 'Cuti Tahunan') {
                const sisaSetelahCuti = Math.max(0, sisaCutiGlobal - lamaCutiValue);
                sisaCutiContainer.classList.remove('hidden');
                sisaCutiDisplay.value = sisaSetelahCuti + ' Hari';
                if (sisaCutiHidden) sisaCutiHidden.value = sisaSetelahCuti;

                const catatanNHidden = document.getElementById('catatan_n_hidden_nonasn');
                if (catatanNHidden) catatanNHidden.value = sisaSetelahCuti;

                const calcPreview = document.getElementById('calc_preview_nonasn');
                const calcDetails = document.getElementById('calc_details_nonasn');

                if (lamaCutiValue > sisaCutiGlobal) {
                    const excess = lamaCutiValue - sisaCutiGlobal;
                    calcPreview.classList.remove('hidden');
                    calcDetails.innerHTML = `<div class="text-xs text-red-600 dark:text-red-400 font-bold flex items-center p-2"><i class="fas fa-exclamation-triangle mr-2"></i> Jumlah cuti yang diajukan melebihi sisa cuti yang tersedia sebesar ${excess} hari</div>`;
                } else {
                    calcPreview.classList.add('hidden');
                    calcDetails.innerHTML = '';
                }
            } else {
                sisaCutiContainer.classList.add('hidden');
                if (sisaCutiHidden) sisaCutiHidden.value = '';

                const catatanNHidden = document.getElementById('catatan_n_hidden_nonasn');
                if (catatanNHidden) catatanNHidden.value = '';

                const calcPreview = document.getElementById('calc_preview_nonasn');
                if (calcPreview) calcPreview.classList.add('hidden');
            }
        }

        const modal = document.getElementById('modalCreateCutiNonASN');
        if (modal) {
            modal.addEventListener('modal-closed', function () {
                if (searchInput) {
                    searchInput.value = '';
                    searchInput.readOnly = false;
                    searchInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                }
                if (resultsContainer) {
                    resultsContainer.classList.add('hidden');
                }
                const pegawaiResetBtn = document.getElementById('pegawai_reset_nonasn');
                if (pegawaiResetBtn) {
                    pegawaiResetBtn.classList.add('hidden');
                }

                if (atasanSearchInput) {
                    atasanSearchInput.value = '';
                    atasanSearchInput.readOnly = false;
                    atasanSearchInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                }
                if (atasanResultsContainer) {
                    atasanResultsContainer.classList.add('hidden');
                }
                const atasanResetBtn = document.getElementById('atasan_reset_nonasn');
                if (atasanResetBtn) {
                    atasanResetBtn.classList.add('hidden');
                }

                if (sisaCutiContainer) {
                    sisaCutiContainer.classList.add('hidden');
                }
                if (sisaCutiDisplay) {
                    sisaCutiDisplay.value = '0 Hari';
                }

                sisaCutiGlobal = 0;

                if (typeof initRentangCutiNonASN === 'function') {
                    initRentangCutiNonASN();
                }
            });
        }
    })();

    function attachFlatpickrActionsNonASN(instance) {
        if (!instance || !instance.calendarContainer) return;

        const container = instance.calendarContainer;
        if (container.querySelector('.flatpickr-action-row')) return;

        const actionRow = document.createElement('div');
        actionRow.className = 'flatpickr-action-row';
        actionRow.style.display = 'flex';
        actionRow.style.justifyContent = 'space-between';
        actionRow.style.padding = '8px 12px';
        actionRow.style.borderTop = '1px solid #e5e7eb';

        const clearAction = document.createElement('button');
        clearAction.type = 'button';
        clearAction.textContent = 'Clear';
        clearAction.style.color = '#2563eb';
        clearAction.style.fontSize = '14px';

        const todayAction = document.createElement('button');
        todayAction.type = 'button';
        todayAction.textContent = 'Today';
        todayAction.style.color = '#2563eb';
        todayAction.style.fontSize = '14px';

        clearAction.addEventListener('click', function (e) {
            e.preventDefault();
            instance.clear();
            syncRentangNonASN([]);
        });

        todayAction.addEventListener('click', function (e) {
            e.preventDefault();
            const now = new Date();
            now.setHours(0, 0, 0, 0);

            if (instance.config.mode === 'multiple') {
                const selected = (instance.selectedDates || []).map(d => {
                    const dt = new Date(d);
                    dt.setHours(0, 0, 0, 0);
                    return dt;
                });
                const exists = selected.some(d => d.getTime() === now.getTime());
                if (!exists) selected.push(now);
                instance.setDate(selected, true);
                return;
            }

            instance.setDate(now, true);
        });

        actionRow.appendChild(clearAction);
        actionRow.appendChild(todayAction);
        container.appendChild(actionRow);
    }

    function initRentangCutiNonASN() {
        const tanggalInput = document.getElementById('tanggal_cuti_multi_nonasn');
        const clearBtn = document.getElementById('clear_tanggal_cuti_nonasn');
        if (!tanggalInput || typeof flatpickr === 'undefined') return;

        if (clearBtn && !clearBtn.dataset.bound) {
            clearBtn.addEventListener('click', function () {
                if (tanggalInput._flatpickr) {
                    tanggalInput._flatpickr.clear();
                }
                syncRentangNonASN([]);
            });
            clearBtn.dataset.bound = '1';
        }

        if (!tanggalInput.dataset.bound) {
            flatpickr(tanggalInput, {
                mode: 'multiple',
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'j F Y',
                conjunction: ', ',
                locale: 'id',
                onReady: function (selectedDates) {
                    syncRentangNonASN(selectedDates);
                    if (tanggalInput._flatpickr && tanggalInput._flatpickr.altInput) {
                        tanggalInput._flatpickr.altInput.classList.add('pr-10');
                    }
                    attachFlatpickrActionsNonASN(this);
                },
                onChange: function (selectedDates) {
                    syncRentangNonASN(selectedDates);
                }
            });
            tanggalInput.dataset.bound = '1';
        }

        if (tanggalInput._flatpickr) {
            tanggalInput._flatpickr.clear();
        }
        syncRentangNonASN([]);
    }

    function syncRentangNonASN(selectedDates = null) {
        const lamaInput = document.getElementById('lama_cuti_nonasn');
        const mulaiInput = document.getElementById('mulai_cuti_nonasn');
        const sampaiInput = document.getElementById('sampai_cuti_nonasn');
        const jsonInput = document.getElementById('rentang_cuti_json_nonasn');
        const tanggalInput = document.getElementById('tanggal_cuti_multi_nonasn');
        const clearBtn = document.getElementById('clear_tanggal_cuti_nonasn');
        if (!lamaInput || !mulaiInput || !sampaiInput || !jsonInput || !tanggalInput) return;

        const picked = selectedDates ?? (tanggalInput._flatpickr ? tanggalInput._flatpickr.selectedDates : []);
        const orderedDates = picked
            .map(d => {
                const dt = new Date(d);
                dt.setHours(0, 0, 0, 0);
                return dt;
            })
            .sort((a, b) => a - b)
            .filter((d, idx, arr) => idx === 0 || d.getTime() !== arr[idx - 1].getTime());

        if (orderedDates.length === 0) {
            lamaInput.value = '';
            mulaiInput.value = '';
            sampaiInput.value = '';
            jsonInput.value = '[]';
            if (tanggalInput._flatpickr && tanggalInput._flatpickr.altInput) {
                tanggalInput._flatpickr.altInput.value = '';
            }
            if (clearBtn) clearBtn.classList.add('hidden');
            return;
        }

        const toDateString = (d) => {
            const y = d.getFullYear();
            const m = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${y}-${m}-${day}`;
        };

        const ranges = [];
        let start = orderedDates[0];
        let prev = orderedDates[0];
        for (let i = 1; i < orderedDates.length; i++) {
            const curr = orderedDates[i];
            const diffDay = Math.round((curr - prev) / (1000 * 60 * 60 * 24));
            if (diffDay === 1) {
                prev = curr;
                continue;
            }
            ranges.push({ mulai: toDateString(start), sampai: toDateString(prev) });
            start = curr;
            prev = curr;
        }
        ranges.push({ mulai: toDateString(start), sampai: toDateString(prev) });

        lamaInput.value = orderedDates.length;
        mulaiInput.value = toDateString(orderedDates[0]);
        sampaiInput.value = toDateString(orderedDates[orderedDates.length - 1]);
        jsonInput.value = JSON.stringify(ranges);

        if (tanggalInput._flatpickr && tanggalInput._flatpickr.altInput) {
            const compactLabel = formatCompactRangeLabelNonASN(ranges);
            tanggalInput._flatpickr.altInput.value = compactLabel;
        }
        if (clearBtn) clearBtn.classList.remove('hidden');

        const event = new Event('input', { bubbles: true });
        lamaInput.dispatchEvent(event);
    }

    function formatCompactRangeLabelNonASN(ranges) {
        if (!ranges || ranges.length === 0) return '';

        const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const parse = (v) => {
            const [y, m, d] = v.split('-').map(Number);
            return { y, m, d };
        };

        const allSameMonthYear = ranges.every((r) => {
            const a = parse(r.mulai);
            const b = parse(r.sampai);
            return a.y === b.y && a.m === b.m;
        }) && ranges.every((r) => {
            const ref = parse(ranges[0].mulai);
            const a = parse(r.mulai);
            const b = parse(r.sampai);
            return a.y === ref.y && a.m === ref.m && b.y === ref.y && b.m === ref.m;
        });

        if (allSameMonthYear) {
            const ref = parse(ranges[0].mulai);
            const parts = ranges.map((r) => {
                const a = parse(r.mulai);
                const b = parse(r.sampai);
                return a.d === b.d ? `${a.d}` : `${a.d}-${b.d}`;
            });
            return `${parts.join(', ')} ${bulan[ref.m - 1]} ${ref.y}`;
        }

        return ranges.map((r) => {
            const a = parse(r.mulai);
            const b = parse(r.sampai);
            if (a.y === b.y && a.m === b.m) {
                return a.d === b.d
                    ? `${a.d} ${bulan[a.m - 1]} ${a.y}`
                    : `${a.d}-${b.d} ${bulan[a.m - 1]} ${a.y}`;
            }
            return `${a.d} ${bulan[a.m - 1]} ${a.y} - ${b.d} ${bulan[b.m - 1]} ${b.y}`;
        }).join(', ');
    }

    document.addEventListener('DOMContentLoaded', initRentangCutiNonASN);

    function submitCutiFormNonASN(e) {
        e.preventDefault();
        syncRentangNonASN();

        const form = document.getElementById('cutiFormNonASN');
        const rentangJson = document.getElementById('rentang_cuti_json_nonasn');
        if (!rentangJson || rentangJson.value === '[]') {
            notify('error', 'Validasi', 'Minimal satu rentang tanggal cuti harus diisi.', false);
            return;
        }

        const submitBtn = form.querySelector('button[type="submit"]');
        if (!submitBtn) return;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan';

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(r => r.json().then(d => ({ ok: r.ok, status: r.status, data: d })))
            .then(res => {
                if (!res.ok) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Simpan';

                    if (res.data?.errors) {
                        handleValidationErrors(res.data.errors);
                    } else {
                        notify('error', 'Gagal', res.data.message || 'Validasi gagal. Periksa kembali data yang diinput.', false);
                    }
                } else if (res.data.success) {
                    notify('success', 'Berhasil', res.data.message);
                    closeModal('modalCreateCutiNonASN');
                    form.reset();

                    if (typeof openPreviewPDFNonASN === 'function') {
                        openPreviewPDFNonASN(res.data.file_url, res.data.nomor_surat, res.data.surat_id, 'Surat Izin Cuti Non ASN', new Date().toISOString().slice(0, 10), false);
                    } else {
                        window.location.href = res.data.file_url;
                    }
                }
            })
            .catch(err => notify('error', 'Gagal', 'Terjadi kesalahan sistem: ' + err.message, false))
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Simpan';
            });
    }
</script>
