<div id="modalCreateCutiPPPK" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modalTitlePPPK">Buat Surat Izin Cuti PPPK</h3>
            <button onclick="closeModal('modalCreateCutiPPPK')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form action="{{ route('template-surat.cuti.store') }}" method="POST" id="cutiFormPPPK" onsubmit="submitCutiFormPPPK(event)">
            @csrf
            <input type="hidden" name="template_id" id="template_surat_cuti_pppk">
            <input type="hidden" name="kategori" id="kategori_cuti_pppk" value="PPPK">

            <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">
                
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Surat <span class="text-red-500">*</span></label>
                        <input type="date" name="form[tanggal_surat]" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">I. DATA PEGAWAI</h4>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Pegawai <span class="text-red-500">*</span></label>
                                <input type="text" name="form[nama]" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">NIP <span class="text-red-500">*</span></label>
                                <input type="text" name="form[nip]" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Jabatan <span class="text-red-500">*</span></label>
                                <input type="text" name="form[jabatan]" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Masa Kerja</label>
                                <div class="flex items-center space-x-2">
                                    <input type="number" name="form[masa_kerja_tahun]" min="0" placeholder="0"
                                        class="w-24 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" />
                                    <span class="text-sm text-gray-600 dark:text-gray-300">tahun</span>
                                    <input type="number" name="form[masa_kerja_bulan]" min="0" max="11" placeholder="0"
                                        class="w-24 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" />
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
                                <option value="Cuti Sakit">2. Cuti Sakit</option>
                                <option value="Cuti Melahirkan">3. Cuti Melahirkan</option>
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
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Jelaskan Alasan Pengajuan Cuti <span class="text-red-500">*</span></label>
                            <textarea name="form[alasan]" required rows="3" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
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
                                <input type="number" name="form[lama_cuti]" required min="1" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
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

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">V. ALAMAT SELAMA MENJALANKAN CUTI</h4>
                    </div>
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="form[alamat]" required rows="3" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Nomor Telepon <span class="text-red-500">*</span></label>
                            <input type="tel" name="form[telp]" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">VI. PERTIMBANGAN ATASAN LANGSUNG</h4>
                    </div>
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Keputusan Atasan</label>
                            <select name="form[atasan_setuju]" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="DISETUJUI">DISETUJUI</option>
                                <option value="PERUBAHAN">PERUBAHAN</option>
                                <option value="DITANGGUHKAN">DITANGGUHKAN</option>
                                <option value="TIDAK DISETUJUI">TIDAK DISETUJUI</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Atasan Langsung</label>
                                <input type="text" name="form[nama_atasan]" placeholder="Contoh: LILIK SUBAGYO, S.Kep, Ns." class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">NIP Atasan</label>
                                <input type="text" name="form[nip_atasan]" placeholder="Contoh: 19830804 201001 1 016" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Jabatan Atasan</label>
                            <input type="text" name="form[jabatan_atasan]" placeholder="Contoh: Kepala Seksi Keperawatan dan Penunjang Non Medis" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">VII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI</h4>
                    </div>
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Keputusan Pejabat</label>
                            <select name="form[pejabat_keputusan]" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="DISETUJUI">DISETUJUI</option>
                                <option value="PERUBAHAN">PERUBAHAN</option>
                                <option value="DITANGGUHKAN">DITANGGUHKAN</option>
                                <option value="TIDAK DISETUJUI">TIDAK DISETUJUI</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Pejabat Berwenang</label>
                                <input type="text" name="form[nama_pejabat]" placeholder="Contoh: Dr. dr. KINIK DARSONO, M.Pd.Ked." class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">NIP Pejabat</label>
                                <input type="text" name="form[nip_pejabat]" placeholder="Contoh: 19710415 200903 1 001" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Jabatan Pejabat Berwenang</label>
                            <input type="text" name="form[jabatan_pejabat]" placeholder="Contoh: Direktur RSUD dr. Soeratno Gemolong Kabupaten Gemolong" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

            </div>

            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('cutiFormPPPK').reset()" class="px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    Reset
                </button>
                <button type="submit" class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function submitCutiFormPPPK(e){
    e.preventDefault();
    const form = document.getElementById('cutiFormPPPK');
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
            alert(res.data.message || 'Validasi gagal. Periksa kembali data yang diinput.');
        }else if(res.data.success){
            closeModal('modalCreateCutiPPPK');
            form.reset();
            openPreviewPDF(res.data.file_url, res.data.nomor_surat, res.data.surat_id, 'Surat Izin Cuti PPPK', new Date().toISOString().slice(0,10));
        }
    })
    .catch(err=>alert('Error: '+err.message))
    .finally(()=>{
        submitBtn.disabled=false; 
        submitBtn.innerHTML='Simpan';
    });
}
</script>
