<div id="modalCreateCuti" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modalTitle">Buat Surat Izin Cuti</h3>
            <button onclick="closeModal('modalCreateCuti')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form action="{{ route('template-surat.cuti.store') }}" method="POST" id="cutiForm" onsubmit="submitCutiForm(event)">
            @csrf
            <input type="hidden" name="template_id" id="template_surat_cuti">
            <input type="hidden" name="kategori" id="kategori_cuti" value="PNS">
            <input type="hidden" name="form[pegawai_id]" id="pegawai_id_pns">

            <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">
                
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Tempat Surat <span class="text-red-500">*</span></label>
                            <input type="text" name="form[tempat_surat]" value="Sragen" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Surat <span class="text-red-500">*</span></label>
                            <input type="date" name="form[tanggal_surat]" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">I. DATA PEGAWAI</h4>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Pegawai <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    <input type="text" id="pegawai_search" autocomplete="off" 
                                        class="w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all" 
                                        placeholder="Cari nama...">
                                    <button type="button" id="pegawai_reset" class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <i class="fas fa-times-circle text-lg"></i>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Ketik minimal 2 karakter
                                </p>
                                <input type="hidden" name="form[nama]" id="nama_pegawai">
                                <div id="pegawai_results" class="hidden absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto mt-1"></div>
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">NIP <span class="text-red-500">*</span></label>
                                <input type="text" name="form[nip]" id="nip_pegawai" readonly class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Jabatan <span class="text-red-500">*</span></label>
                                <input type="text" name="form[jabatan]" id="jabatan_pegawai" readonly class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Masa Kerja</label>
                                <div class="flex items-center space-x-2">
                                    <input type="number" name="form[masa_kerja_tahun]" id="masa_kerja_tahun" readonly
                                        class="w-24 px-3 py-2 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed" />
                                    <span class="text-sm text-gray-600 dark:text-gray-300">tahun</span>
                                    <input type="number" name="form[masa_kerja_bulan]" id="masa_kerja_bulan" readonly
                                        class="w-24 px-3 py-2 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed" />
                                    <span class="text-sm text-gray-600 dark:text-gray-300">bulan</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Unit Kerja <span class="text-red-500">*</span></label>
                            <input type="text" name="form[unit]" value="RSUD dr. Soeratno Gemolong" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">II. JENIS CUTI YANG DIAMBIL</h4>
                    </div>
                    <div class="p-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Pilih Jenis Cuti <span class="text-red-500">*</span></label>
                            <select name="form[jenis_cuti]" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="">-- Pilih Jenis Cuti --</option>
                                <option value="Cuti Tahunan">1. Cuti Tahunan</option>
                                <option value="Cuti Besar">2. Cuti Besar</option>
                                <option value="Cuti Sakit">3. Cuti Sakit</option>
                                <option value="Cuti Melahirkan">4. Cuti Melahirkan</option>
                                <option value="Cuti Karena Alasan Penting">5. Cuti Karena Alasan Penting</option>
                                <option value="Cuti di Luar Tanggungan Negara">6. Cuti di Luar Tanggungan Negara</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">III. ALASAN CUTI</h4>
                    </div>
                    <div class="p-4">
                        <div>
                            <textarea name="form[alasan]" required rows="3" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
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
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Selama (hari) <span class="text-red-500">*</span></label>
                                <input type="number" name="form[lama_cuti]" id="lama_cuti_pns" required min="1" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Mulai Tanggal <span class="text-red-500">*</span></label>
                                <input type="date" name="form[mulai]" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Sampai Tanggal <span class="text-red-500">*</span></label>
                                <input type="date" name="form[sampai]" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>                
                
                <div id="sisa_cuti_container" class="hidden border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">V. CATATAN CUTI</h4>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/50">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300 text-sm">Sisa Cuti N-2</label>
                                <input type="text" id="val_n2_display" readonly 
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed" 
                                     value="0 Hari">
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300 text-sm">Sisa Cuti N-1</label>
                                <input type="text" id="val_n1_display" readonly 
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed" 
                                     value="0 Hari">
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300 text-sm">Sisa Cuti N</label>
                                <input type="text" id="val_n_display" readonly 
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed" 
                                     value="0 Hari">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                            <div>
                                <textarea name="form[catatan_n2_keterangan]" rows="2" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y text-sm"
                                    placeholder="Keterangan N-2..."></textarea>
                            </div>
                            <div>
                                <textarea name="form[catatan_n1_keterangan]" rows="2" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y text-sm"
                                    placeholder="Keterangan N-1..."></textarea>
                            </div>
                            <div>
                                <textarea name="form[catatan_n_keterangan]" rows="2" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y text-sm"
                                    placeholder="Keterangan N..."></textarea>
                            </div>
                        </div>
                        
                        <div id="calc_preview" class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-lg hidden">
                            <p class="text-xs font-semibold text-red-700 dark:text-red-300 mb-2">Peringatan:</p>
                            <div class="space-y-1 text-xs text-red-600 dark:text-red-400" id="calc_details">
                            </div>
                        </div>
                        <input type="hidden" name="form[sisa_cuti_tahunan]" id="sisa_cuti_tahunan_hidden">
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">VI. ALAMAT SELAMA MENJALANKAN CUTI</h4>
                    </div>
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="form[alamat]" required rows="3" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-info-circle mr-1"></i>
                                Alamat lengkap selama menjalankan cuti
                            </p>
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Nomor Telepon <span class="text-red-500">*</span></label>
                            <input type="tel" name="form[telp]" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
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
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Atasan Langsung</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    <input type="text" id="atasan_search" autocomplete="off" 
                                        class="w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all" 
                                        placeholder="Cari nama...">
                                    <button type="button" id="atasan_reset" class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <i class="fas fa-times-circle text-lg"></i>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Ketik minimal 2 karakter
                                </p>
                                <input type="hidden" name="form[nama_atasan]" id="nama_atasan">
                                <div id="atasan_results" class="hidden absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto mt-1"></div>
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">NIP Atasan</label>
                                <input type="text" name="form[nip_atasan]" id="nip_atasan" readonly class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Jabatan Atasan</label>
                            <input type="text" name="form[jabatan_atasan]" id="jabatan_atasan" readonly class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('cutiForm').reset()" class="px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    Reset
                </button>
                <button type="submit" class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

