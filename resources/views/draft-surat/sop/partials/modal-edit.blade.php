<div id="modalEditSOP" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalEditSOP')"></div>

        <div
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-4xl w-full max-h-[95vh] overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700">

            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Draft Standar Operasional Prosedur
                </h3>
                <button onclick="closeModal('modalEditSOP')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form id="editSopForm" onsubmit="submitEditSOPForm(event)" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_surat" id="edit_sop_id_surat">

                <div class="p-6 space-y-6 overflow-y-auto flex-1 custom-scrollbar">

                    <div
                        class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Judul SOP <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="judul_sop" id="edit_sop_judul" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-3">
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">No. Dokumen <span
                                            class="text-red-500">*</span></label>
                                    <div class="flex items-center gap-2 w-full">
                                        <input type="text" id="edit_nomor_dok_part1"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                            required>
                                        <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                        <input type="text" id="edit_nomor_dok_part2"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                            required>
                                        <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                        <input type="text" id="edit_nomor_dok_part3"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                            required>
                                        <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                        <input type="text" id="edit_nomor_dok_part4"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                            required>
                                    </div>
                                    <input type="hidden" name="nomor_dokumen" id="edit_nomor_dokumen_combined">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">No. Revisi</label>
                                    <input type="text" name="nomor_revisi" id="edit_sop_nomor_revisi"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Halaman</label>
                                    <input type="text" name="halaman" id="edit_sop_halaman"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Terbit <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_terbit" id="edit_sop_tanggal_terbit" required
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
                            <textarea name="pengertian" id="edit_sop_pengertian" rows="3" required
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
                            <div id="editTujuanContainer" class="space-y-3">
                            </div>
                            <button type="button" onclick="addEditTujuanField()"
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
                            <div class="mb-3">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" id="searchEditKebijakan" placeholder="Cari regulasi..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        onkeyup="filterEditKebijakan()">
                                </div>
                            </div>
                            <div id="editKebijakanList"
                                class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 bg-white max-h-64 overflow-y-auto">
                            </div>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">PROSEDUR <span
                                    class="text-red-500">*</span></h4>
                        </div>
                        <div class="p-4">
                            <div id="editProsedurContainer" class="space-y-3">
                            </div>
                            <button type="button" onclick="addEditProsedurField()"
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
                            <div class="mb-3">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" id="searchEditUnit" placeholder="Cari unit..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        onkeyup="filterEditUnit()">
                                </div>
                            </div>
                            <div id="editUnitList"
                                class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 bg-white max-h-64 overflow-y-auto">
                            </div>
                        </div>
                    </div>

                </div>

                <div
                    class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex justify-end space-x-3 flex-shrink-0">
                    <button type="button" onclick="closeModal('modalEditSOP')"
                        class="px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                        Batal
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
    let editTujuanCounter = 0;
    let editProsedurCounter = 0;

    async function openEditSopModal(id) {
        try {
            const response = await fetch(`/sop/${id}/edit`);
            const result = await response.json();

            if (!result.success) {
                notify('error', 'Gagal', 'Gagal mengambil data draft');
                return;
            }

            const data = result.data;
            const sop = data.sop;

            document.getElementById('edit_sop_id_surat').value = data.id_surat;
            document.getElementById('edit_sop_judul').value = sop.judul_sop;

            const nomorDokParts = (sop.nomor_dokumen || '///').split('/');
            document.getElementById('edit_nomor_dok_part1').value = nomorDokParts[0] || '';
            document.getElementById('edit_nomor_dok_part2').value = nomorDokParts[1] || '';
            document.getElementById('edit_nomor_dok_part3').value = nomorDokParts[2] || '';
            document.getElementById('edit_nomor_dok_part4').value = nomorDokParts[3] || '';

            document.getElementById('edit_sop_nomor_revisi').value = sop.nomor_revisi;
            document.getElementById('edit_sop_halaman').value = sop.halaman;
            document.getElementById('edit_sop_tanggal_terbit').value = sop.tanggal_terbit ? sop.tanggal_terbit.substring(0, 10) : '';
            document.getElementById('edit_sop_pengertian').value = sop.pengertian;

            const tujuanContainer = document.getElementById('editTujuanContainer');
            tujuanContainer.innerHTML = '';
            editTujuanCounter = 0;
            sop.tujuan_array.forEach((text, idx) => {
                addEditTujuanField(text);
            });

            const prosedurContainer = document.getElementById('editProsedurContainer');
            prosedurContainer.innerHTML = '';
            editProsedurCounter = 0;
            sop.prosedur_array.forEach((text, idx) => {
                addEditProsedurField(text);
            });

            await loadEditRegulasiOptions(sop.kebijakan_array);

            await loadEditUnitOptions(sop.unit_terkait_array);

            openModal('modalEditSOP');
        } catch (error) {
            console.error('Error fetching draft data:', error);
            notify('error', 'Gagal', 'Terjadi kesalahan saat mengambil data');
        }
    }

    async function loadEditRegulasiOptions(selectedTexts) {
        const response = await fetch('/api/regulasi');
        let data = await response.json();
        if (data.data) data = data.data;

        const listContainer = document.getElementById('editKebijakanList');
        listContainer.innerHTML = '';

        data.forEach((item, index) => {
            const isChecked = selectedTexts.some(text => item.id_regulasi == text || item.isi_regulasi === text);
            const checkboxItem = document.createElement('div');
            checkboxItem.className = 'flex items-start mb-2 pb-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0';
            checkboxItem.innerHTML = `
                <input type="checkbox" name="kebijakan[]" value="${item.isi_regulasi}"
                    id="edit_kebijakan_${index}" ${isChecked ? 'checked' : ''}
                    class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded cursor-pointer">
                <label for="edit_kebijakan_${index}" class="ml-3 flex-1 cursor-pointer">
                    <span class="text-sm text-gray-700 dark:text-gray-300 font-medium block">${item.isi_regulasi}</span>
                </label>
            `;
            listContainer.appendChild(checkboxItem);
        });
    }

    async function loadEditUnitOptions(selectedTexts) {
        const response = await fetch('/api/unit');
        let data = await response.json();
        if (data.data) data = data.data;

        const listContainer = document.getElementById('editUnitList');
        listContainer.innerHTML = '';

        data.forEach((item, index) => {
            const isChecked = selectedTexts.some(text => item.id_unit == text || item.nama_unit === text);
            const checkboxItem = document.createElement('div');
            checkboxItem.className = 'flex items-start mb-2 pb-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0';
            checkboxItem.innerHTML = `
                <input type="checkbox" name="unit_terkait[]" value="${item.nama_unit}"
                    id="edit_unit_${index}" ${isChecked ? 'checked' : ''}
                    class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded cursor-pointer">
                <label for="edit_unit_${index}" class="ml-3 flex-1 cursor-pointer">
                    <span class="text-sm text-gray-700 dark:text-gray-300 font-medium block">${item.nama_unit}</span>
                </label>
            `;
            listContainer.appendChild(checkboxItem);
        });
    }

    function addEditTujuanField(text = '') {
        const container = document.getElementById('editTujuanContainer');
        const index = ++editTujuanCounter;
        const wrapper = document.createElement('div');
        wrapper.className = 'tujuan-item flex gap-3';
        wrapper.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${index}.</label>
            <div class="flex-1 flex gap-2">
                <textarea name="tujuan[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y">${text}</textarea>
                <button type="button" onclick="removeEditField(this, 'editTujuanContainer', 'tujuan-item')" class="mt-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(wrapper);
    }

    function addEditProsedurField(text = '') {
        const container = document.getElementById('editProsedurContainer');
        const index = ++editProsedurCounter;
        const wrapper = document.createElement('div');
        wrapper.className = 'prosedur-item flex gap-3';
        wrapper.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${index}.</label>
            <div class="flex-1 flex gap-2">
                <textarea name="prosedur[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y">${text}</textarea>
                <button type="button" onclick="removeEditField(this, 'editProsedurContainer', 'prosedur-item')" class="mt-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(wrapper);
    }

    function removeEditField(button, containerId, itemClass) {
        const item = button.closest(`.${itemClass}`);
        item.remove();
        const container = document.getElementById(containerId);
        const items = container.querySelectorAll(`.${itemClass}`);
        items.forEach((el, idx) => {
            el.querySelector('label').textContent = `${idx + 1}.`;
        });
        if (containerId === 'editTujuanContainer') editTujuanCounter = items.length;
        else editProsedurCounter = items.length;
    }

    function filterEditKebijakan() {
        const searchValue = document.getElementById('searchEditKebijakan').value.toLowerCase();
        const items = document.querySelectorAll('#editKebijakanList > div');
        let visibleCount = 0;

        items.forEach(item => {
            const text = item.querySelector('label span').textContent.toLowerCase();
            if (text.includes(searchValue)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        const noResultId = 'noEditKebijakanResult';
        let noResultMsg = document.getElementById(noResultId);

        if (visibleCount === 0 && items.length > 0) {
            if (!noResultMsg) {
                noResultMsg = document.createElement('div');
                noResultMsg.id = noResultId;
                noResultMsg.className = 'text-center text-gray-500 dark:text-gray-400 py-4';
                noResultMsg.innerHTML = '<i class="fas fa-search mr-2"></i>Tidak ada regulasi yang cocok';
                document.getElementById('editKebijakanList').appendChild(noResultMsg);
            }
        } else if (noResultMsg) {
            noResultMsg.remove();
        }
    }

    function filterEditUnit() {
        const searchValue = document.getElementById('searchEditUnit').value.toLowerCase();
        const items = document.querySelectorAll('#editUnitList > div');
        let visibleCount = 0;

        items.forEach(item => {
            const text = item.querySelector('label span').textContent.toLowerCase();
            if (text.includes(searchValue)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        const noResultId = 'noEditUnitResult';
        let noResultMsg = document.getElementById(noResultId);

        if (visibleCount === 0 && items.length > 0) {
            if (!noResultMsg) {
                noResultMsg = document.createElement('div');
                noResultMsg.id = noResultId;
                noResultMsg.className = 'text-center text-gray-500 dark:text-gray-400 py-4';
                noResultMsg.innerHTML = '<i class="fas fa-search mr-2"></i>Tidak ada unit yang cocok';
                document.getElementById('editUnitList').appendChild(noResultMsg);
            }
            noResultMsg.remove();
        }
    }

    function combineEditNomorDokumen() {
        const part1 = document.getElementById('edit_nomor_dok_part1').value.trim();
        const part2 = document.getElementById('edit_nomor_dok_part2').value.trim();
        const part3 = document.getElementById('edit_nomor_dok_part3').value.trim();
        const part4 = document.getElementById('edit_nomor_dok_part4').value.trim();

        const combined = `${part1}/${part2}/${part3}/${part4}`;
        document.getElementById('edit_nomor_dokumen_combined').value = combined;
    }

    function submitEditSOPForm(event) {
        event.preventDefault();
        const form = document.getElementById('editSopForm');

        combineEditNomorDokumen();
        const id = document.getElementById('edit_sop_id_surat').value;
        const formData = new FormData(form);

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan';

        fetch(`/sop/${id}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    closeModal('modalEditSOP');
                    notify('success', 'Berhasil', result.message);
                    window.location.reload();
                } else {
                    notify('error', 'Gagal', result.message);
                }
            })
            .catch(error => {
                console.error('Error updating draft:', error);
                notify('error', 'Gagal', 'Terjadi kesalahan sistem');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Simpan';
            });
    }
</script>