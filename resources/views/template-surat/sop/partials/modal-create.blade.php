<div id="modalCreateSOP" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full">

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Buat Standar Operasional Prosedur (SOP)</h3>
            <button onclick="closeModal('modalCreateSOP')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form action="{{ route('template-surat.sop.store') }}" method="POST" id="sopForm" onsubmit="submitSOPForm(event)">
            @csrf
            <input type="hidden" name="template_id" id="template_surat_sop">

            <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">
                
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="space-y-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Judul SOP <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_sop" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">No. Dokumen <span class="text-red-500">*</span></label>
                                <input type="text" name="nomor_dokumen" required 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-gray-700 dark:text-gray-300">No. Revisi <span class="text-red-500">*</span></label>
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
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Terbit <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_terbit" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">PENGERTIAN</h4>
                    </div>
                    <div class="p-4">
                        <textarea name="pengertian" rows="3" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">TUJUAN</h4>
                    </div>
                    <div class="p-4">
                        <textarea name="tujuan" rows="3" required 
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">KEBIJAKAN</h4>
                    </div>
                    <div class="p-4">
                        <div id="kebijakanContainer" class="space-y-3">
                            <div class="kebijakan-item flex gap-3">
                                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">1.</label>
                                <div class="flex-1">
                                    <textarea name="kebijakan[]" rows="2" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="addKebijakanField()"
                            class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Kebijakan
                        </button>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">PROSEDUR</h4>
                    </div>
                    <div class="p-4">
                        <div id="prosedurContainer" class="space-y-3">
                            <div class="prosedur-item flex gap-3">
                                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">1.</label>
                                <div class="flex-1">
                                    <textarea name="prosedur[]" rows="2" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="addProsedurField()"
                            class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Prosedur
                        </button>
                    </div>
                </div>

                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-white">UNIT TERKAIT</h4>
                    </div>
                    <div class="p-4">
                        <input type="text" name="unit_terkait" required 
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

            </div>

            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-3">
                <button type="button" onclick="resetFormSOP()"
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
    let kebijakanCounter = 1;
    let prosedurCounter = 1;

    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.querySelector('input[name="tanggal_terbit"]');
        if (dateInput && typeof flatpickr !== 'undefined') {
            flatpickr(dateInput, {
                locale: 'id',
                dateFormat: 'Y-m-d'
            });
        }
    });

    function addKebijakanField() {
        const container = document.getElementById('kebijakanContainer');
        const index = ++kebijakanCounter;
        const wrapper = document.createElement('div');
        wrapper.className = 'kebijakan-item flex gap-3';
        wrapper.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${index}.</label>
            <div class="flex-1 flex gap-2">
                <textarea name="kebijakan[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                <button type="button" onclick="removeKebijakanField(this)" class="mt-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(wrapper);
    }

    function removeKebijakanField(button) {
        const item = button.closest('.kebijakan-item');
        const container = document.getElementById('kebijakanContainer');
        if (container.querySelectorAll('.kebijakan-item').length <= 1) return;
        item.remove();
        kebijakanCounter = Math.max(1, kebijakanCounter - 1);
        renumberItems('kebijakanContainer', 'kebijakan-item');
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
        document.getElementById('kebijakanContainer').innerHTML = `
            <div class="kebijakan-item flex gap-3">
                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">1.</label>
                <div class="flex-1">
                    <textarea name="kebijakan[]" rows="2" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                </div>
            </div>
        `;
        document.getElementById('prosedurContainer').innerHTML = `
            <div class="prosedur-item flex gap-3">
                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">1.</label>
                <div class="flex-1">
                    <textarea name="prosedur[]" rows="2" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                </div>
            </div>
        `;
        kebijakanCounter = 1;
        prosedurCounter = 1;
    }

    function submitSOPForm(event) {
        event.preventDefault();
        const form = document.getElementById('sopForm');

        const kebijakanFields = Array.from(form.querySelectorAll('textarea[name="kebijakan[]"]')).map(i => i.value.trim()).filter(Boolean);
        const prosedurFields = Array.from(form.querySelectorAll('textarea[name="prosedur[]"]')).map(i => i.value.trim()).filter(Boolean);
        if (kebijakanFields.length === 0 || prosedurFields.length === 0) {
            alert('Kebijakan dan Prosedur minimal 1 poin.');
            return;
        }

        const formData = new FormData(form);
        while (formData.has('kebijakan[]')) formData.delete('kebijakan[]');
        kebijakanFields.forEach(v => formData.append('kebijakan[]', v));
        while (formData.has('prosedur[]')) formData.delete('prosedur[]');
        prosedurFields.forEach(v => formData.append('prosedur[]', v));

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan';

        fetch(form.action, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
        .then(response => response.json().then(data => ({ status: response.status, ok: response.ok, data })).catch(() => ({ status: response.status, ok: response.ok, parseError: true })))
        .then(result => {
            if (result.parseError) { alert('Error: Response parsing failed.'); return; }
            if (!result.ok) {
                if (result.data?.errors) {
                    let errorMsg = 'Validasi Gagal:\n\n';
                    for (let [field, messages] of Object.entries(result.data.errors)) {
                        const messageText = Array.isArray(messages) ? messages.join(', ') : messages;
                        errorMsg += `❌ ${field}: ${messageText}\n`;
                    }
                    alert(errorMsg);
                } else {
                    alert('Error: ' + (result.data?.message || 'Server error: ' + result.status));
                }
                return;
            }

            if (result.data.success) {
                closeModal('modalCreateSOP');
                form.reset(); kebijakanCounter = 1; prosedurCounter = 1;
                showSuccessMessage('SOP berhasil dibuat!');
                setTimeout(() => { 
                    openPreviewPDF(result.data.file_url, result.data.nomor_surat, result.data.surat_id, result.data.judul_sop, result.data.tanggal_dibuat); 
                }, 500);
            } else { alert('Gagal membuat SOP: ' + (result.data.message || 'Kesalahan tidak diketahui')); }
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