<div id="modalCreateSK" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full">

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Buat Keputusan Direktur</h3>
            <button onclick="closeModal('modalCreateSK')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form action="{{ route('template-surat.sk-direktur.store') }}" method="POST" id="skDirekturForm" onsubmit="submitFormAJAX(event)">
            @csrf
            <input type="hidden" name="template_id" id="template_surat_sk">

            <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">

                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="space-y-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Nomor Surat <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_surat" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Nomor surat tidak boleh sama dengan surat yang sudah ada
                            </p>
                        </div>

                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Tentang <span class="text-red-500">*</span></label>
                            <input type="text" name="tentang" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">MENIMBANG</h4>
                    </div>
                    <div class="p-4">
                        <div id="menimbangContainer" class="space-y-3">
                            <div class="menimbang-item flex gap-3">
                                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-10 flex-shrink-0">a.</label>
                                <div class="flex-1">
                                    <input type="text" name="menimbang[]" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="addMenimbangField()"
                            class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Menimbang
                        </button>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">MENGINGAT</h4>
                    </div>
                    <div class="p-4">
                        <input type="hidden" name="mengingat_check" id="mengingat_check">

                        <div class="mb-3">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" id="searchMengingat" placeholder="Cari regulasi..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    onkeyup="filterMengingat()">
                            </div>
                        </div>

                        <div id="mengingatList" class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 bg-white max-h-64 overflow-y-auto">
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
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">MEMUTUSKAN</h4>
                    </div>
                    <div class="p-4">
                        <div id="memutuskanContainer" class="space-y-3">
                            <div class="memutuskan-item flex gap-3">
                                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">Menetapkan :</label>
                                <textarea name="menetapkan" id="menetapkan_input" rows="2"
                                    class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                            </div>
                            <div class="memutuskan-item flex gap-3">
                                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">Kesatu :</label>
                                <textarea name="memutuskan[]" rows="2" required
                                    class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                            </div>
                            <div class="memutuskan-item flex gap-3">
                                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">Kedua :</label>
                                <textarea name="memutuskan[]" rows="2" required
                                    class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                            </div>
                        </div>
                        <button type="button" onclick="addMemutuskanField()" 
                            class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Memutuskan
                        </button>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">TEMPAT & TANGGAL PENETAPAN</h4>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Tempat <span class="text-red-500">*</span></label>
                                <input type="text" name="tempat_dibuat" required placeholder="Contoh: Gemolong"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Surat <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_dibuat" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-3">
                <button type="button" onclick="resetFormSK()"
                    class="px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    Reset
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let memutuskanCounter = 2; 

    document.addEventListener('DOMContentLoaded', function() {
        loadRegulasiOptions();

        const dateInput = document.querySelector('input[name="tanggal_dibuat"]');
        if (dateInput && typeof flatpickr !== 'undefined') {
            flatpickr(dateInput, {
                locale: 'id',
                dateFormat: 'Y-m-d'
            });
        }

        document.getElementById('skDirekturForm').addEventListener('submit', function(e) {
            const mengingatCheckboxes = document.querySelectorAll('input[name="mengingat[]"]:checked');
            if (mengingatCheckboxes.length === 0) {
                e.preventDefault();
                alert('Silakan pilih minimal satu Mengingat');
                return false;
            }
        });
    });

    async function loadRegulasiOptions() {
        try {
            const response = await fetch('/api/regulasi');
            let data = await response.json();
            if (data.data) data = data.data;

            const listContainer = document.getElementById('mengingatList');
            listContainer.innerHTML = '';
            if (!Array.isArray(data) || data.length === 0) {
                listContainer.innerHTML = '<div class="text-sm text-gray-500 dark:text-gray-400 text-center py-4"><i class="fas fa-exclamation-circle mr-2"></i>Tidak ada data regulasi</div>';
                return;
            }
            data.forEach((item, index) => {
                const checkboxItem = document.createElement('div');
                checkboxItem.className = 'mengingat-item flex items-start mb-2 pb-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0';
                checkboxItem.innerHTML = `
                    <input type="checkbox" name="mengingat[]" value="${item.id_regulasi}" 
                        id="mengingat_${index}" class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded cursor-pointer"
                        onchange="updateMengingatCheck()">
                    <label for="mengingat_${index}" class="ml-3 flex-1 cursor-pointer">
                        <span class="text-sm text-gray-700 dark:text-gray-300 font-medium block">${item.isi_regulasi}</span>
                    </label>
                `;
                listContainer.appendChild(checkboxItem);
            });
        } catch (error) {
            console.error('Error loading regulasi options:', error);
            const listContainer = document.getElementById('mengingatList');
            listContainer.innerHTML = '<div class="text-sm text-red-500 dark:text-red-400 text-center py-4"><i class="fas fa-exclamation-circle mr-2"></i>Gagal memuat data</div>';
        }
    }

    function updateMengingatCheck() {
        const checkboxes = document.querySelectorAll('input[name="mengingat[]"]:checked');
        document.getElementById('mengingat_check').value = checkboxes.length > 0 ? 'yes' : '';
    }

    function filterMengingat() {
        const searchValue = document.getElementById('searchMengingat').value.toLowerCase();
        const items = document.querySelectorAll('#mengingatList .mengingat-item');
        let visibleCount = 0;
        items.forEach(item => {
            const label = item.querySelector('label');
            if (!label) return;
            const text = label.textContent.toLowerCase();
            if (text.includes(searchValue)) { item.style.display = ''; visibleCount++; }
            else { item.style.display = 'none'; }
        });
        const noResultMsg = document.getElementById('noMengingatResult');
        if (visibleCount === 0 && items.length > 0) {
            if (!noResultMsg) {
                const msg = document.createElement('div');
                msg.id = 'noMengingatResult';
                msg.className = 'text-center text-gray-500 dark:text-gray-400 py-4';
                msg.innerHTML = '<i class="fas fa-search mr-2"></i>Tidak ada regulasi yang cocok';
                document.getElementById('mengingatList').appendChild(msg);
            }
        } else if (noResultMsg) { noResultMsg.remove(); }
    }

    function addMemutuskanField() {
        const maxAllowed = 6;
        if (memutuskanCounter >= maxAllowed) { alert('Maksimal sampai keenam.'); return; }
        const container = document.getElementById('memutuskanContainer');
        const labels = ['Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam'];
        const label = labels[memutuskanCounter] || `Ke-${memutuskanCounter + 1}`;
        const newField = document.createElement('div');
        newField.className = 'memutuskan-item flex gap-3';
        newField.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">${label} :</label>
            <div class="flex-1 flex gap-2">
                <textarea name="memutuskan[]" rows="2" class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                <button type="button" onclick="removeMemutuskanField(this)" class="mt-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newField);
        memutuskanCounter++;
    }

    function removeMemutuskanField(button) {
        const item = button.closest('.memutuskan-item');
        item.remove();
        memutuskanCounter--;
    }

    function resetFormSK() {
        const form = document.getElementById('skDirekturForm');
        form.reset();
        const container = document.getElementById('memutuskanContainer');
        container.innerHTML = `
            <div class="memutuskan-item flex gap-3">
                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">Menetapkan :</label>
                <textarea name="menetapkan" id="menetapkan_input" rows="2" class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
            </div>
            <div class="memutuskan-item flex gap-3">
                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">Kesatu :</label>
                <textarea name="memutuskan[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
            </div>
            <div class="memutuskan-item flex gap-3">
                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">Kedua :</label>
                <textarea name="memutuskan[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
            </div>
        `;
        memutuskanCounter = 2;

        const menimbangContainer = document.getElementById('menimbangContainer');
        if (menimbangContainer) {
            menimbangContainer.innerHTML = `
                <div class="menimbang-item flex gap-3">
                    <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-10 flex-shrink-0">a.</label>
                    <div class="flex-1">
                        <input type="text" name="menimbang[]" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
            `;
        }

        const mengingatCheckboxes = document.querySelectorAll('input[name="mengingat[]"]');
        mengingatCheckboxes.forEach(checkbox => { checkbox.checked = false; });
        updateMengingatCheck();
    }

    function addMenimbangField() {
        const container = document.getElementById('menimbangContainer');
        const items = container.querySelectorAll('.menimbang-item').length;
        const labelChar = String.fromCharCode('a'.charCodeAt(0) + items) + '.';
        const wrapper = document.createElement('div');
        wrapper.className = 'menimbang-item flex gap-3';
        wrapper.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-10 flex-shrink-0">${labelChar}</label>
            <div class="flex-1 flex gap-2">
                <input type="text" name="menimbang[]" class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                <button type="button" onclick="removeMenimbangField(this)" class="mt-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(wrapper);
    }

    function removeMenimbangField(button) {
        const item = button.closest('.menimbang-item');
        const container = document.getElementById('menimbangContainer');
        if (container.querySelectorAll('.menimbang-item').length <= 1) return;
        item.remove();
        renumberMenimbangLabels();
    }

    function renumberMenimbangLabels() {
        const container = document.getElementById('menimbangContainer');
        const items = container.querySelectorAll('.menimbang-item');
        items.forEach((el, idx) => {
            const lbl = el.querySelector('label');
            if (lbl) lbl.textContent = String.fromCharCode('a'.charCodeAt(0) + idx) + '.';
        });
    }

    function submitFormAJAX(event) {
        event.preventDefault();
        const form = document.getElementById('skDirekturForm');

        const memutuskanAreas = document.querySelectorAll('#memutuskanContainer textarea[name="memutuskan[]"]');
        if (memutuskanAreas.length < 2 || !memutuskanAreas[0].value.trim() || !memutuskanAreas[1].value.trim()) {
            alert('Memutuskan minimal harus mengisi kesatu dan kedua.');
            return;
        }

        const menimbangInputs = document.querySelectorAll('#menimbangContainer input[name="menimbang[]"]');
        const nonEmptyMenimbang = Array.from(menimbangInputs).filter(i => i.value.trim() !== '');
        if (nonEmptyMenimbang.length === 0) {
            alert('Minimal satu poin Menimbang harus diisi.');
            return;
        }

        const formData = new FormData(form);

        const memutuskanValues = Array.from(memutuskanAreas).map(a => a.value.trim()).filter(v => v !== '');
        while (formData.has('memutuskan[]')) { formData.delete('memutuskan[]'); }
        memutuskanValues.forEach(v => formData.append('memutuskan[]', v));

        const menimbangValues = Array.from(menimbangInputs).map(i => i.value.trim()).filter(v => v !== '');
        while (formData.has('menimbang[]')) { formData.delete('menimbang[]'); }
        menimbangValues.forEach(v => formData.append('menimbang[]', v));

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan';

        fetch(form.action, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
        .then(response => response.json().then(data => ({ status: response.status, ok: response.ok, data })).catch(() => ({ status: response.status, ok: response.ok, parseError: true })))
        .then(result => {
            if (result.parseError) { alert('Error: Response parsing failed.'); return; }
            if (!result.ok) {
                if (result.data?.errors) {
                    const fieldLabels = { 'nomor_surat': 'Nomor Surat', 'tentang': 'Tentang', 'menimbang': 'Menimbang', 'mengingat': 'Mengingat', 'menetapkan': 'Menetapkan', 'memutuskan': 'Memutuskan', 'tempat_dibuat': 'Tempat', 'tanggal_dibuat': 'Tanggal Surat' };
                    let errorMsg = 'Validasi Gagal:\n\n';
                    for (let [field, messages] of Object.entries(result.data.errors)) {
                        const baseField = field.startsWith('memutuskan') ? 'memutuskan' : (field.startsWith('menimbang') ? 'menimbang' : field);
                        const fieldLabel = fieldLabels[baseField] || baseField;
                        const messageText = Array.isArray(messages) ? messages.join(', ') : messages;
                        errorMsg += `❌ ${fieldLabel}: ${messageText}\n`;
                    }
                    alert(errorMsg);
                } else {
                    alert('Error: ' + (result.data?.message || 'Server error: ' + result.status));
                }
                return;
            }

            if (result.data.success) {
                closeModal('modalCreateSK');
                form.reset(); memutuskanCounter = 2;
                showSuccessMessage('Surat berhasil dibuat!');
                setTimeout(() => { openPreviewPDF(result.data.file_url, result.data.nomor_surat, result.data.surat_id, 'KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM DAERAH dr. SOERATNO GEMOLONG', result.data.tanggal_dibuat); }, 500);
            } else { alert('Gagal membuat surat: ' + (result.data.message || 'Kesalahan tidak diketahui')); }
        })
        .catch(error => { console.error('Fetch error:', error); alert('Terjadi kesalahan: ' + error.message); })
        .finally(() => { submitBtn.disabled = false; submitBtn.innerHTML = 'Simpan'; });
    }

    function showSuccessMessage(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center animate-pulse';
        alertDiv.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
        document.body.appendChild(alertDiv);
        setTimeout(() => alertDiv.remove(), 3000);
    }
</script>