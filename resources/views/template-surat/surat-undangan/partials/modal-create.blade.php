<div id="modalCreateUndangan" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalCreateUndangan')"></div>

        <div
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-3xl w-full max-h-[95vh] overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700">

            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/50 z-10">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white">Buat Surat Undangan</h3>
                <button onclick="closeModal('modalCreateUndangan')"
                    class="p-2 -mr-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form action="{{ route('template-surat.surat-undangan.store') }}" method="POST" id="suratUndanganForm"
                onsubmit="submitFormAJAX(event)" class="flex flex-col overflow-hidden flex-1" x-data="{ openHari: false, hariAcara: '', hariAcaraLabel: '', searchHari: '', hariOptions: [
                    { value: 'Senin', label: 'Senin' },
                    { value: 'Selasa', label: 'Selasa' },
                    { value: 'Rabu', label: 'Rabu' },
                    { value: 'Kamis', label: 'Kamis' },
                    { value: 'Jumat', label: 'Jumat' },
                    { value: 'Sabtu', label: 'Sabtu' },
                    { value: 'Minggu', label: 'Minggu' }
                ] }">
                @csrf
                <input type="hidden" name="template_id" id="template_surat_undangan">

                <div class="p-6 space-y-6 overflow-y-auto flex-1 custom-scrollbar">

                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Nomor Surat <span
                                        class="text-red-500">*</span></label>
                                <div class="flex items-center gap-2 w-full">
                                    <input type="text" id="nomor_surat_part1"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                        required>
                                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                    <input type="text" id="nomor_surat_part2"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                        required>
                                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                    <input type="text" id="nomor_surat_part3"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                        required>
                                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                    <input type="text" id="nomor_surat_part4"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                        required>
                                </div>
                                <input type="hidden" name="nomor_surat" id="nomor_surat_combined">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Nomor surat tidak boleh sama dengan surat yang sudah ada
                                </p>
                            </div>

                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Lampiran</label>
                                <input type="text" name="lampiran"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Hal <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="hal" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Kepada <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="kepada" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Tempat <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="tempat_dibuat" required value="Gemolong"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Surat <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_dibuat" required
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
                                <input type="text" name="nama_kegiatan" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Hari <span
                                            class="text-red-500">*</span></label>
                                    <input type="hidden" name="hari_acara" :value="hariAcara" required>
                                    <input type="text" x-model="hariAcaraLabel" readonly
                                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_acara" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Jam Mulai <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="jam_mulai" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Jam Selesai</label>
                                    <input type="text" name="jam_selesai" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Keterangan Waktu</label>
                                    <input type="text" name="keterangan_waktu" placeholder="Contoh: WIB"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Tempat <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="tempat_acara" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Keperluan</label>
                                <textarea name="keperluan" rows="3"
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
                                        <input type="text" id="tertanda_search" autocomplete="off" required
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 transition-all">
                                        <button type="button" id="tertanda_reset"
                                            class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                            <i class="fas fa-times-circle text-lg"></i>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Ketik minimal 2 karakter
                                    </p>
                                    <input type="hidden" name="nama_tertanda" id="nama_tertanda">
                                    <div id="tertanda_results"
                                        class="hidden absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto mt-1">
                                    </div>
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">NIP <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="nip_tertanda" id="nip_tertanda" readonly
                                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                                </div>
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Jabatan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="jabatan_tertanda" id="jabatan_tertanda" readonly required
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-600 dark:text-gray-300 cursor-not-allowed">
                            </div>
                        </div>
                    </div>

                </div>

                <div
                    class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3 bg-gray-50 dark:bg-gray-700/50">
                    <button type="button" @click="document.getElementById('suratUndanganForm').reset(); hariAcara = ''; hariAcaraLabel = ''; searchHari = ''"
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
</div>

<script>
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

    function initHariAcaraAutoFill() {
        const tanggalInput = document.querySelector('#modalCreateUndangan input[name="tanggal_acara"]');
        const formEl = document.querySelector('#modalCreateUndangan form');

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
            const hariDisplay = formEl.querySelector('input[x-model="hariAcaraLabel"]');

            if (hariHidden) {
                hariHidden.value = hari;
            }

            if (hariDisplay) {
                hariDisplay.value = hari;
            }

            if (hari && formEl.__x) {
                const alpineData = formEl.__x.$data;
                alpineData.hariAcara = hari;
                alpineData.hariAcaraLabel = hari;
            }
        };

        tanggalInput.addEventListener('change', applyHari);
        tanggalInput.addEventListener('input', applyHari);
        applyHari();
    }

    document.addEventListener('DOMContentLoaded', initHariAcaraAutoFill);

    function combineNomorSurat() {
        const part1 = document.getElementById('nomor_surat_part1').value.trim();
        const part2 = document.getElementById('nomor_surat_part2').value.trim();
        const part3 = document.getElementById('nomor_surat_part3').value.trim();
        const part4 = document.getElementById('nomor_surat_part4').value.trim();

        const combined = `${part1}/${part2}/${part3}/${part4}`;
        document.getElementById('nomor_surat_combined').value = combined;
    }

    function submitFormAJAX(event) {
        event.preventDefault();
        const form = document.getElementById('suratUndanganForm');

        combineNomorSurat();

        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan';

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json().then(data => ({
            status: response.status,
            ok: response.ok,
            data
        })).catch(() => ({
            status: response.status,
            ok: response.ok,
            parseError: true
        })))
        .then(result => {
            if (result.parseError) {
                notify('error', 'Gagal', 'Error: Response parsing failed.', false);
                return;
            }

            if (!result.ok) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Simpan';

                if (result.data?.errors) {
                    handleValidationErrors(result.data.errors);
                } else {
                    notify('error', 'Gagal', (result.data?.message || 'Server error: ' + result.status), false);
                }
                return;
            }

            if (result.data.success) {
                openPreviewPDF(
                    result.data.file_url,
                    result.data.nomor_surat,
                    result.data.surat_id,
                    'SURAT UNDANGAN',
                    result.data.tanggal_dibuat,
                    false
                );

                closeModal('modalCreateUndangan');
                form.reset();
                notify('success', 'Berhasil', result.data.message);
            } else {
                notify('error', 'Gagal', 'Gagal membuat surat: ' + (result.data.message || 'Kesalahan tidak diketahui'), false);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            notify('error', 'Gagal', 'Terjadi kesalahan sistem: ' + error.message, false);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan';
        });
    }
</script>
