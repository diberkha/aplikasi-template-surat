<div id="modalEditSK" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalEditSK')"></div>

        <div
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-4xl w-full max-h-[95vh] overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700">

            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Draft Surat Keputusan Direktur</h3>
                <button onclick="closeModal('modalEditSK')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form id="editSkForm" onsubmit="submitEditSKForm(event)" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_sk_id_surat">

                <div class="p-6 space-y-6 overflow-y-auto flex-1 custom-scrollbar">

                    <div
                        class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Nomor Surat <span
                                        class="text-red-500">*</span></label>
                                <div class="flex items-center gap-2 w-full">
                                    <input type="text" id="edit_nomor_surat_part1"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                        required>
                                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                    <input type="text" id="edit_nomor_surat_part2"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                        required>
                                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                    <input type="text" id="edit_nomor_surat_part3"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                                        required>
                                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">/</span>
                                    <input type="text" id="edit_nomor_surat_part4"
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
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Tentang <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="tentang" id="edit_sk_tentang" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">MENIMBANG <span
                                    class="text-red-500">*</span></h4>
                        </div>
                        <div class="p-4">
                            <div id="editMenimbangContainer" class="space-y-3">
                            </div>
                            <button type="button" onclick="addEditMenimbangField()"
                                class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Menimbang
                            </button>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">MENGINGAT <span
                                    class="text-red-500">*</span></h4>
                        </div>
                        <div class="p-4">
                            <div class="mb-3">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" id="searchEditMengingat" placeholder="Cari regulasi..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        onkeyup="filterEditMengingat()">
                                </div>
                            </div>
                            <div id="editMengingatList"
                                class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 bg-white max-h-64 overflow-y-auto">
                            </div>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">MEMUTUSKAN</h4>
                        </div>
                        <div class="p-4">
                            <div id="editMemutuskanContainer" class="space-y-4">
                                <div class="memutuskan-item flex gap-3 mb-2">
                                    <label
                                        class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">Menetapkan
                                        :</label>
                                    <textarea name="menetapkan" id="edit_sk_menetapkan" rows="2"
                                        class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                                </div>
                                <div id="editKesatuContainer" class="space-y-4"></div>
                            </div>
                            <button type="button" onclick="addEditMemutuskanField()"
                                class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Memutuskan
                            </button>
                        </div>
                    </div>

                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white">TEMPAT & TANGGAL PENETAPAN</h4>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Tempat <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="tempat_dibuat" id="edit_sk_tempat_dibuat"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Surat <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_dibuat" id="edit_sk_tanggal_dibuat" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div
                    class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex justify-end space-x-3 flex-shrink-0">
                    <button type="button" onclick="resetEditSkForm()"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">
                        Reset
                    </button>
                    <button type="submit" id="submitEditSkBtn"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let editMemutuskanCounter = 0;
    let currentSkDraftData = null;
    let currentEditSkId = null;

    async function openEditSkModal(id) {
        try {
            currentEditSkId = id;
            const response = await fetch(`/sk-direktur/${id}/edit`);
            const result = await response.json();

            if (!result.success) {
                notify('error', 'Gagal', 'Gagal mengambil data draft');
                return;
            }

            currentSkDraftData = result.data;
            populateEditSkForm(currentSkDraftData);
            openModal('modalEditSK');
        } catch (error) {
            console.error('Error fetching draft data:', error);
            notify('error', 'Gagal', 'Terjadi kesalahan saat mengambil data');
        }
    }

    function populateEditSkForm(data) {
        const sk = data.sk_direktur;
        document.getElementById('edit_sk_id_surat').value = data.id_surat;

        const nomorSuratParts = (sk.nomor_surat || ' /').split('/');
        document.getElementById('edit_nomor_surat_part1').value = nomorSuratParts[0] || '';
        document.getElementById('edit_nomor_surat_part2').value = nomorSuratParts[1] || '';
        document.getElementById('edit_nomor_surat_part3').value = nomorSuratParts[2] || '';
        document.getElementById('edit_nomor_surat_part4').value = nomorSuratParts[3] || '';

        document.getElementById('edit_sk_tentang').value = sk.tentang;
        document.getElementById('edit_sk_menetapkan').value = sk.menetapkan;
        document.getElementById('edit_sk_tempat_dibuat').value = sk.tempat_dibuat;
        const tanggalSurat = sk.tanggal_dibuat_formatted || (sk.tanggal_dibuat ? sk.tanggal_dibuat.substring(0, 10) : '');
        document.getElementById('edit_sk_tanggal_dibuat').value = tanggalSurat;

        const menimbangContainer = document.getElementById('editMenimbangContainer');
        menimbangContainer.innerHTML = '';
        sk.menimbang_array.forEach((text, idx) => {
            addEditMenimbangField(text);
        });

        const kesatuContainer = document.getElementById('editKesatuContainer');
        kesatuContainer.innerHTML = '';
        editMemutuskanCounter = 0;
        sk.memutuskan_array.forEach((text, idx) => {
            addEditMemutuskanField(text);
        });

        loadEditMengingatOptions(sk.mengingat_array);

        if (typeof FormDirtyMonitor !== 'undefined') {
            new FormDirtyMonitor('editSkForm', 'submitEditSkBtn');
        }
    }

    function resetEditSkForm() {
        if (currentSkDraftData) {
            populateEditSkForm(currentSkDraftData);
        }
    }

    async function loadEditMengingatOptions(selectedIds) {
        try {
            const response = await fetch('/api/regulasi');
            let data = await response.json();
            if (data.data) data = data.data;

            const listContainer = document.getElementById('editMengingatList');
            listContainer.innerHTML = '';

            if (!Array.isArray(data) || data.length === 0) {
                listContainer.innerHTML = '<div class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada data regulasi</div>';
                return;
            }

            data.forEach((item, index) => {
                const itemId = parseInt(item.id_regulasi);
                const isChecked = Array.isArray(selectedIds) && selectedIds.some(id => parseInt(id) === itemId);
                const checkboxItem = document.createElement('div');
                checkboxItem.className = 'flex items-start mb-2 pb-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0';
                checkboxItem.innerHTML = `
                    <input type="checkbox" name="mengingat[]" value="${item.id_regulasi}"
                        id="edit_mengingat_${index}" ${isChecked ? 'checked' : ''}
                        class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded cursor-pointer">
                    <label for="edit_mengingat_${index}" class="ml-3 flex-1 cursor-pointer">
                        <span class="text-sm text-gray-700 dark:text-gray-300 font-medium block">${item.isi_regulasi}</span>
                    </label>
                `;
                listContainer.appendChild(checkboxItem);
            });
        } catch (error) {
            console.error('Error loading regulasi options:', error);
            document.getElementById('editMengingatList').innerHTML = '<div class="text-sm text-red-500">Gagal memuat data</div>';
        }
    }

    function addEditMenimbangField(text = '') {
        const container = document.getElementById('editMenimbangContainer');
        const items = container.querySelectorAll('.menimbang-item').length;
        if (items >= 10) { notify('warning', 'Peringatan', 'Maksimal 10 poin Menimbang.', false); return; }
        const labelChar = String.fromCharCode('a'.charCodeAt(0) + items) + '.';
        const wrapper = document.createElement('div');
        wrapper.className = 'menimbang-item flex gap-3';
        wrapper.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-10 flex-shrink-0">${labelChar}</label>
            <div class="flex-1 flex gap-2">
                <input type="text" name="menimbang[]" value="${text}" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                <button type="button" onclick="removeEditSkField(this, 'editMenimbangContainer', 'menimbang-item')" class="mt-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(wrapper);
    }

    function addEditMemutuskanField(text = '') {
        const container = document.getElementById('editKesatuContainer');
        if (editMemutuskanCounter >= 10) { notify('warning', 'Peringatan', 'Maksimal 10 poin Memutuskan.', false); return; }
        const labels = ['Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam', 'Ketujuh', 'Kedelapan', 'Kesembilan', 'Kesepuluh'];
        const label = labels[editMemutuskanCounter] || `Ke-${editMemutuskanCounter + 1}`;
        const wrapper = document.createElement('div');
        wrapper.className = 'memutuskan-item flex gap-3 mb-2';
        wrapper.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">${label} :</label>
            <div class="flex-1 flex gap-2">
                <textarea name="memutuskan[]" rows="2" class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y">${text}</textarea>
                ${editMemutuskanCounter > 0 ? `
                <button type="button" onclick="removeEditSkField(this, 'editKesatuContainer', 'memutuskan-item')" class="mt-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                    <i class="fas fa-trash"></i>
                </button>` : ''}
            </div>
        `;
        container.appendChild(wrapper);
        editMemutuskanCounter++;
    }

    function removeEditSkField(button, containerId, itemClass) {
        const item = button.closest(`.${itemClass}`);
        item.remove();
        const container = document.getElementById(containerId);
        const items = container.querySelectorAll(`.${itemClass}`);

        if (itemClass === 'menimbang-item') {
            items.forEach((el, idx) => {
                el.querySelector('label').textContent = String.fromCharCode('a'.charCodeAt(0) + idx) + '.';
            });
        } else {
            const labels = ['Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam', 'Ketujuh', 'Kedelapan', 'Kesembilan', 'Kesepuluh'];
            items.forEach((el, idx) => {
                el.querySelector('label').textContent = (labels[idx] || `Ke-${idx + 1}`) + ' :';
            });
            editMemutuskanCounter = items.length;
        }
    }

    function filterEditMengingat() {
        const searchValue = document.getElementById('searchEditMengingat').value.toLowerCase();
        const items = document.querySelectorAll('#editMengingatList > div');
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

        const noResultId = 'noEditMengingatResult';
        let noResultMsg = document.getElementById(noResultId);

        if (visibleCount === 0 && items.length > 0) {
            if (!noResultMsg) {
                noResultMsg = document.createElement('div');
                noResultMsg.id = noResultId;
                noResultMsg.className = 'text-center text-gray-500 dark:text-gray-400 py-4';
                noResultMsg.innerHTML = '<i class="fas fa-search mr-2"></i>Tidak ada regulasi yang cocok';
                document.getElementById('editMengingatList').appendChild(noResultMsg);
            }
        } else if (noResultMsg) {
            noResultMsg.remove();
        }
    }

    function combineEditNomorSurat() {
        const part1 = document.getElementById('edit_nomor_surat_part1').value.trim();
        const part2 = document.getElementById('edit_nomor_surat_part2').value.trim();
        const part3 = document.getElementById('edit_nomor_surat_part3').value.trim();
        const part4 = document.getElementById('edit_nomor_surat_part4').value.trim();

        const combined = `${part1}/${part2}/${part3}/${part4}`;
        document.getElementById('edit_nomor_surat_combined').value = combined;
    }

    function submitEditSKForm(event) {
        event.preventDefault();
        const form = document.getElementById('editSkForm');

        combineEditNomorSurat();
        const id = currentEditSkId;
        const formData = new FormData(form);

        const submitBtn = document.getElementById('submitEditSkBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui';

        fetch(`/sk-direktur/${id}`, {
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
                    closeModal('modalEditSK');
                    notify('success', 'Berhasil', result.message);

                    window.dispatchEvent(new CustomEvent('update-sk-draft', { detail: result.data }));

                    setTimeout(() => {
                        window.openDraftPreview(result.data);
                    }, 500);
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
                submitBtn.innerHTML = 'Perbarui';
            });
    }
</script>