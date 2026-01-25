<div id="modalEditCuti" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalEditCuti')"></div>

        <div
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-4xl w-full max-h-[95vh] overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700">

            <div
                class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white truncate pr-4">Edit Draft
                    Izin Cuti</h3>
                <button onclick="closeModal('modalEditCuti')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-times text-base sm:text-lg"></i>
                </button>
            </div>

            <form id="editCutiForm" onsubmit="submitEditCutiForm(event)" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_cuti_id_surat">
                <input type="hidden" name="kategori" id="edit_cuti_kategori">
                <input type="hidden" name="form[pegawai_id]" id="edit_pegawai_id">

                <input type="hidden" name="form[catatan_n2]" id="edit_catatan_n2_hidden">
                <input type="hidden" name="form[catatan_n1]" id="edit_catatan_n1_hidden">
                <input type="hidden" name="form[catatan_n]" id="edit_catatan_n_hidden">
                <input type="hidden" name="form[n2_used]" id="edit_n2_used_hidden">
                <input type="hidden" name="form[n1_used]" id="edit_n1_used_hidden">
                <input type="hidden" name="form[n_used]" id="edit_n_used_hidden">
                <input type="hidden" name="form[sisa_cuti_tahunan]" id="edit_sisa_cuti_tahunan_hidden">

                <div class="p-6 space-y-6 overflow-y-auto flex-1 custom-scrollbar">

                    <div
                        class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Jenis Pegawai</label>
                                <input type="text" id="edit_cuti_kategori_display" disabled
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Tempat Surat <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="form[tempat_surat]" id="edit_cuti_tempat_surat" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Tanggal Surat <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="form[tanggal_surat]" id="edit_cuti_tanggal_surat" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">I. DATA PEGAWAI</h4>
                        </div>
                        <div class="p-4 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300 text-sm">Nama Lengkap
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" name="form[nama]" id="edit_cuti_nama" readonly
                                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300 text-sm">NIP <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="form[nip]" id="edit_cuti_nip" readonly
                                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300 text-sm">Jabatan <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="form[jabatan]" id="edit_cuti_jabatan" readonly
                                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300 text-sm">Unit Kerja <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="form[unit]" id="edit_cuti_unit" readonly
                                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300 text-sm">Masa
                                        Kerja <span class="text-red-500">*</span></label>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="form[masa_kerja_tahun]"
                                                id="edit_cuti_masa_kerja_tahun" readonly
                                                class="w-16 sm:w-20 px-3 py-2 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed" />
                                            <span
                                                class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Tahun</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="form[masa_kerja_bulan]"
                                                id="edit_cuti_masa_kerja_bulan" readonly
                                                class="w-16 sm:w-20 px-3 py-2 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed" />
                                            <span
                                                class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Bulan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">II. JENIS CUTI YANG DIAMBIL</h4>
                        </div>
                        <div class="p-4">
                            <label class="block mb-2 text-gray-700 dark:text-gray-300 text-sm">Pilih Jenis Cuti <span
                                    class="text-red-500">*</span></label>
                            <select name="form[jenis_cuti]" id="edit_cuti_jenis" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="">-- Pilih Jenis Cuti --</option>
                                <option value="Cuti Tahunan">1. Cuti Tahunan</option>
                                <option value="Cuti Besar">2. Cuti Besar</option>
                                <option value="Cuti Sakit">3. Cuti Sakit</option>
                                <option value="Cuti Melahirkan">4. Cuti Melahirkan</option>
                                <option value="Cuti Karena Alasan Penting">5. Cuti Karena Alasan Penting</option>
                                <option value="Cuti di Luar Tanggungan Negara">6. Cuti di Luar Tanggungan Negara
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">III. ALASAN CUTI</h4>
                        </div>
                        <div class="p-4">
                            <textarea name="form[alasan]" id="edit_cuti_alasan" required rows="3"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">IV. LAMANYA CUTI</h4>
                        </div>
                        <div class="p-4 space-y-4 text-sm">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Lama Cuti (Hari) <span
                                            class="text-red-500">*</span></label>
                                    <input type="number" name="form[lama_cuti]" id="edit_cuti_lama" required min="1"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Mulai Tanggal <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="form[mulai]" id="edit_cuti_mulai" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Sampai Tanggal <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="form[sampai]" id="edit_cuti_sampai" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="edit_sisa_cuti_container"
                        class="hidden border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">V. CATATAN CUTI</h4>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-800/50">
                            <input type="hidden" name="form[catatan_n2]" id="edit_catatan_n2_hidden">
                            <input type="hidden" name="form[catatan_n1]" id="edit_catatan_n1_hidden">
                            <input type="hidden" name="form[catatan_n]" id="edit_catatan_n_hidden">
                            <input type="hidden" name="form[n2_used]" id="edit_n2_used_hidden">
                            <input type="hidden" name="form[n1_used]" id="edit_n1_used_hidden">
                            <input type="hidden" name="form[n_used]" id="edit_n_used_hidden">
                            <input type="hidden" name="form[sisa_cuti_tahunan]" id="edit_sisa_cuti_tahunan_hidden">

                            <div id="edit_catatan_pns" class="hidden">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block mb-2 text-gray-700 dark:text-gray-300 text-xs">Sisa Cuti
                                            N-2</label>
                                        <input type="text" id="edit_val_n2_display" readonly
                                            class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-gray-700 dark:text-gray-300 text-xs">Sisa Cuti
                                            N-1</label>
                                        <input type="text" id="edit_val_n1_display" readonly
                                            class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-gray-700 dark:text-gray-300 text-xs">Sisa Cuti
                                            N</label>
                                        <input type="text" id="edit_val_n_display" readonly
                                            class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                    <textarea name="form[catatan_n2_keterangan]" id="edit_catatan_n2_keterangan"
                                        rows="2" placeholder="Keterangan N-2"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm"></textarea>
                                    <textarea name="form[catatan_n1_keterangan]" id="edit_catatan_n1_keterangan"
                                        rows="2" placeholder="Keterangan N-1"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm"></textarea>
                                    <textarea name="form[catatan_n_keterangan]" id="edit_catatan_n_keterangan" rows="2"
                                        placeholder="Keterangan N"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm"></textarea>
                                </div>
                            </div>

                            <div id="edit_catatan_umum" class="hidden">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block mb-2 text-gray-700 dark:text-gray-300 text-xs">Sisa Cuti
                                            Tahunan</label>
                                        <input type="text" id="edit_val_umum_display" readonly
                                            class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                    </div>
                                    <div id="edit_keterangan_umum_container">
                                        <label class="block mb-2 text-gray-700 dark:text-gray-300 text-xs">Keterangan
                                            (Opsional)</label>
                                        <textarea name="form[catatan_n_keterangan_umum]"
                                            id="edit_catatan_umum_keterangan" rows="2" placeholder="Keterangan"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div id="edit_calc_preview"
                                class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-lg hidden transition-all duration-300">
                                <p class="text-xs font-semibold text-red-700 dark:text-red-300 mb-2">Peringatan:</p>
                                <div class="space-y-1 text-xs text-red-600 dark:text-red-400" id="edit_calc_details">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">VI. ALAMAT SELAMA MENJALANKAN CUTI</h4>
                        </div>
                        <div class="p-4 space-y-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300 text-sm">Alamat Lengkap <span
                                        class="text-red-500">*</span></label>
                                <textarea name="form[alamat]" id="edit_cuti_alamat" required rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300 text-sm">Nomor Telepon <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="form[telp]" id="edit_cuti_telp" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">VII. PERTIMBANGAN ATASAN LANGSUNG</h4>
                        </div>
                        <div class="p-4 space-y-4">
                            <div class="relative">
                                <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300 text-sm">Cari Atasan
                                    Langsung</label>
                                <div class="relative">
                                    <input type="text" id="edit_atasan_search"
                                        placeholder="Ketik nama atau NIP atasan..."
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-search text-sm"></i>
                                    </div>
                                </div>
                                <div id="edit_atasan_results"
                                    class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-xl hidden max-h-48 overflow-y-auto">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Nama
                                        Atasan</label>
                                    <input type="text" name="form[nama_atasan]" id="edit_cuti_atasan_nama" readonly
                                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">NIP
                                        Atasan</label>
                                    <input type="text" name="form[nip_atasan]" id="edit_cuti_atasan_nip" readonly
                                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                </div>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Jabatan
                                    Atasan</label>
                                <input type="text" name="form[jabatan_atasan]" id="edit_cuti_atasan_jabatan" readonly
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                            </div>
                        </div>
                    </div>

                </div>

                <div
                    class="px-4 sm:px-6 py-4 sm:py-5 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex flex-col-reverse sm:flex-row justify-end gap-3 rounded-b-xl">
                    <button type="button" onclick="resetEditCutiForm()"
                        class="w-full sm:w-auto px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all font-normal">
                        Reset
                    </button>
                    <button type="submit" id="submitEditCutiBtn"
                        class="w-full sm:w-auto px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-normal transition-all">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const atasanSearch = document.getElementById('edit_atasan_search');
        const atasanResults = document.getElementById('edit_atasan_results');

        if (atasanSearch) {
            atasanSearch.addEventListener('input', async function () {
                const term = this.value;
                if (term.length < 2) {
                    atasanResults.classList.add('hidden');
                    return;
                }

                try {
                    const response = await fetch(`/api/pegawai/search?term=${encodeURIComponent(term)}&is_atasan=true`);
                    const data = await response.json();

                    atasanResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(p => {
                            const div = document.createElement('div');
                            div.className = 'px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 transition-all';
                            const details = p.nip ? `${p.nip} | ${p.jabatan || '-'}` : (p.jabatan || '-');
                            div.innerHTML = `
                                <div class="font-semibold text-gray-900 dark:text-gray-100">${p.nama}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">${details}</div>
                            `;
                            div.onclick = () => {
                                document.getElementById('edit_cuti_atasan_nama').value = p.nama;
                                document.getElementById('edit_cuti_atasan_nip').value = p.nip || '-';
                                document.getElementById('edit_cuti_atasan_jabatan').value = p.jabatan || '-';
                                atasanResults.classList.add('hidden');
                                atasanSearch.value = p.nama;

                                if (!isInitializingCuti && window.formDirtyMonitors && window.formDirtyMonitors['editCutiForm']) {
                                    window.formDirtyMonitors['editCutiForm'].check();
                                }
                            };
                            atasanResults.appendChild(div);
                        });
                        atasanResults.classList.remove('hidden');
                    }
                } catch (error) { console.error('Error searching atasan:', error); }
            });

            document.addEventListener('click', e => {
                if (!atasanSearch.contains(e.target) && !atasanResults.contains(e.target)) atasanResults.classList.add('hidden');
            });
        }
    });

    let baselineN = 0, baselineN1 = 0, baselineN2 = 0, baselineSisaTahunan = 0;
    let editModeCuti = false;
    let currentCutiDraftData = null;
    let isInitializingCuti = false;

    async function openEditCutiModal(id) {
        try {
            const response = await fetch(`/cuti/${id}/edit`);
            const result = await response.json();
            if (!result.success) { notify('error', 'Gagal', 'Gagal mengambil data draft'); return; }

            currentCutiDraftData = result.data;
            await populateEditCutiForm(currentCutiDraftData);
            openModal('modalEditCuti');
        } catch (error) {
            console.error('Error fetching draft data:', error);
            notify('error', 'Gagal', 'Terjadi kesalahan saat mengambil data');
        }
    }

    async function populateEditCutiForm(data) {
        isInitializingCuti = true;
        const cuti = data.cuti;
        const formData = cuti.form_data;

        document.getElementById('edit_cuti_id_surat').value = data.id_surat;
        document.getElementById('edit_cuti_kategori').value = cuti.kategori;
        document.getElementById('edit_cuti_kategori_display').value = cuti.kategori;

        const pegId = formData.pegawai_id || formData.pegawai_id_pns || formData.pegawai_id_pppk || formData.pegawai_id_nonasn;
        document.getElementById('edit_pegawai_id').value = pegId || '';

        document.getElementById('edit_cuti_tempat_surat').value = formData.tempat_surat || 'Sragen';
        document.getElementById('edit_cuti_tanggal_surat').value = formData.tanggal_surat ? formData.tanggal_surat.substring(0, 10) : '';

        document.getElementById('edit_cuti_nama').value = formData.nama || '';
        document.getElementById('edit_cuti_nip').value = formData.nip || '';
        document.getElementById('edit_cuti_jabatan').value = formData.jabatan || '';
        document.getElementById('edit_cuti_unit').value = formData.unit || formData.unit_kerja || 'RSUD dr. Soeratno Gemolong';
        document.getElementById('edit_cuti_masa_kerja_tahun').value = formData.masa_kerja_tahun || '';
        document.getElementById('edit_cuti_masa_kerja_bulan').value = formData.masa_kerja_bulan || '';
        document.getElementById('edit_cuti_telp').value = formData.telp || formData.no_telp || '';

        document.getElementById('edit_cuti_jenis').value = formData.jenis_cuti || '';
        document.getElementById('edit_cuti_alasan').value = formData.alasan || formData.alasan_cuti || '';
        document.getElementById('edit_cuti_mulai').value = formData.mulai ? formData.mulai.substring(0, 10) : (formData.tanggal_mulai ? formData.tanggal_mulai.substring(0, 10) : '');
        document.getElementById('edit_cuti_sampai').value = formData.sampai ? formData.sampai.substring(0, 10) : (formData.tanggal_selesai ? formData.tanggal_selesai.substring(0, 10) : '');
        document.getElementById('edit_cuti_lama').value = formData.lama_cuti || '';
        document.getElementById('edit_cuti_alamat').value = formData.alamat || formData.alamat_cuti || '';

        if (pegId) {
            const pRes = await fetch(`/api/pegawai/${pegId}`);
            const pInfo = await pRes.json();

            baselineN = (pInfo.sisa_cuti_n || 0) + (parseInt(formData.n_used) || 0);
            baselineN1 = (pInfo.sisa_cuti_n1 || 0) + (parseInt(formData.n1_used) || 0);
            baselineN2 = (pInfo.sisa_cuti_n2 || 0) + (parseInt(formData.n2_used) || 0);
            baselineSisaTahunan = (pInfo.sisa_cuti_tahunan || 0) + (parseInt(formData.lama_cuti) || 0);
        }

        editModeCuti = true;

        const sisaCutiContainer = document.getElementById('edit_sisa_cuti_container');
        const isTahunan = (formData.jenis_cuti === 'Cuti Tahunan');

        if (isTahunan) {
            sisaCutiContainer.classList.remove('hidden');

            const catPNS = document.getElementById('edit_catatan_pns');
            const catUmum = document.getElementById('edit_catatan_umum');
            const ketUmum = document.getElementById('edit_keterangan_umum_container');

            if (cuti.kategori === 'PNS') {
                catPNS.classList.remove('hidden');
                catUmum.classList.add('hidden');
                document.getElementById('edit_catatan_n2_keterangan').value = formData.catatan_n2_keterangan || '';
                document.getElementById('edit_catatan_n1_keterangan').value = formData.catatan_n1_keterangan || '';
                document.getElementById('edit_catatan_n_keterangan').value = formData.catatan_n_keterangan || '';
            } else {
                catPNS.classList.add('hidden');
                catUmum.classList.remove('hidden');

                if (cuti.kategori === 'PPPK') {
                    ketUmum.classList.add('hidden');
                } else {
                    ketUmum.classList.remove('hidden');
                    document.getElementById('edit_catatan_umum_keterangan').value = formData.catatan_n_keterangan || '';
                }
            }

            updateEditSisaCutiDisplay();
        } else {
            sisaCutiContainer.classList.add('hidden');
        }

        document.getElementById('edit_cuti_atasan_nama').value = formData.nama_atasan || formData.atasan_langsung_nama || '';
        document.getElementById('edit_cuti_atasan_nip').value = formData.nip_atasan || formData.atasan_langsung_nip || '';
        document.getElementById('edit_cuti_atasan_jabatan').value = formData.jabatan_atasan || formData.atasan_langsung_jabatan || '';

        window.originalFormData = formData;

        if (typeof FormDirtyMonitor !== 'undefined') {
            if (window.formDirtyMonitors && window.formDirtyMonitors['editCutiForm']) {
                window.formDirtyMonitors['editCutiForm'].destroy();
            }
            new FormDirtyMonitor('editCutiForm', 'submitEditCutiBtn');
        }

        isInitializingCuti = false;
    }

    function resetEditCutiForm() {
        if (currentCutiDraftData) {
            populateEditCutiForm(currentCutiDraftData);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const jenisSelect = document.getElementById('edit_cuti_jenis');
        const lamaInput = document.getElementById('edit_cuti_lama');

        if (jenisSelect) {
            jenisSelect.addEventListener('change', () => {
                const sisaCutiContainer = document.getElementById('edit_sisa_cuti_container');
                if (jenisSelect.value === 'Cuti Tahunan') {
                    sisaCutiContainer.classList.remove('hidden');
                    updateEditSisaCutiDisplay();
                } else {
                    sisaCutiContainer.classList.add('hidden');
                }
            });
        }

        if (lamaInput) {
            lamaInput.addEventListener('input', updateEditSisaCutiDisplay);
        }
    });

    function updateEditSisaCutiDisplay() {
        if (!editModeCuti) return;

        const katEl = document.getElementById('edit_cuti_kategori');
        const lamaEl = document.getElementById('edit_cuti_lama');
        if (!katEl || !lamaEl) return;

        const kategori = katEl.value;
        const lamaCutiValue = parseInt(lamaEl.value) || 0;

        const calcPreview = document.getElementById('edit_calc_preview');
        const calcDetails = document.getElementById('edit_calc_details');

        if (kategori === 'PNS') {
            let rem = lamaCutiValue;
            let usedN2 = Math.min(rem, baselineN2);
            let finalN2 = baselineN2 - usedN2;
            rem -= usedN2;

            let usedN1 = Math.min(rem, baselineN1);
            let finalN1 = baselineN1 - usedN1;
            rem -= usedN1;

            let usedN = Math.min(rem, baselineN);
            let finalN = baselineN - usedN;
            rem -= usedN;

            document.getElementById('edit_val_n2_display').value = finalN2 + ' Hari';
            document.getElementById('edit_val_n1_display').value = finalN1 + ' Hari';
            document.getElementById('edit_val_n_display').value = finalN + ' Hari';

            document.getElementById('edit_catatan_n2_hidden').value = finalN2;
            document.getElementById('edit_catatan_n1_hidden').value = finalN1;
            document.getElementById('edit_catatan_n_hidden').value = finalN;

            document.getElementById('edit_n2_used_hidden').value = usedN2;
            document.getElementById('edit_n1_used_hidden').value = usedN1;
            document.getElementById('edit_n_used_hidden').value = usedN;

            if (rem > 0) {
                calcPreview.classList.remove('hidden');
                calcDetails.innerHTML = `<div class="flex items-center"><i class="fas fa-exclamation-triangle mr-2"></i> Jumlah cuti melebihi sisa yang tersedia sebesar ${rem} hari</div>`;
            } else {
                calcPreview.classList.add('hidden');
            }
        } else {
            const finalSisa = Math.max(0, baselineSisaTahunan - lamaCutiValue);
            document.getElementById('edit_sisa_cuti_tahunan_hidden').value = finalSisa;

            if (document.getElementById('edit_val_umum_display')) {
                document.getElementById('edit_val_umum_display').value = finalSisa + ' Hari';
            }

            if (lamaCutiValue > baselineSisaTahunan) {
                calcPreview.classList.remove('hidden');
                calcDetails.innerHTML = `<div class="flex items-center"><i class="fas fa-exclamation-triangle mr-2"></i> Jumlah cuti melebihi sisa yang tersedia</div>`;
            } else {
                calcPreview.classList.add('hidden');
            }
        }
    }

    function submitEditCutiForm(event) {
        event.preventDefault();
        const form = document.getElementById('editCutiForm');
        const id = document.getElementById('edit_cuti_id_surat').value;
        const formData = new FormData(form);

        const currentFields = {};
        for (let [key, value] of formData.entries()) {
            if (key.startsWith('form[')) {
                const actualKey = key.substring(5, key.length - 1);
                currentFields[actualKey] = value;
            }
        }

        if (currentFields['catatan_n_keterangan_umum']) {
            currentFields['catatan_n_keterangan'] = currentFields['catatan_n_keterangan_umum'];
            delete currentFields['catatan_n_keterangan_umum'];
        }

        const mergedData = { ...window.originalFormData, ...currentFields };
        const finalData = new FormData();
        finalData.append('_token', formData.get('_token'));
        finalData.append('_method', 'PUT');
        finalData.append('kategori', formData.get('kategori'));
        for (let [key, value] of Object.entries(mergedData)) {
            finalData.append(`form[${key}]`, value);
        }

        const submitBtn = document.getElementById('submitEditCutiBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui';

        fetch(`/cuti/${id}`, {
            method: 'POST', body: finalData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    closeModal('modalEditCuti');
                    notify('success', 'Berhasil', res.message);

                    window.dispatchEvent(new CustomEvent('update-cuti-draft', { detail: res.data }));

                    setTimeout(() => {
                        window.openDraftPreview(res.data);
                    }, 500);
                } else notify('error', 'Gagal', res.message);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Perbarui';
                editModeCuti = false;
            });
    }
</script>