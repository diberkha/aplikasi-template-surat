<div id="modalCreateSOP" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalCreateSOP')"></div>

        <div
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-4xl w-full max-h-[95vh] overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700">

            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Buat Standar Operasional Prosedur</h3>
                <button onclick="closeModal('modalCreateSOP')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form action="{{ route('template-surat.sop.store') }}" method="POST" id="sopForm"
                onsubmit="submitSOPForm(event)" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <input type="hidden" name="template_id" id="template_surat_sop">

                <div class="p-6 space-y-6 overflow-y-auto flex-1 custom-scrollbar">

                    <div
                        class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Judul SOP <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="judul_sop" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-3">
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">No. Dokumen <span
                                            class="text-red-500">*</span></label>
                                    <div class="flex items-center gap-2 w-full">
                                        <input type="text" id="nomor_dok_part1"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                            required>
                                        <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                        <input type="text" id="nomor_dok_part2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                            required>
                                        <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                        <input type="text" id="nomor_dok_part3"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                            required>
                                        <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                        <input type="text" id="nomor_dok_part4"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                            required>
                                    </div>
                                    <input type="hidden" name="nomor_dokumen" id="nomor_dokumen_combined">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">No. Revisi</label>
                                    <input type="text" name="nomor_revisi"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Halaman</label>
                                    <input type="text" name="halaman"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Terbit <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_terbit" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">PENGERTIAN <span
                                    class="text-red-500">*</span></h4>
                        </div>
                        <div class="p-4">
                            <textarea name="pengertian" rows="3" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">TUJUAN <span
                                    class="text-red-500">*</span></h4>
                        </div>
                        <div class="p-4">
                            <div id="tujuanContainer" class="space-y-3">
                                <div class="tujuan-item flex gap-3">
                                    <label
                                        class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">1.</label>
                                    <div class="flex-1">
                                        <textarea name="tujuan[]" rows="2" required
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="addTujuanField()"
                                class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Tujuan
                            </button>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">KEBIJAKAN <span
                                    class="text-red-500">*</span></h4>
                        </div>
                        <div class="p-4">
                            <input type="hidden" name="kebijakan_check" id="kebijakan_check">

                            <div class="mb-3">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" id="searchKebijakan" placeholder="Cari regulasi..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        onkeyup="filterKebijakan()">
                                </div>
                            </div>

                            <div id="kebijakanList"
                                class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 bg-white max-h-64 overflow-y-auto">
                                <div class="text-sm text-gray-500 dark:text-gray-400 text-center py-8">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                    Memuat data
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-info-circle mr-1"></i>
                                Pilih satu atau lebih regulasi yang relevan
                            </p>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">PROSEDUR <span
                                    class="text-red-500">*</span></h4>
                        </div>
                        <div class="p-4">
                            <div id="prosedurContainer" class="space-y-3">
                                <div class="prosedur-item flex gap-3">
                                    <label
                                        class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">1.</label>
                                    <div class="flex-1">
                                        <textarea name="prosedur[]" rows="2" required
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="addProsedurField()"
                                class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Prosedur
                            </button>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">UNIT TERKAIT <span
                                    class="text-red-500">*</span></h4>
                        </div>
                        <div class="p-4">
                            <input type="hidden" name="unit_terkait_check" id="unit_terkait_check">

                            <div class="mb-3">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" id="searchUnit" placeholder="Cari unit..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        onkeyup="filterUnit()">
                                </div>
                            </div>

                            <div id="unitList"
                                class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 bg-white max-h-64 overflow-y-auto">
                                <div class="text-sm text-gray-500 dark:text-gray-400 text-center py-8">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                    Memuat data
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-info-circle mr-1"></i>
                                Pilih satu atau lebih unit yang terkait
                            </p>
                        </div>
                    </div>

                </div>

                <div
                    class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex justify-end space-x-3 flex-shrink-0">
                    <button type="reset"
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
    let tujuanCounter = 1;
    let prosedurCounter = 1;

    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.querySelector('input[name="tanggal_terbit"]');
        if (dateInput && typeof flatpickr !== 'undefined') {
            flatpickr(dateInput, {
                locale: 'id',
                dateFormat: 'Y-m-d'
            });
        }
        loadRegulasiOptions();
        loadUnitOptions();
    });

    async function loadRegulasiOptions() {
        try {
            const response = await fetch('/api/regulasi');
            let data = await response.json();
            if (data.data) data = data.data;

            const listContainer = document.getElementById('kebijakanList');
            listContainer.innerHTML = '';
            if (!Array.isArray(data) || data.length === 0) {
                listContainer.innerHTML = '<div class="text-sm text-gray-500 dark:text-gray-400 text-center py-4"><i class="fas fa-exclamation-circle mr-2"></i>Tidak ada data regulasi</div>';
                return;
            }
            data.forEach((item, index) => {
                const checkboxItem = document.createElement('div');
                checkboxItem.className = 'kebijakan-item flex items-start mb-2 pb-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0';
                checkboxItem.innerHTML = `
                    <input type="checkbox" name="kebijakan[]" value="${item.isi_regulasi}" 
                        id="kebijakan_${index}" class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded cursor-pointer"
                        onchange="updateKebijakanCheck()">
                    <label for="kebijakan_${index}" class="ml-3 flex-1 cursor-pointer">
                        <span class="text-sm text-gray-700 dark:text-gray-300 font-medium block">${item.isi_regulasi}</span>
                    </label>
                `;
                listContainer.appendChild(checkboxItem);
            });
        } catch (error) {
            console.error('Error loading regulasi options:', error);
            const listContainer = document.getElementById('kebijakanList');
            listContainer.innerHTML = '<div class="text-sm text-red-500 dark:text-red-400 text-center py-4"><i class="fas fa-exclamation-circle mr-2"></i>Gagal memuat data</div>';
        }
    }

    function updateKebijakanCheck() {
        const checkboxes = document.querySelectorAll('input[name="kebijakan[]"]:checked');
        document.getElementById('kebijakan_check').value = checkboxes.length > 0 ? 'yes' : '';
    }

    async function loadUnitOptions() {
        try {
            const response = await fetch('/api/unit');
            let data = await response.json();
            if (data.data) data = data.data;

            const listContainer = document.getElementById('unitList');
            listContainer.innerHTML = '';
            if (!Array.isArray(data) || data.length === 0) {
                listContainer.innerHTML = '<div class="text-sm text-gray-500 dark:text-gray-400 text-center py-4"><i class="fas fa-exclamation-circle mr-2"></i>Tidak ada data unit</div>';
                return;
            }
            data.forEach((item, index) => {
                const checkboxItem = document.createElement('div');
                checkboxItem.className = 'unit-item flex items-start mb-2 pb-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0';
                checkboxItem.innerHTML = `
                    <input type="checkbox" name="unit_terkait[]" value="${item.nama_unit}" 
                        id="unit_${index}" class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded cursor-pointer"
                        onchange="updateUnitCheck()">
                    <label for="unit_${index}" class="ml-3 flex-1 cursor-pointer">
                        <span class="text-sm text-gray-700 dark:text-gray-300 font-medium block">${item.nama_unit}</span>
                    </label>
                `;
                listContainer.appendChild(checkboxItem);
            });
        } catch (error) {
            console.error('Error loading unit options:', error);
            const listContainer = document.getElementById('unitList');
            listContainer.innerHTML = '<div class="text-sm text-red-500 dark:text-red-400 text-center py-4"><i class="fas fa-exclamation-circle mr-2"></i>Gagal memuat data</div>';
        }
    }

    function updateUnitCheck() {
        const checkboxes = document.querySelectorAll('input[name="unit_terkait[]"]:checked');
        document.getElementById('unit_terkait_check').value = checkboxes.length > 0 ? 'yes' : '';
    }

    function filterUnit() {
        const searchValue = document.getElementById('searchUnit').value.toLowerCase();
        const items = document.querySelectorAll('#unitList .unit-item');
        let visibleCount = 0;
        items.forEach(item => {
            const label = item.querySelector('label');
            if (!label) return;
            const text = label.textContent.toLowerCase();
            if (text.includes(searchValue)) { item.style.display = ''; visibleCount++; }
            else { item.style.display = 'none'; }
        });
        const noResultMsg = document.getElementById('noUnitResult');
        if (visibleCount === 0 && items.length > 0) {
            if (!noResultMsg) {
                const msg = document.createElement('div');
                msg.id = 'noUnitResult';
                msg.className = 'text-center text-gray-500 dark:text-gray-400 py-4';
                msg.innerHTML = '<i class="fas fa-search mr-2"></i>Tidak ada unit yang cocok';
                document.getElementById('unitList').appendChild(msg);
            }
        } else if (noResultMsg) { noResultMsg.remove(); }
    }

    function filterKebijakan() {
        const searchValue = document.getElementById('searchKebijakan').value.toLowerCase();
        const items = document.querySelectorAll('#kebijakanList .kebijakan-item');
        let visibleCount = 0;
        items.forEach(item => {
            const label = item.querySelector('label');
            if (!label) return;
            const text = label.textContent.toLowerCase();
            if (text.includes(searchValue)) { item.style.display = ''; visibleCount++; }
            else { item.style.display = 'none'; }
        });
        const noResultMsg = document.getElementById('noKebijakanResult');
        if (visibleCount === 0 && items.length > 0) {
            if (!noResultMsg) {
                const msg = document.createElement('div');
                msg.id = 'noKebijakanResult';
                msg.className = 'text-center text-gray-500 dark:text-gray-400 py-4';
                msg.innerHTML = '<i class="fas fa-search mr-2"></i>Tidak ada regulasi yang cocok';
                document.getElementById('kebijakanList').appendChild(msg);
            }
        } else if (noResultMsg) { noResultMsg.remove(); }
    }

    function addTujuanField() {
        const container = document.getElementById('tujuanContainer');
        const index = ++tujuanCounter;
        const wrapper = document.createElement('div');
        wrapper.className = 'tujuan-item flex gap-3';
        wrapper.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${index}.</label>
            <div class="flex-1 flex gap-2">
                <textarea name="tujuan[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                <button type="button" onclick="removeTujuanField(this)" class="mt-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(wrapper);
    }

    function removeTujuanField(button) {
        const item = button.closest('.tujuan-item');
        const container = document.getElementById('tujuanContainer');
        if (container.querySelectorAll('.tujuan-item').length <= 1) return;
        item.remove();
        tujuanCounter = Math.max(1, tujuanCounter - 1);
        renumberItems('tujuanContainer', 'tujuan-item');
    }

    function addProsedurField() {
        const container = document.getElementById('prosedurContainer');
        const index = ++prosedurCounter;
        const wrapper = document.createElement('div');
        wrapper.className = 'prosedur-item flex gap-3';
        wrapper.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${index}.</label>
            <div class="flex-1 flex gap-2">
                <textarea name="prosedur[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                <button type="button" onclick="removeProsedurField(this)" class="mt-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(wrapper);
    }

    function removeProsedurField(button) {
        const item = button.closest('.prosedur-item');
        const container = document.getElementById('prosedurContainer');
        if (container.querySelectorAll('.prosedur-item').length <= 1) return;
        item.remove();
        prosedurCounter = Math.max(1, prosedurCounter - 1);
        renumberItems('prosedurContainer', 'prosedur-item');
    }

    function renumberItems(containerId, itemClass) {
        const container = document.getElementById(containerId);
        const items = container.querySelectorAll(`.${itemClass}`);
        items.forEach((el, idx) => {
            const lbl = el.querySelector('label');
            if (lbl) lbl.textContent = `${idx + 1}.`;
        });
    }

    function resetFormSOP() {
        const form = document.getElementById('sopForm');
        form.reset();

        const checkboxes = document.querySelectorAll('input[name="kebijakan[]"]');
        checkboxes.forEach(cb => cb.checked = false);
        document.getElementById('kebijakan_check').value = '';

        const unitCheckboxes = document.querySelectorAll('input[name="unit_terkait[]"]');
        unitCheckboxes.forEach(cb => cb.checked = false);
        document.getElementById('unit_terkait_check').value = '';

        document.getElementById('tujuanContainer').innerHTML = `
            <div class="tujuan-item flex gap-3">
                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">1.</label>
                <div class="flex-1">
                    <textarea name="tujuan[]" rows="2" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                </div>
            </div>
        `;
        tujuanCounter = 1;

        document.getElementById('prosedurContainer').innerHTML = `
            <div class="prosedur-item flex gap-3">
                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">1.</label>
                <div class="flex-1">
                    <textarea name="prosedur[]" rows="2" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                </div>
            </div>
        `;
        prosedurCounter = 1;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modalCreateSOP');
        if (modal) {
            modal.addEventListener('modal-closed', function () {
                resetFormSOP();
            });
        }
    });

    function combineNomorDokumen() {
        const part1 = document.getElementById('nomor_dok_part1').value.trim();
        const part2 = document.getElementById('nomor_dok_part2').value.trim();
        const part3 = document.getElementById('nomor_dok_part3').value.trim();
        const part4 = document.getElementById('nomor_dok_part4').value.trim();

        const combined = `${part1}/${part2}/${part3}/${part4}`;
        document.getElementById('nomor_dokumen_combined').value = combined;
    }

    function submitSOPForm(event) {
        event.preventDefault();
        const form = document.getElementById('sopForm');

        combineNomorDokumen();

        const kebijakanCheckboxes = form.querySelectorAll('input[name="kebijakan[]"]:checked');
        const unitCheckboxes = form.querySelectorAll('input[name="unit_terkait[]"]:checked');
        const tujuanFields = Array.from(form.querySelectorAll('textarea[name="tujuan[]"]')).map(i => i.value.trim()).filter(Boolean);
        const prosedurFields = Array.from(form.querySelectorAll('textarea[name="prosedur[]"]')).map(i => i.value.trim()).filter(Boolean);

        if (kebijakanCheckboxes.length === 0) {
            notify('error', 'Validasi Gagal', 'Minimal satu Kebijakan (Regulasi) harus dipilih.', false);
            return;
        }

        if (unitCheckboxes.length === 0) {
            notify('error', 'Validasi Gagal', 'Minimal satu Unit Terkait harus dipilih.', false);
            return;
        }

        if (tujuanFields.length === 0) {
            notify('error', 'Validasi Gagal', 'Tujuan minimal 1 poin.', false);
            return;
        }

        if (prosedurFields.length === 0) {
            notify('error', 'Validasi Gagal', 'Prosedur minimal 1 poin.', false);
            return;
        }

        const formData = new FormData(form);
        while (formData.has('tujuan[]')) formData.delete('tujuan[]');
        tujuanFields.forEach(v => formData.append('tujuan[]', v));
        while (formData.has('prosedur[]')) formData.delete('prosedur[]');
        prosedurFields.forEach(v => formData.append('prosedur[]', v));

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan';

        fetch(form.action, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(response => response.json().then(data => ({ status: response.status, ok: response.ok, data })).catch(() => ({ status: response.status, ok: response.ok, parseError: true })))
            .then(result => {
                if (result.parseError) { notify('error', 'Gagal', 'Error: Response parsing failed.', false); return; }
                if (!result.ok) {
                    if (result.data?.errors) {
                        handleValidationErrors(result.data.errors);
                    } else {
                        notify('error', 'Gagal', 'Error: ' + (result.data?.message || 'Server error: ' + result.status), false);
                    }
                    return;
                }

                if (result.data.success) {
                    closeModal('modalCreateSOP');
                    form.reset();
                    resetFormSOP();
                    notify('success', 'Berhasil', result.data.message);
                    setTimeout(() => {
                        openPreviewPDF(result.data.file_url, result.data.nomor_surat, result.data.surat_id, result.data.judul_sop, result.data.tanggal_dibuat);
                    }, 500);
                } else { notify('error', 'Gagal', 'Gagal membuat SOP: ' + (result.data.message || 'Kesalahan tidak diketahui'), false); }
            })
            .catch(error => { console.error('Fetch error:', error); notify('error', 'Gagal', 'Terjadi kesalahan sistem: ' + error.message, false); })
            .finally(() => { submitBtn.disabled = false; submitBtn.innerHTML = 'Simpan'; });
    }

</script>