</script>
<script>
(function(){
    let sisaCutiGlobal = 0;
    let sisaN = 0;
    let sisaN1 = 0;
    let sisaN2 = 0;

    const searchInput = document.getElementById('pegawai_search');
    const resultsContainer = document.getElementById('pegawai_results');
    let dobounceTimer;
    
    if(!searchInput || !resultsContainer) return;

    searchInput.addEventListener('input', function(e){
        clearTimeout(dobounceTimer);
        const term = e.target.value;
        if(term.length < 2) {
            resultsContainer.classList.add('hidden');
            return;
        }

        dobounceTimer = setTimeout(() => {
            fetch(`/api/pegawai/search?term=${term}&type=PNS`)
                .then(r => r.json())
                .then(data => {
                    resultsContainer.innerHTML = '';
                    if(data.length > 0){
                        data.forEach(p => {
                            const div = document.createElement('div');
                            div.className = 'px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer text-gray-700 dark:text-gray-200';
                            div.textContent = `${p.nama} - ${p.nip}`;
                            div.onclick = () => selectPegawai(p.id);
                            resultsContainer.appendChild(div);
                        });
                        resultsContainer.classList.remove('hidden');
                    } else {
                        resultsContainer.classList.add('hidden');
                    }
                });
        }, 300);
    });

    document.addEventListener('click', function(e){
        if(searchInput && !searchInput.contains(e.target) && resultsContainer && !resultsContainer.contains(e.target)){
            resultsContainer.classList.add('hidden');
        }
    });

    function selectPegawai(id){
        fetch(`/api/pegawai/${id}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('nama_pegawai').value = data.nama;
                document.getElementById('pegawai_id_pns').value = data.id;
                document.getElementById('pegawai_search').value = data.nama;
                document.getElementById('pegawai_search').readOnly = true;
                document.getElementById('pegawai_search').classList.add('bg-gray-100', 'cursor-not-allowed');
                document.getElementById('pegawai_reset').classList.remove('hidden');

                document.getElementById('nip_pegawai').value = data.nip;
                document.getElementById('jabatan_pegawai').value = data.jabatan;
                document.getElementById('masa_kerja_tahun').value = data.masa_kerja_tahun;
                document.getElementById('masa_kerja_bulan').value = data.masa_kerja_bulan;

                sisaCutiGlobal = data.sisa_cuti_tahunan;
                sisaN = data.sisa_cuti_n;
                sisaN1 = data.sisa_cuti_n1;
                sisaN2 = data.sisa_cuti_n2;
                
                document.getElementById('val_n_display').value = sisaN + ' Hari';
                document.getElementById('val_n1_display').value = sisaN1 + ' Hari';
                document.getElementById('val_n2_display').value = sisaN2 + ' Hari';

                updateSisaCutiDisplay();
                resultsContainer.classList.add('hidden');
            });
    }

    const resetBtn = document.getElementById('pegawai_reset');
    if(resetBtn){
        resetBtn.addEventListener('click', function(){
            document.getElementById('nama_pegawai').value = '';
            document.getElementById('pegawai_id_pns').value = '';
            document.getElementById('pegawai_search').value = '';
            document.getElementById('pegawai_search').readOnly = false;
            document.getElementById('pegawai_search').classList.remove('bg-gray-100', 'cursor-not-allowed');
            this.classList.add('hidden');

            document.getElementById('nip_pegawai').value = '';
            document.getElementById('jabatan_pegawai').value = '';
            document.getElementById('masa_kerja_tahun').value = '';
            document.getElementById('masa_kerja_bulan').value = '';
            
            sisaCutiGlobal = 0;
            sisaN = 0;
            sisaN1 = 0;
            sisaN2 = 0;
            document.getElementById('val_n_display').value = '0 Hari';
            document.getElementById('val_n1_display').value = '0 Hari';
            document.getElementById('val_n2_display').value = '0 Hari';

            updateSisaCutiDisplay();
            searchInput.focus();
        });
    }

    const atasanSearchInput = document.getElementById('atasan_search');
    const atasanResultsContainer = document.getElementById('atasan_results');
    let atasanDebounceTimer;

    if(atasanSearchInput && atasanResultsContainer) {
        atasanSearchInput.addEventListener('input', function(e){
            clearTimeout(atasanDebounceTimer);
            const term = e.target.value;
            if(term.length < 2) {
                atasanResultsContainer.classList.add('hidden');
                return;
            }

            atasanDebounceTimer = setTimeout(() => {
                fetch(`/api/pegawai/search?term=${term}&is_atasan=true`)
                    .then(r => r.json())
                    .then(data => {
                        atasanResultsContainer.innerHTML = '';
                        if(data.length > 0){
                            data.forEach(p => {
                                const div = document.createElement('div');
                                div.className = 'px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer text-gray-700 dark:text-gray-200';
                                div.textContent = `${p.nama} - ${p.nip}`;
                                div.onclick = () => selectAtasan(p.id);
                                atasanResultsContainer.appendChild(div);
                            });
                            atasanResultsContainer.classList.remove('hidden');
                        } else {
                            atasanResultsContainer.classList.add('hidden');
                        }
                    });
            }, 300);
        });

        document.addEventListener('click', function(e){
            if(atasanSearchInput && !atasanSearchInput.contains(e.target) && atasanResultsContainer && !atasanResultsContainer.contains(e.target)){
                atasanResultsContainer.classList.add('hidden');
            }
        });
    }

    function selectAtasan(id){
        fetch(`/api/pegawai/${id}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('nama_atasan').value = data.nama;
                document.getElementById('atasan_search').value = data.nama;
                document.getElementById('atasan_search').readOnly = true;
                document.getElementById('atasan_search').classList.add('bg-gray-100', 'cursor-not-allowed');
                document.getElementById('atasan_reset').classList.remove('hidden');

                document.getElementById('nip_atasan').value = data.nip;
                document.getElementById('jabatan_atasan').value = data.jabatan;
                atasanResultsContainer.classList.add('hidden');
            });
    }

    const atasanResetBtn = document.getElementById('atasan_reset');
    if(atasanResetBtn){
        atasanResetBtn.addEventListener('click', function(){
            document.getElementById('nama_atasan').value = '';
            document.getElementById('atasan_search').value = '';
            document.getElementById('atasan_search').readOnly = false;
            document.getElementById('atasan_search').classList.remove('bg-gray-100', 'cursor-not-allowed');
            this.classList.add('hidden');

            document.getElementById('nip_atasan').value = '';
            document.getElementById('jabatan_atasan').value = '';
            atasanSearchInput.focus();
        });
    }

    const jenisCutiSelect = document.querySelector('#modalCreateCuti select[name="form[jenis_cuti]"]');
    const lamaCutiInput = document.getElementById('lama_cuti_pns');
    const sisaCutiContainer = document.getElementById('sisa_cuti_container');
    const sisaCutiDisplay = document.getElementById('sisa_cuti_display');

    if(jenisCutiSelect){
        jenisCutiSelect.addEventListener('change', function(e){
            updateSisaCutiDisplay();
        });
    }

    if(lamaCutiInput){
        lamaCutiInput.addEventListener('input', function(e){
            updateSisaCutiDisplay();
        });
    }

    function updateSisaCutiDisplay(){
        if(!jenisCutiSelect || !sisaCutiContainer ) return;
        
        const selected = jenisCutiSelect.value;
        const sisaCutiHidden = document.getElementById('sisa_cuti_tahunan_hidden');
        
        const catatanN2Hidden = document.getElementById('catatan_n2_hidden');
        const catatanN1Hidden = document.getElementById('catatan_n1_hidden');
        const catatanNHidden = document.getElementById('catatan_n_hidden');
        
        const n2UsedHidden = document.getElementById('n2_used_hidden');
        const n1UsedHidden = document.getElementById('n1_used_hidden');
        const nUsedHidden = document.getElementById('n_used_hidden');

        const lamaCutiValue = parseInt(lamaCutiInput ? lamaCutiInput.value : 0) || 0;
        
        const calcPreview = document.getElementById('calc_preview');
        const calcDetails = document.getElementById('calc_details');

        if(selected === 'Cuti Tahunan'){
            sisaCutiContainer.classList.remove('hidden');
            
            if(lamaCutiValue > 0) {
                let rem = lamaCutiValue;
                
                let usedN2 = Math.min(rem, sisaN2);
                let finalN2 = sisaN2 - usedN2;
                rem -= usedN2;
                
                let usedN1 = Math.min(rem, sisaN1);
                let finalN1 = sisaN1 - usedN1;
                rem -= usedN1;
                
                let usedN = Math.min(rem, sisaN);
                let finalN = sisaN - usedN;
                rem -= usedN;

                if(catatanN2Hidden) catatanN2Hidden.value = finalN2;
                if(catatanN1Hidden) catatanN1Hidden.value = finalN1;
                if(catatanNHidden) catatanNHidden.value = finalN;
                
                if(n2UsedHidden) n2UsedHidden.value = usedN2;
                if(n1UsedHidden) n1UsedHidden.value = usedN1;
                if(nUsedHidden) nUsedHidden.value = usedN;

                if(document.getElementById('val_n2_display')) document.getElementById('val_n2_display').value = finalN2 + ' Hari';
                if(document.getElementById('val_n1_display')) document.getElementById('val_n1_display').value = finalN1 + ' Hari';
                if(document.getElementById('val_n_display')) document.getElementById('val_n_display').value = finalN + ' Hari';

                if(rem > 0) {
                    calcPreview.classList.remove('hidden');
                    calcPreview.className = "mt-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-lg";
                    calcPreview.querySelector('p').className = "text-xs font-semibold text-red-700 dark:text-red-300 mb-2";
                    calcPreview.querySelector('p').textContent = "Peringatan:";
                    
                    calcDetails.innerHTML = `<div class="text-xs text-red-600 dark:text-red-400 font-bold flex items-center p-2"><i class="fas fa-exclamation-triangle mr-2"></i> Jumlah cuti yang diajukan melebihi sisa cuti yang tersedia sebesar ${rem} hari.</div>`;
                } else {
                     calcPreview.classList.add('hidden');
                     calcDetails.innerHTML = '';
                }
            } else {
                calcPreview.classList.add('hidden');
                if(catatanN2Hidden) catatanN2Hidden.value = sisaN2;
                if(catatanN1Hidden) catatanN1Hidden.value = sisaN1;
                if(catatanNHidden) catatanNHidden.value = sisaN;
                
                if(document.getElementById('val_n2_display')) document.getElementById('val_n2_display').value = sisaN2 + ' Hari';
                if(document.getElementById('val_n1_display')) document.getElementById('val_n1_display').value = sisaN1 + ' Hari';
                if(document.getElementById('val_n_display')) document.getElementById('val_n_display').value = sisaN + ' Hari';

                if(n2UsedHidden) n2UsedHidden.value = 0;
                if(n1UsedHidden) n1UsedHidden.value = 0;
                if(nUsedHidden) nUsedHidden.value = 0;
            }

            const totalSisa = Math.max(0, sisaCutiGlobal - lamaCutiValue);
            if(sisaCutiHidden) sisaCutiHidden.value = totalSisa;
        } else {
            sisaCutiContainer.classList.add('hidden');
            if(sisaCutiHidden) sisaCutiHidden.value = '';
            
            if(catatanN2Hidden) catatanN2Hidden.value = '';
            if(catatanN1Hidden) catatanN1Hidden.value = '';
            if(catatanNHidden) catatanNHidden.value = '';
            if(n2UsedHidden) n2UsedHidden.value = '';
            if(n1UsedHidden) n1UsedHidden.value = '';
            if(nUsedHidden) nUsedHidden.value = '';
        }
    }

    const modal = document.getElementById('modalCreateCuti');
    if(modal) {
        modal.addEventListener('modal-closed', function() {
            if(searchInput) {
                searchInput.value = '';
                searchInput.readOnly = false;
                searchInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
            }
            if(resultsContainer) {
                resultsContainer.classList.add('hidden');
            }
            const pegawaiResetBtn = document.getElementById('pegawai_reset');
            if(pegawaiResetBtn) {
                pegawaiResetBtn.classList.add('hidden');
            }

            if(atasanSearchInput) {
                atasanSearchInput.value = '';
                atasanSearchInput.readOnly = false;
                atasanSearchInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
            }
            if(atasanResultsContainer) {
                atasanResultsContainer.classList.add('hidden');
            }
            const atasanResetBtn = document.getElementById('atasan_reset');
            if(atasanResetBtn) {
                atasanResetBtn.classList.add('hidden');
            }

            if(sisaCutiContainer) {
                sisaCutiContainer.classList.add('hidden');
            }
            const calcPreview = document.getElementById('calculation_preview');
            if(calcPreview) {
                calcPreview.classList.add('hidden');
            }
            const calcDetails = document.getElementById('calc_details');
            if(calcDetails) {
                calcDetails.innerHTML = '';
            }

            const valN2Display = document.getElementById('val_n2_display');
            const valN1Display = document.getElementById('val_n1_display');
            const valNDisplay = document.getElementById('val_n_display');
            if(valN2Display) valN2Display.value = '0 Hari';
            if(valN1Display) valN1Display.value = '0 Hari';
            if(valNDisplay) valNDisplay.value = '0 Hari';
            
            const ketN2 = document.querySelector('textarea[name="form[catatan_n2_keterangan]"]');
            const ketN1 = document.querySelector('textarea[name="form[catatan_n1_keterangan]"]');
            const ketN = document.querySelector('textarea[name="form[catatan_n_keterangan]"]');
            if(ketN2) ketN2.value = '';
            if(ketN1) ketN1.value = '';
            if(ketN) ketN.value = '';

            sisaCutiGlobal = 0;
            sisaN = 0;
            sisaN1 = 0;
            sisaN2 = 0;
        });
    }
})();

function submitCutiForm(e){
    e.preventDefault();
    const form = document.getElementById('cutiForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true; 
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    
    const formData = new FormData(form);
    
    fetch(form.action,{
        method:'POST',
        body:formData,
        headers:{
            'X-Requested-With':'XMLHttpRequest',
            'Accept':'application/json'
        }
    })
    .then(r=>r.json().then(d=>({ok:r.ok,status:r.status,data:d})))
    .then(res=>{
        if(!res.ok){
            notify('error', 'Gagal', res.data.message || 'Validasi gagal. Periksa kembali data yang diinput.', false);
        }else if(res.data.success){
            notify('success', 'Berhasil', res.data.message);
            closeModal('modalCreateCuti');
            form.reset();
            openPreviewPDFPNS(res.data.file_url, res.data.nomor_surat, res.data.surat_id, 'Surat Izin Cuti', new Date().toISOString().slice(0,10));
        }
    })
    .catch(err=>notify('error', 'Gagal', 'Terjadi kesalahan sistem: '+err.message, false))
    .finally(()=>{
        submitBtn.disabled=false; 
        submitBtn.innerHTML='Simpan';
    });
}
</script>