<div id="modalEditSurat" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-3xl w-full">

        <!-- HEADER -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Surat Hukum</h3>
            <button onclick="closeEditModalAndBackToDetail()"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- FORM -->
        <form id="editSuratForm" onsubmit="submitEditForm(event)">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_surat_id" name="surat_id">

            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">

                <!-- JUDUL SURAT -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Judul Surat <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="judul_surat" id="edit_judul_surat" required
                        placeholder="Contoh: KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM..."
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>

                <!-- NOMOR SURAT -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Nomor Surat <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nomor_surat" id="edit_nomor_surat" required
                        placeholder="Contoh: 006/SHKS/VI/2024"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>

                <!-- TENTANG -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Tentang <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="tentang" id="edit_tentang" required
                        placeholder="Contoh: Pembentukan Tim Kendali Mutu..."
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>

                <!-- IDENTITAS PENETAP -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Identitas Penetap <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="identitas_penetap" id="edit_identitas_penetap" required
                        placeholder="Contoh: DIREKTUR RSUD dr. SOERATNO GEMOLONG"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>

                <!-- MENIMBANG -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Menimbang <span
                            class="text-red-500">*</span></label>
                    <textarea name="menimbang" id="edit_menimbang" rows="5" required
                        placeholder="Isi menimbang..."
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                </div>

                <!-- MENGINGAT -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Mengingat <span
                            class="text-red-500">*</span></label>
                    <textarea name="mengingat" id="edit_mengingat" rows="5" required
                        placeholder="Isi mengingat..."
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                </div>

                <!-- MEMUTUSKAN (Dynamic Fields) -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Memutuskan <span class="text-red-500">*</span>
                    </label>
                    <div id="editMemutuskanContainer" class="space-y-3">
                        <!-- Will be populated dynamically -->
                    </div>
                    <button type="button" onclick="addEditMemutuskanField()"
                        class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Keputusan
                    </button>
                </div>

                <!-- TEMPAT & TANGGAL -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Lokasi Dibuat <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="tempat_dibuat" id="edit_tempat_dibuat" required
                            placeholder="Gemolong"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Dibuat <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_dibuat" id="edit_tanggal_dibuat" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <!-- JABATAN & NAMA PEMBUAT -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Jabatan Pembuat <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="jabatan_pembuat" id="edit_jabatan_pembuat" required
                            placeholder="Direktur"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Pembuat <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_pembuat" id="edit_nama_pembuat" required
                            placeholder="dr. John Doe"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                <button type="button" onclick="resetEditForm()"
                    class="px-5 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    Reset
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let editMemutuskanCounter = 0;
    let currentEditSuratId = null;
    let originalEditFormData = null; // Store original form data for reset

    // Close edit modal and return to detail modal
    function closeEditModalAndBackToDetail() {
        closeModal('modalEditSurat');
        // Re-open detail modal
        setTimeout(() => {
            openModal('modalDetailSurat');
        }, 100);
    }

    // Open edit modal and load surat data
    function openEditModal() {
        const detailModal = document.getElementById('modalDetailSurat');
        const suratId = detailModal.dataset.suratId;
        
        if (!suratId) {
            alert('Error: ID surat tidak ditemukan');
            return;
        }

        currentEditSuratId = suratId;
        
        // Fetch surat data
        fetch(`/arsip-surat/${suratId}/edit`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success && result.surat) {
                populateEditForm(result.surat);
                closeModal('modalDetailSurat');
                document.getElementById('modalEditSurat').classList.remove('hidden');
            } else {
                alert('Gagal memuat data surat');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat data surat');
        });
    }

    // Populate edit form with surat data
    function populateEditForm(surat) {
        // Store original data for reset functionality
        originalEditFormData = JSON.parse(JSON.stringify(surat));
        
        document.getElementById('edit_surat_id').value = surat.id_surat;
        document.getElementById('edit_judul_surat').value = surat.sk_direktur?.judul_surat || '';
        document.getElementById('edit_nomor_surat').value = surat.nomor_surat;
        document.getElementById('edit_tentang').value = surat.sk_direktur?.tentang || '';
        document.getElementById('edit_identitas_penetap').value = surat.sk_direktur?.identitas_penetap || '';
        document.getElementById('edit_menimbang').value = surat.sk_direktur?.menimbang || '';
        document.getElementById('edit_mengingat').value = surat.sk_direktur?.mengingat || '';
        document.getElementById('edit_tempat_dibuat').value = surat.sk_direktur?.tempat_dibuat || '';
        document.getElementById('edit_tanggal_dibuat').value = surat.tanggal_dibuat;
        document.getElementById('edit_jabatan_pembuat').value = surat.sk_direktur?.jabatan_pembuat || '';
        document.getElementById('edit_nama_pembuat').value = surat.sk_direktur?.nama_pembuat || '';

        // Parse memutuskan field (format: KESATU\ntext\n\nKEDUA\ntext\n\n)
        const memutuskanText = surat.sk_direktur?.memutuskan || '';
        const memutuskanItems = parseMemutuskan(memutuskanText);
        
        // Populate memutuskan fields
        const container = document.getElementById('editMemutuskanContainer');
        container.innerHTML = '';
        editMemutuskanCounter = 0;
        
        const labels = ['Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam', 'Ketujuh', 'Kedelapan', 'Kesembilan', 'Kesepuluh'];
        
        memutuskanItems.forEach((item, index) => {
            const label = labels[index] || `Ke-${index + 1}`;
            addEditMemutuskanField(item, label);
        });
    }

    // Reset edit form to original data
    function resetEditForm() {
        if (originalEditFormData) {
            populateEditForm(originalEditFormData);
        }
    }

    // Parse memutuskan text into array
    function parseMemutuskan(text) {
        if (!text || text.trim() === '') return ['', '', '']; // Default 3 fields
        
        const items = [];
        const lines = text.split('\n');
        let currentItem = '';
        let skipNext = false;
        
        for (let i = 0; i < lines.length; i++) {
            const line = lines[i].trim();
            
            // Check if line is a label (KESATU, KEDUA, etc.)
            if (/^(KESATU|KEDUA|KETIGA|KEEMPAT|KELIMA|KEENAM|KETUJUH|KEDELAPAN|KESEMBILAN|KESEPULUH|KE-\d+)$/i.test(line)) {
                if (currentItem.trim()) {
                    items.push(currentItem.trim());
                }
                currentItem = '';
                skipNext = false;
            } else if (line) {
                currentItem += (currentItem ? '\n' : '') + line;
            }
        }
        
        if (currentItem.trim()) {
            items.push(currentItem.trim());
        }
        
        // Ensure at least 3 items
        while (items.length < 3) {
            items.push('');
        }
        
        return items;
    }

    // Add memutuskan field for edit form
    function addEditMemutuskanField(value = '', customLabel = null) {
        const labels = ['Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam', 'Ketujuh', 'Kedelapan', 'Kesembilan', 'Kesepuluh'];
        const label = customLabel || labels[editMemutuskanCounter] || `Ke-${editMemutuskanCounter + 1}`;
        
        const container = document.getElementById('editMemutuskanContainer');
        const item = document.createElement('div');
        item.className = 'edit-memutuskan-item flex gap-2';
        item.innerHTML = `
            <div class="flex-1">
                <label class="block mb-1 text-sm text-gray-600 dark:text-gray-400">${label}</label>
                <textarea name="memutuskan[]" rows="2" required
                    placeholder="Isi keputusan ${label.toLowerCase()}..."
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y">${value}</textarea>
            </div>
            ${editMemutuskanCounter >= 3 ? `
            <button type="button" onclick="this.closest('.edit-memutuskan-item').remove(); editMemutuskanCounter--;"
                class="self-end px-3 py-3 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
            ` : ''}
        `;
        
        container.appendChild(item);
        editMemutuskanCounter++;
    }

    // Submit edit form
    function submitEditForm(event) {
        event.preventDefault();
        
        const form = document.getElementById('editSuratForm');
        const formData = new FormData(form);
        const suratId = currentEditSuratId;
        
        if (!suratId) {
            alert('Error: ID surat tidak ditemukan');
            return;
        }
        
        // Disable submit button
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Menyimpan...';
        
        fetch(`/arsip-surat/${suratId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                closeModal('modalEditSurat');
                if (typeof showNotification === 'function') {
                    showNotification('success', 'Berhasil!', 'Surat berhasil diupdate');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    alert('Surat berhasil diupdate!');
                    window.location.reload();
                }
            } else {
                // Display validation errors
                if (result.errors) {
                    let errorMsg = 'Validasi Gagal:\n\n';
                    for (let [field, messages] of Object.entries(result.errors)) {
                        errorMsg += `❌ ${field}: ${Array.isArray(messages) ? messages.join(', ') : messages}\n`;
                    }
                    if (typeof showNotification === 'function') {
                        showNotification('error', 'Validasi Gagal', errorMsg, false);
                    } else {
                        alert(errorMsg);
                    }
                } else {
                    const msg = 'Gagal mengupdate surat: ' + (result.message || 'Kesalahan tidak diketahui');
                    if (typeof showNotification === 'function') {
                        showNotification('error', 'Error!', msg, false);
                    } else {
                        alert(msg);
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Perbarui';
        });
    }
</script>
