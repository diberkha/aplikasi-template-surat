<div id="modalEditSK" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalEditSK')"></div>

        <div
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-4xl w-full max-h-[95vh] overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700">

            <div
                class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white truncate pr-4">Edit Draft
                    Surat
                    Keputusan Direktur</h3>
                <button onclick="closeModal('modalEditSK')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-times text-base sm:text-lg"></i>
                </button>
            </div>

            <form id="editSkForm" onsubmit="submitEditSKForm(event)" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_sk_id_surat">

                <div class="p-6 space-y-6 overflow-y-auto flex-1 custom-scrollbar">

                    <div
                        class="bg-blue-50 dark:bg-blue-900/20 p-4 sm:p-6 rounded-xl border border-blue-200 dark:border-blue-800">
                        <div class="space-y-5">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Nomor Surat <span
                                        class="text-red-500">*</span></label>
                                <div class="flex flex-wrap items-center gap-2 w-full">
                                    <input type="text" id="edit_nomor_surat_part1" name="nomor_surat_part1"
                                        oninput="combineEditNomorSurat(); if(window.formDirtyMonitors && window.formDirtyMonitors['editSkForm']) window.formDirtyMonitors['editSkForm'].check();"
                                        class="flex-1 min-w-[60px] px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                                        required>
                                    <span class="text-gray-400 font-bold">/</span>
                                    <input type="text" id="edit_nomor_surat_part2" name="nomor_surat_part2"
                                        oninput="combineEditNomorSurat(); if(window.formDirtyMonitors && window.formDirtyMonitors['editSkForm']) window.formDirtyMonitors['editSkForm'].check();"
                                        class="flex-1 min-w-[60px] px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                                        required>
                                    <span class="text-gray-400 font-bold">/</span>
                                    <input type="text" id="edit_nomor_surat_part3" name="nomor_surat_part3"
                                        oninput="combineEditNomorSurat(); if(window.formDirtyMonitors && window.formDirtyMonitors['editSkForm']) window.formDirtyMonitors['editSkForm'].check();"
                                        class="flex-1 min-w-[60px] px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                                        required>
                                    <span class="text-gray-400 font-bold">/</span>
                                    <input type="text" id="edit_nomor_surat_part4" name="nomor_surat_part4"
                                        oninput="combineEditNomorSurat(); if(window.formDirtyMonitors && window.formDirtyMonitors['editSkForm']) window.formDirtyMonitors['editSkForm'].check();"
                                        class="flex-1 min-w-[60px] px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
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
                                <textarea name="tentang" id="edit_sk_tentang" required rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 resize-y"></textarea>
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
                            <button type="button" id="btnEditTambahMenimbang" onclick="addEditMenimbangField()"
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
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" id="searchEditMengingat" placeholder="Cari regulasi..."
                                        class="w-full pl-10 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all"
                                        onkeyup="filterEditMengingat()">
                                    <button type="button" onclick="clearEditSearchMengingat()"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hidden group-focus-within:flex"
                                        id="btnClearEditSearchMengingat">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
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
                                <div class="memutuskan-item flex flex-col sm:flex-row sm:gap-3 mb-4">
                                    <label
                                        class="sm:mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap sm:w-28 flex-shrink-0 mb-1 sm:mb-0">Menetapkan
                                        :</label>
                                    <textarea name="menetapkan" id="edit_sk_menetapkan" rows="2"
                                        class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                                </div>
                                <div id="editKesatuContainer" class="space-y-4"></div>
                            </div>
                            <button type="button" id="btnEditTambahMemutuskan" onclick="addEditMemutuskanField()"
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
                    class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3 rounded-b-2xl">
                    <button type="button" onclick="resetEditSkForm()"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                        Reset
                    </button>
                    <button type="submit" id="submitEditSkBtn"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-normal transition-colors">
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
    let isInitializing = false;

    async function openEditSkModal(id) {
        try {
            currentEditSkId = id;
            const response = await fetch("{{ url('sk-direktur') }}/" + id + "/edit");
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

    async function populateEditSkForm(data) {
        isInitializing = true;
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

        await loadEditMengingatOptions(sk.mengingat_array);
        combineEditNomorSurat();

        if (typeof FormDirtyMonitor !== 'undefined') {
            if (window.formDirtyMonitors && window.formDirtyMonitors['editSkForm']) {
                window.formDirtyMonitors['editSkForm'].destroy();
            }
            new FormDirtyMonitor('editSkForm', 'submitEditSkBtn');
        }

        isInitializing = false;
    }

    function resetEditSkForm() {
        if (currentSkDraftData) {
            populateEditSkForm(currentSkDraftData);
        }
    }

    function loadEditMengingatOptions(selectedIds) {
        let data = @json($regulasis);
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
    }

    function addEditMenimbangField(text = '') {
        const container = document.getElementById('editMenimbangContainer');
        const items = container.querySelectorAll('.menimbang-item').length;
        const btn = document.getElementById('btnEditTambahMenimbang');

        if (items >= 10) {
            notify('warning', 'Peringatan', 'Maksimal 10 poin Menimbang.', false);
            if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            }
            return;
        }

        const labelChar = String.fromCharCode('a'.charCodeAt(0) + items) + '.';
        const wrapper = document.createElement('div');
        wrapper.className = 'menimbang-item flex flex-col sm:flex-row sm:gap-3 mb-2 px-1';
        wrapper.innerHTML = `
            <label class="sm:mt-3 text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap sm:w-8 flex-shrink-0 mb-1 sm:mb-0">${labelChar}</label>
            <div class="flex-1 flex gap-2">
                <textarea name="menimbang[]" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500" rows="2">${text}</textarea>
                <button type="button" onclick="removeEditSkField(this, 'editMenimbangContainer', 'menimbang-item')" class="h-10 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors border border-transparent hover:border-red-200">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(wrapper);

        if (container.querySelectorAll('.menimbang-item').length >= 10) {
            if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        if (window.formDirtyMonitors && window.formDirtyMonitors['editSkForm']) {
            window.formDirtyMonitors['editSkForm'].check();
        }
    }

    function addEditMemutuskanField(text = '') {
        const container = document.getElementById('editKesatuContainer');
        const btn = document.getElementById('btnEditTambahMemutuskan');

        if (editMemutuskanCounter >= 10) {
            notify('warning', 'Peringatan', 'Maksimal 10 poin Memutuskan.', false);
            if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            }
            return;
        }

        const labels = ['Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam', 'Ketujuh', 'Kedelapan', 'Kesembilan', 'Kesepuluh'];
        const label = labels[editMemutuskanCounter] || `Ke-${editMemutuskanCounter + 1}`;
        const wrapper = document.createElement('div');
        wrapper.className = 'memutuskan-item flex flex-col sm:flex-row sm:gap-3 mb-4 px-1';
        wrapper.innerHTML = `
            <label class="sm:mt-3 text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap sm:w-28 flex-shrink-0 mb-1 sm:mb-0">${label} :</label>
            <div class="flex-1 flex gap-2">
                <textarea name="memutuskan[]" rows="2" class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y focus:ring-2 focus:ring-blue-500">${text}</textarea>
                ${editMemutuskanCounter > 0 ? `
                <button type="button" onclick="removeEditSkField(this, 'editKesatuContainer', 'memutuskan-item')" class="h-10 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors border border-transparent hover:border-red-200">
                    <i class="fas fa-trash"></i>
                </button>` : ''}
            </div>
        `;
        container.appendChild(wrapper);
        editMemutuskanCounter++;

        if (editMemutuskanCounter >= 10) {
            if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        if (window.formDirtyMonitors && window.formDirtyMonitors['editSkForm']) {
            window.formDirtyMonitors['editSkForm'].check();
        }
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
            const btn = document.getElementById('btnEditTambahMenimbang');
            if (btn && items.length < 10) {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        } else {
            const labels = ['Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam', 'Ketujuh', 'Kedelapan', 'Kesembilan', 'Kesepuluh'];
            items.forEach((el, idx) => {
                el.querySelector('label').textContent = (labels[idx] || `Ke-${idx + 1}`) + ' :';
            });
            editMemutuskanCounter = items.length;
            const btn = document.getElementById('btnEditTambahMemutuskan');
            if (btn && editMemutuskanCounter < 10) {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        if (window.formDirtyMonitors && window.formDirtyMonitors['editSkForm']) {
            window.formDirtyMonitors['editSkForm'].check();
        }
    }

    function filterEditMengingat() {
        const input = document.getElementById('searchEditMengingat');
        const searchValue = input.value.toLowerCase();
        const items = document.querySelectorAll('#editMengingatList > div');
        const clearBtn = document.getElementById('btnClearEditSearchMengingat');
        let visibleCount = 0;

        if (clearBtn) {
            clearBtn.classList.toggle('hidden', searchValue === '');
        }

        items.forEach(item => {
            const label = item.querySelector('label span');
            if (!label) return;
            const text = label.textContent.toLowerCase();
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

    function clearEditSearchMengingat() {
        const input = document.getElementById('searchEditMengingat');
        input.value = '';
        const clearBtn = document.getElementById('btnClearEditSearchMengingat');
        if (clearBtn) clearBtn.classList.add('hidden');
        filterEditMengingat();
        input.focus();
    }

    function combineEditNomorSurat() {
        const part1 = document.getElementById('edit_nomor_surat_part1').value.trim();
        const part2 = document.getElementById('edit_nomor_surat_part2').value.trim();
        const part3 = document.getElementById('edit_nomor_surat_part3').value.trim();
        const part4 = document.getElementById('edit_nomor_surat_part4').value.trim();

        const combined = `${part1}/${part2}/${part3}/${part4}`;
        document.getElementById('edit_nomor_surat_combined').value = combined;
    }

    async function submitEditSKForm(event) {
        event.preventDefault();
        const form = document.getElementById('editSkForm');

        combineEditNomorSurat();
        const id = currentEditSkId;
        const formData = new FormData(form);

        const submitBtn = document.getElementById('submitEditSkBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui';

        try {
            const response = await fetch("{{ url('sk-direktur') }}/" + id, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                closeModal('modalEditSK');
                notify('success', 'Berhasil', result.message);

                window.dispatchEvent(new CustomEvent('update-sk-draft', { detail: result.data }));

                setTimeout(() => {
                    window.openDraftPreview(result.data, true);
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