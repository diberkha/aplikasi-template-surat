<div id="modalEditUndangan" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalEditUndangan')"></div>

        <div
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-3xl w-full max-h-[95vh] overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700">

            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/50 z-10">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Draft Surat Undangan</h3>
                <button onclick="closeModal('modalEditUndangan')"
                    class="p-2 -mr-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form id="editUndanganForm" onsubmit="submitEditUndanganForm(event)" class="flex flex-col overflow-hidden flex-1" x-data="{ openEditHari: false, editHariAcara: '', editHariAcaraLabel: '', searchEditHari: '', editHariOptions: [
                { value: 'Senin', label: 'Senin' },
                { value: 'Selasa', label: 'Selasa' },
                { value: 'Rabu', label: 'Rabu' },
                { value: 'Kamis', label: 'Kamis' },
                { value: 'Jumat', label: 'Jumat' },
                { value: 'Sabtu', label: 'Sabtu' },
                { value: 'Minggu', label: 'Minggu' }
            ] }">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_undangan_id_surat">

                <div class="p-6 space-y-6 overflow-y-auto flex-1 custom-scrollbar">

                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Nomor Surat <span
                                        class="text-red-500">*</span></label>
                                <div class="flex items-center gap-2 w-full">
                                    <input type="text" id="edit_nomor_surat_part1"
                                        oninput="combineEditNomorSuratUndangan(); if(window.formDirtyMonitors && window.formDirtyMonitors['editUndanganForm']) window.formDirtyMonitors['editUndanganForm'].check();"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                        required>
                                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                    <input type="text" id="edit_nomor_surat_part2"
                                        oninput="combineEditNomorSuratUndangan(); if(window.formDirtyMonitors && window.formDirtyMonitors['editUndanganForm']) window.formDirtyMonitors['editUndanganForm'].check();"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                        required>
                                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                    <input type="text" id="edit_nomor_surat_part3"
                                        oninput="combineEditNomorSuratUndangan(); if(window.formDirtyMonitors && window.formDirtyMonitors['editUndanganForm']) window.formDirtyMonitors['editUndanganForm'].check();"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                        required>
                                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                    <input type="text" id="edit_nomor_surat_part4"
                                        oninput="combineEditNomorSuratUndangan(); if(window.formDirtyMonitors && window.formDirtyMonitors['editUndanganForm']) window.formDirtyMonitors['editUndanganForm'].check();"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                        required>
                                </div>
                                <input type="hidden" name="nomor_surat" id="edit_nomor_surat_combined">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Nomor surat tidak boleh sama dengan surat yang sudah ada
                                </p>
                            </div>

                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Lampiran</label>
                                <input type="text" name="lampiran" id="edit_undangan_lampiran"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Hal <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="hal" id="edit_undangan_hal" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Kepada <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="kepada" id="edit_undangan_kepada" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Tempat <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="tempat_dibuat" id="edit_undangan_tempat_dibuat" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Surat <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_dibuat" id="edit_undangan_tanggal_dibuat" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Informasi Kegiatan</h4>

                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Kegiatan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama_kegiatan" id="edit_undangan_nama_kegiatan" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Hari <span
                                            class="text-red-500">*</span></label>
                                    <input type="hidden" name="hari_acara" :value="editHariAcara" required>
                                    <input type="text" x-model="editHariAcaraLabel" readonly
                                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_acara" id="edit_undangan_tanggal_acara" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Jam Mulai <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="jam_mulai" id="edit_undangan_jam_mulai" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Jam Selesai</label>
                                    <input type="text" name="jam_selesai" id="edit_undangan_jam_selesai"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Keterangan Waktu</label>
                                    <input type="text" name="keterangan_waktu" id="edit_undangan_keterangan_waktu" placeholder="Contoh: WIB"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Tempat <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="tempat_acara" id="edit_undangan_tempat_acara" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Keperluan</label>
                                <textarea name="keperluan" id="edit_undangan_keperluan" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Tertanda</h4>

                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama <span
                                            class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <input type="text" id="edit_tertanda_search" autocomplete="off" required
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 transition-all">
                                        <button type="button" id="edit_tertanda_reset"
                                            class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                            <i class="fas fa-times-circle text-lg"></i>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Ketik minimal 2 karakter
                                    </p>
                                    <input type="hidden" name="nama_tertanda" id="edit_nama_tertanda">
                                    <div id="edit_tertanda_results"
                                        class="hidden absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto mt-1">
                                    </div>
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">NIP <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="nip_tertanda" id="edit_nip_tertanda" readonly
                                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                </div>
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Jabatan</label>
                                <input type="text" name="jabatan_tertanda" id="edit_jabatan_tertanda" readonly
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                            </div>
                        </div>
                    </div>

                </div>

                <div
                    class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3 bg-gray-50 dark:bg-gray-700/50">
                    <button type="button" onclick="resetEditUndanganForm()"
                        class="px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                        Reset
                    </button>
                    <button type="submit" id="submitEditUndanganBtn"
                        class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-normal transition-colors">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentUndanganDraftData = null;
    let currentEditUndanganId = null;

    function combineEditNomorSuratUndangan() {
        const part1 = document.getElementById('edit_nomor_surat_part1')?.value || '';
        const part2 = document.getElementById('edit_nomor_surat_part2')?.value || '';
        const part3 = document.getElementById('edit_nomor_surat_part3')?.value || '';
        const part4 = document.getElementById('edit_nomor_surat_part4')?.value || '';
        const combined = `${part1}/${part2}/${part3}/${part4}`;
        const hiddenInput = document.getElementById('edit_nomor_surat_combined');
        if (hiddenInput) {
            hiddenInput.value = combined;
        }
    }

    function getHariIndonesia(dateStr) {
        if (!dateStr) {
            return '';
        }

        const dateObj = new Date(`${dateStr}T00:00:00`);
        if (Number.isNaN(dateObj.getTime())) {
            return '';
        }

        const hariList = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return hariList[dateObj.getDay()];
    }

    function initEditHariAcaraAutoFill() {
        const tanggalInput = document.getElementById('edit_undangan_tanggal_acara');
        const formEl = document.querySelector('#modalEditUndangan form');

        if (!tanggalInput || !formEl) {
            return;
        }

        if (tanggalInput.dataset.hariAutofill === '1') {
            return;
        }

        tanggalInput.dataset.hariAutofill = '1';

        const applyHari = () => {
            const hari = getHariIndonesia(tanggalInput.value);
            const hariHidden = formEl.querySelector('input[name="hari_acara"]');
            const hariDisplay = formEl.querySelector('input[x-model="editHariAcaraLabel"]');

            if (hariHidden) {
                hariHidden.value = hari;
            }

            if (hariDisplay) {
                hariDisplay.value = hari;
            }

            if (hari && formEl.__x) {
                const alpineData = formEl.__x.$data;
                alpineData.editHariAcara = hari;
                alpineData.editHariAcaraLabel = hari;
            }
        };

        tanggalInput.addEventListener('change', applyHari);
        tanggalInput.addEventListener('input', applyHari);
        applyHari();
    }

    document.addEventListener('DOMContentLoaded', initEditHariAcaraAutoFill);

    async function openEditUndanganModal(id) {
        try {
            currentEditUndanganId = id;
            const response = await fetch("{{ url('surat-undangan') }}/" + id + "/edit");
            const result = await response.json();

            if (!result.success) {
                notify('error', 'Gagal', 'Gagal mengambil data draft');
                return;
            }

            if (window.formDirtyMonitors && window.formDirtyMonitors['editUndanganForm']) {
                window.formDirtyMonitors['editUndanganForm'].destroy();
            }

            currentUndanganDraftData = result.data;
            openModal('modalEditUndangan');
            
            setTimeout(() => {
                populateEditUndanganForm(currentUndanganDraftData);
                initEditHariAcaraAutoFill();
            }, 50);
        } catch (error) {
            console.error('Error fetching draft data:', error);
            notify('error', 'Gagal', 'Terjadi kesalahan saat mengambil data');
        }
    }

    function populateEditUndanganForm(data) {
        const undangan = data.surat_undangan;
        
        document.getElementById('edit_undangan_id_surat').value = data.id_surat;
        
        const nomorSurat = data.nomor_surat || '';
        const parts = nomorSurat.split('/');
        document.getElementById('edit_nomor_surat_part1').value = parts[0] || '';
        document.getElementById('edit_nomor_surat_part2').value = parts[1] || '';
        document.getElementById('edit_nomor_surat_part3').value = parts[2] || '';
        document.getElementById('edit_nomor_surat_part4').value = parts[3] || '';
        
        document.getElementById('edit_undangan_lampiran').value = undangan.lampiran || '';
        document.getElementById('edit_undangan_hal').value = undangan.hal || '';
        document.getElementById('edit_undangan_kepada').value = undangan.kepada || '';
        document.getElementById('edit_undangan_tempat_dibuat').value = undangan.tempat_dibuat || 'Gemolong';
        
        const tanggalDibuat = undangan.tanggal_dibuat_formatted || (undangan.tanggal_dibuat ? undangan.tanggal_dibuat.substring(0, 10) : '');
        document.getElementById('edit_undangan_tanggal_dibuat').value = tanggalDibuat;
        
        const tanggalAcara = undangan.tanggal_acara_formatted || (undangan.tanggal_acara ? undangan.tanggal_acara.substring(0, 10) : '');
        document.getElementById('edit_undangan_tanggal_acara').value = tanggalAcara;

        document.getElementById('edit_undangan_nama_kegiatan').value = undangan.nama_kegiatan || '';
        
        document.getElementById('edit_undangan_jam_mulai').value = undangan.jam_mulai || '';
        document.getElementById('edit_undangan_jam_selesai').value = undangan.jam_selesai || '';
        document.getElementById('edit_undangan_keterangan_waktu').value = undangan.keterangan_waktu || '';
        document.getElementById('edit_undangan_tempat_acara').value = undangan.tempat_acara || '';
        document.getElementById('edit_undangan_keperluan').value = undangan.keperluan || '';
        
        const hari = undangan.hari_acara || getHariIndonesia(tanggalAcara) || '';
        const hariInput = document.querySelector('#modalEditUndangan input[name="hari_acara"]');
        if (hariInput) {
            hariInput.value = hari;
        }
        
        setTimeout(() => {
            const modalElement = document.querySelector('#modalEditUndangan form');
            if (modalElement && modalElement.__x) {
                const alpineData = modalElement.__x.$data;
                alpineData.editHariAcara = hari;
                alpineData.editHariAcaraLabel = hari;
            }
            
            const hariDisplay = document.querySelector('#modalEditUndangan input[x-model="editHariAcaraLabel"]');
            if (hariDisplay) {
                hariDisplay.value = hari;
            }
        }, 100);
        
        document.getElementById('edit_nama_tertanda').value = undangan.nama_tertanda || '';
        document.getElementById('edit_tertanda_search').value = undangan.nama_tertanda || '';
        document.getElementById('edit_nip_tertanda').value = undangan.nip_tertanda || '';
        document.getElementById('edit_jabatan_tertanda').value = undangan.jabatan_tertanda || '';
        
        if (undangan.nama_tertanda) {
            document.getElementById('edit_tertanda_search').readOnly = true;
            document.getElementById('edit_tertanda_search').classList.add('bg-gray-100', 'cursor-not-allowed');
            document.getElementById('edit_tertanda_reset').classList.remove('hidden');
        } else {
            document.getElementById('edit_tertanda_search').readOnly = false;
            document.getElementById('edit_tertanda_search').classList.remove('bg-gray-100', 'cursor-not-allowed');
            document.getElementById('edit_tertanda_reset').classList.add('hidden');
        }
        
        initEditTertandaAutocomplete();
        
        if (typeof FormDirtyMonitor !== 'undefined') {
            if (window.formDirtyMonitors && window.formDirtyMonitors['editUndanganForm']) {
                window.formDirtyMonitors['editUndanganForm'].destroy();
            }
            new FormDirtyMonitor('editUndanganForm', 'submitEditUndanganBtn');
        }
    }

    function resetEditUndanganForm() {
        if (currentUndanganDraftData) {
            populateEditUndanganForm(currentUndanganDraftData);
        }
    }

    function initEditTertandaAutocomplete() {
        const tertandaSearchInput = document.getElementById('edit_tertanda_search');
        const tertandaResultsContainer = document.getElementById('edit_tertanda_results');
        let tertandaDebounceTimer;

        if (!tertandaSearchInput || !tertandaResultsContainer) {
            return;
        }

        const newInput = tertandaSearchInput.cloneNode(true);
        tertandaSearchInput.parentNode.replaceChild(newInput, tertandaSearchInput);

        newInput.addEventListener('input', function (e) {
            clearTimeout(tertandaDebounceTimer);
            const term = e.target.value;

            const tertandaResetBtn = document.getElementById('edit_tertanda_reset');
            if (tertandaResetBtn) {
                if (term.length > 0) tertandaResetBtn.classList.remove('hidden');
                else tertandaResetBtn.classList.add('hidden');
            }

            if (term.length < 2) {
                tertandaResultsContainer.classList.add('hidden');
                return;
            }

            tertandaDebounceTimer = setTimeout(() => {
                const structuralKeywords = ['direktur', 'kepala bidang', 'kabid', 'kepala seksi', 'kasi', 'kepala sub bagian', 'kasubbag', 'kepala bagian', 'kabag', 'ketua'];

                const data = window.masterPegawais.filter(p => {
                    const matchesTerm = (p.nama && p.nama.toLowerCase().includes(term.toLowerCase())) ||
                        (p.nip && p.nip.includes(term));

                    if (!matchesTerm) return false;

                    const jabatan = (p.jabatan || '').toLowerCase();
                    return structuralKeywords.some(keyword => jabatan.includes(keyword));
                }).slice(0, 10);

                tertandaResultsContainer.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(p => {
                        const div = document.createElement('div');
                        div.className = 'px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 transition-all';
                        const details = p.nip ? `${p.nip} | ${p.jabatan || '-'}` : (p.jabatan || '-');
                        div.innerHTML = `
                            <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm">${p.nama}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">${details}</div>
                        `;
                        div.onclick = () => selectEditTertanda(p.id);
                        tertandaResultsContainer.appendChild(div);
                    });
                    tertandaResultsContainer.classList.remove('hidden');
                } else {
                    tertandaResultsContainer.classList.add('hidden');
                }
            }, 300);
        });

        document.addEventListener('click', function (e) {
            const searchInput = document.getElementById('edit_tertanda_search');
            const resultsContainer = document.getElementById('edit_tertanda_results');
            if (searchInput && !searchInput.contains(e.target) && resultsContainer && !resultsContainer.contains(e.target)) {
                resultsContainer.classList.add('hidden');
            }
        });

        const tertandaResetBtn = document.getElementById('edit_tertanda_reset');
        if (tertandaResetBtn) {
            const newResetBtn = tertandaResetBtn.cloneNode(true);
            tertandaResetBtn.parentNode.replaceChild(newResetBtn, tertandaResetBtn);
            
            newResetBtn.addEventListener('click', function () {
                document.getElementById('edit_nama_tertanda').value = '';
                document.getElementById('edit_tertanda_search').value = '';
                document.getElementById('edit_tertanda_search').readOnly = false;
                document.getElementById('edit_tertanda_search').classList.remove('bg-gray-100', 'cursor-not-allowed');
                this.classList.add('hidden');

                document.getElementById('edit_nip_tertanda').value = '';
                document.getElementById('edit_jabatan_tertanda').value = '';
                const searchInput = document.getElementById('edit_tertanda_search');
                if (searchInput) {
                    searchInput.focus();
                }
                
                if (window.formDirtyMonitors && window.formDirtyMonitors['editUndanganForm']) {
                    window.formDirtyMonitors['editUndanganForm'].check();
                }
            });
        }
    }

    window.selectEditTertanda = function(id) {
        const data = window.masterPegawais.find(p => p.id == id);
        if (data) {
            document.getElementById('edit_nama_tertanda').value = data.nama;
            document.getElementById('edit_tertanda_search').value = data.nama;
            document.getElementById('edit_tertanda_search').readOnly = true;
            document.getElementById('edit_tertanda_search').classList.add('bg-gray-100', 'cursor-not-allowed');
            document.getElementById('edit_tertanda_reset').classList.remove('hidden');

            document.getElementById('edit_nip_tertanda').value = data.nip || '';
            document.getElementById('edit_jabatan_tertanda').value = data.jabatan || '';
            const tertandaResultsContainer = document.getElementById('edit_tertanda_results');
            if (tertandaResultsContainer) {
                tertandaResultsContainer.classList.add('hidden');
            }
            
            if (window.formDirtyMonitors && window.formDirtyMonitors['editUndanganForm']) {
                window.formDirtyMonitors['editUndanganForm'].check();
            }
        }
    }

    async function submitEditUndanganForm(event) {
        event.preventDefault();
        const form = document.getElementById('editUndanganForm');
        const id = currentEditUndanganId;
        
        combineEditNomorSuratUndangan();
        const formData = new FormData(form);

        const submitBtn = document.getElementById('submitEditUndanganBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui';

        try {
            const response = await fetch("{{ url('surat-undangan') }}/" + id, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                closeModal('modalEditUndangan');
                notify('success', 'Berhasil', result.message);

                window.dispatchEvent(new CustomEvent('update-undangan-draft', { detail: result.data }));

                setTimeout(() => {
                    openPreviewPDF(
                        result.file_url,
                        result.nomor_surat,
                        result.surat_id,
                        'SURAT UNDANGAN',
                        result.tanggal_dibuat,
                        true
                    );
                }, 500);
            } else {
                if (result.errors) {
                    handleValidationErrors(result.errors);
                } else {
                    notify('error', 'Gagal', result.message || 'Gagal memperbarui draft');
                }
            }
        } catch (error) {
            console.error('Error updating draft:', error);
            notify('error', 'Gagal', 'Terjadi kesalahan sistem');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Perbarui';
        }
    }
</script>
