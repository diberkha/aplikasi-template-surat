<div id="modalEditSOP" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalEditSOP'); editSopContents = [];"></div>

        <div
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-4xl w-full max-h-[95vh] overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700">

            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Draft Standar Operasional Prosedur
                    (SOP)</h3>
                <button type="button" onclick="closeModal('modalEditSOP'); editSopContents = [];"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form id="editSopForm" onsubmit="submitEditSOPForm(event)" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_sop_id_surat">

                <div
                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700/30 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center space-x-2 overflow-x-auto no-scrollbar py-1" id="editSopContentTabs">

                    </div>
                    <button type="button" onclick="addEditSopContent()"
                        class="flex-shrink-0 ml-2 p-1.5 bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/60 transition-colors"
                        title="Tambah Halaman">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <div class="p-6 space-y-6 overflow-y-auto flex-1 custom-scrollbar" id="editSopContentArea">
                </div>

                <div
                    class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex justify-end space-x-3 flex-shrink-0">
                    <button type="button" onclick="resetEditSopForm()"
                        class="px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                        Reset
                    </button>
                    <button type="submit" id="submitEditSopBtn"
                        class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-normal transition-colors">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let editSopContents = [];
    let editActivePageIndex = 0;
    let editMasterRegulasi = [];
    let editMasterUnit = [];
    let currentEditSopId = null;

    function loadEditMasterData() {
        editMasterRegulasi = @json($regulasis);
        editMasterUnit = @json($units);
        if (editMasterRegulasi.data) editMasterRegulasi = editMasterRegulasi.data;
        if (editMasterUnit.data) editMasterUnit = editMasterUnit.data;
    }

    async function openEditSopModal(id) {
        try {
            currentEditSopId = id;
            await loadEditMasterData();
            const response = await fetch("{{ url('sop') }}/" + id + "/edit");
            const result = await response.json();

            if (!result.success) {
                notify('error', 'Gagal', (result.message || 'Gagal mengambil data draft'));
                return;
            }

            editSopContents = result.data.sop.contents.map(p => {
                const parts = (p.nomor_dokumen || '///').split('/');
                return {
                    id_sop_page: p.id_sop_page,
                    judul_sop: p.judul_sop,
                    nomor_dokumen: p.nomor_dokumen,
                    nomor_dok_parts: [parts[0] || '', parts[1] || '', parts[2] || '', parts[3] || ''],
                    nomor_revisi: p.nomor_revisi,
                    halaman: p.halaman,
                    tanggal_terbit: p.tanggal_terbit_formatted || (p.tanggal_terbit ? p.tanggal_terbit.substring(0, 10) : ''),
                    pengertian: p.pengertian,
                    tujuan: p.tujuan_array || [''],
                    kebijakan: (p.kebijakan_array || []).map(String),
                    prosedur: p.prosedur_array || [''],
                    unit_terkait: (p.unit_terkait_array || []).map(String)
                };
            });

            editActivePageIndex = 0;
            renderEditSopTabs();
            renderEditActivePage();
            openModal('modalEditSOP');
        } catch (error) {
            console.error('Error fetching draft data:', error);
            notify('error', 'Gagal', 'Terjadi kesalahan saat mengambil data');
        }
    }

    function createBlankEditSopContent(halaman) {
        return {
            judul_sop: '',
            nomor_dokumen: '',
            nomor_dok_parts: ['', '', '', ''],
            nomor_revisi: '',
            halaman: halaman + '/1',
            tanggal_terbit: '',
            pengertian: '',
            tujuan: [''],
            kebijakan: [],
            prosedur: [''],
            unit_terkait: []
        };
    }

    function addEditSopContent() {
        saveEditActivePageData();
        const newPageNum = editSopContents.length + 1;
        editSopContents.push(createBlankEditSopContent(newPageNum));
        updateEditHalamanCounts();
        editActivePageIndex = editSopContents.length - 1;
        renderEditSopTabs();
        renderEditActivePage();
    }

    function removeEditSopContent(index) {
        if (editSopContents.length <= 1) return;
        editSopContents.splice(index, 1);
        updateEditHalamanCounts();
        editActivePageIndex = Math.min(editActivePageIndex, editSopContents.length - 1);
        renderEditSopTabs();
        renderEditActivePage();
    }

    function updateEditHalamanCounts() {
        const total = editSopContents.length;
        editSopContents.forEach((p, i) => {
            p.halaman = (i + 1) + '/' + total;
        });
    }

    function switchEditSopContent(index) {
        saveEditActivePageData();
        editActivePageIndex = index;
        renderEditSopTabs();
        renderEditActivePage();
    }

    function renderEditSopTabs() {
        const container = document.getElementById('editSopContentTabs');
        container.innerHTML = '';
        editSopContents.forEach((page, i) => {
            const activeClass = i === editActivePageIndex
                ? 'bg-green-600 text-white'
                : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700';

            const tab = document.createElement('div');
            tab.className = `flex items-center space-x-1 px-3 py-1.5 rounded-lg text-sm font-medium cursor-pointer transition-all ${activeClass}`;
            tab.onclick = () => switchEditSopContent(i);
            tab.innerHTML = `
                <span>Halaman ${i + 1}</span>
                ${editSopContents.length > 1 ? `<i class="fas fa-times ml-1.5 opacity-60 hover:opacity-100" onclick="event.stopPropagation(); removeEditSopContent(${i})"></i>` : ''}
            `;
            container.appendChild(tab);
        });
    }

    function saveEditActivePageData() {
        const content = document.getElementById('editSopContentArea');
        if (!content || editSopContents.length === 0) return;

        const page = editSopContents[editActivePageIndex];
        page.judul_sop = content.querySelector('[name="judul_sop"]')?.value || '';
        page.nomor_revisi = content.querySelector('[name="nomor_revisi"]')?.value || '';
        page.halaman = content.querySelector('[name="halaman"]')?.value || '';
        page.tanggal_terbit = content.querySelector('[name="tanggal_terbit"]')?.value || '';
        page.pengertian = content.querySelector('[name="pengertian"]')?.value || '';

        page.nomor_dok_parts = [
            content.querySelector('#edit_nomor_dok_part1')?.value || '',
            content.querySelector('#edit_nomor_dok_part2')?.value || '',
            content.querySelector('#edit_nomor_dok_part3')?.value || '',
            content.querySelector('#edit_nomor_dok_part4')?.value || ''
        ];
        page.nomor_dokumen = page.nomor_dok_parts.join('/');

        page.tujuan = Array.from(content.querySelectorAll('[name="tujuan[]"]')).map(el => el.value);
        page.prosedur = Array.from(content.querySelectorAll('[name="prosedur[]"]')).map(el => el.value);

        page.kebijakan = Array.from(content.querySelectorAll('input[name="kebijakan[]"]:checked')).map(el => el.value);
        page.unit_terkait = Array.from(content.querySelectorAll('input[name="unit_terkait[]"]:checked')).map(el => el.value);
    }

    function renderEditActivePage() {
        const container = document.getElementById('editSopContentArea');
        const page = editSopContents[editActivePageIndex];

        container.innerHTML = `
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Judul SOP <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_sop" value="${page.judul_sop}" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">No. Dokumen <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-2 w-full">
                            <input type="text" id="edit_nomor_dok_part1" value="${page.nomor_dok_parts[0]}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                            <span class="text-gray-500">/</span>
                            <input type="text" id="edit_nomor_dok_part2" value="${page.nomor_dok_parts[1]}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                            <span class="text-gray-500">/</span>
                            <input type="text" id="edit_nomor_dok_part3" value="${page.nomor_dok_parts[2]}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                            <span class="text-gray-500">/</span>
                            <input type="text" id="edit_nomor_dok_part4" value="${page.nomor_dok_parts[3]}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">No. Revisi</label>
                            <input type="text" name="nomor_revisi" value="${page.nomor_revisi || ''}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">Halaman</label>
                            <input type="text" name="halaman" value="${page.halaman}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Terbit <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_terbit" value="${page.tanggal_terbit}" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
            </div>

            <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                    <h4 class="font-bold text-gray-900 dark:text-white uppercase">Pengertian <span class="text-red-500">*</span></h4>
                </div>
                <div class="p-4">
                    <textarea name="pengertian" rows="3" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y">${page.pengertian}</textarea>
                </div>
            </div>

            <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                    <h4 class="font-bold text-gray-900 dark:text-white uppercase">Tujuan <span class="text-red-500">*</span></h4>
                </div>
                <div class="p-4">
                    <div id="editTujuanContainer" class="space-y-3">
                        ${page.tujuan.map((t, i) => `
                            <div class="tujuan-item flex gap-3">
                                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${i + 1}.</label>
                                <div class="flex-1 flex gap-2">
                                    <textarea name="tujuan[]" rows="2" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y">${t}</textarea>
                                    ${page.tujuan.length > 1 ? '<button type="button" onclick="removeEditTujuanField(this)" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg"><i class="fas fa-trash"></i></button>' : ''}
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    <button type="button" onclick="addEditTujuanField()" class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-plus mr-2"></i> Tambah Tujuan
                    </button>
                </div>
            </div>

            <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                    <h4 class="font-bold text-gray-900 dark:text-white uppercase">Kebijakan <span class="text-red-500">*</span></h4>
                </div>
                <div class="p-4">
                    <div class="mb-3 relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-xs"></i>
                        </div>
                        <input type="text" placeholder="Cari regulasi..." 
                            onkeyup="filterEditListItems(this, '#editKebijakanList')" 
                            class="w-full pl-9 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition-all">
                        <button type="button" onclick="clearEditSearchInput(this, '#editKebijakanList')" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hidden group-focus-within:flex">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div id="editKebijakanList" class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 max-h-64 overflow-y-auto bg-white dark:bg-gray-800 custom-scrollbar">
                        ${editMasterRegulasi.map((r, i) => `
                            <div class="option-row flex items-start mb-2 pb-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors px-1 rounded">
                                <input type="checkbox" name="kebijakan[]" value="${r.id_regulasi}" id="edit_kebijakan_${i}" 
                                    ${page.kebijakan.includes(String(r.id_regulasi)) ? 'checked' : ''} 
                                    class="mt-1 h-4 w-4 text-green-600 border-green-600 focus:ring-green-500 rounded cursor-pointer">
                                <label for="edit_kebijakan_${i}" class="ml-3 flex-1 cursor-pointer">
                                    <span class="text-sm text-gray-700 dark:text-gray-300 font-medium block leading-relaxed">${r.isi_regulasi}</span>
                                </label>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>

            <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                    <h4 class="font-bold text-gray-900 dark:text-white uppercase">Prosedur <span class="text-red-500">*</span></h4>
                </div>
                <div class="p-4">
                    <div id="editProsedurContainer" class="space-y-3">
                        ${page.prosedur.map((p, i) => `
                            <div class="prosedur-item flex gap-3">
                                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${i + 1}.</label>
                                <div class="flex-1 flex gap-2">
                                    <textarea name="prosedur[]" rows="2" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y">${p}</textarea>
                                    ${page.prosedur.length > 1 ? '<button type="button" onclick="removeEditProsedurField(this)" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg"><i class="fas fa-trash"></i></button>' : ''}
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    <button type="button" onclick="addEditProsedurField()" class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-plus mr-2"></i> Tambah Prosedur
                    </button>
                </div>
            </div>

            <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-300 dark:border-gray-600">
                    <h4 class="font-bold text-gray-900 dark:text-white uppercase">Unit Terkait <span class="text-red-500">*</span></h4>
                </div>
                <div class="p-4">
                    <div class="mb-3 relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-xs"></i>
                        </div>
                        <input type="text" placeholder="Cari unit..." 
                            onkeyup="filterEditListItems(this, '#editUnitList')" 
                            class="w-full pl-9 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition-all">
                        <button type="button" onclick="clearEditSearchInput(this, '#editUnitList')" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hidden group-focus-within:flex">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div id="editUnitList" class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 max-h-64 overflow-y-auto bg-white dark:bg-gray-800 custom-scrollbar">
                        ${editMasterUnit.map((u, i) => `
                            <div class="option-row flex items-start mb-2 pb-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors px-1 rounded">
                                <input type="checkbox" name="unit_terkait[]" value="${u.id_unit}" id="edit_unit_${i}" 
                                    ${page.unit_terkait.includes(String(u.id_unit)) ? 'checked' : ''} 
                                    class="mt-1 h-4 w-4 text-green-600 border-green-600 focus:ring-green-500 rounded cursor-pointer">
                                <label for="edit_unit_${i}" class="ml-3 flex-1 cursor-pointer">
                                    <span class="text-sm text-gray-700 dark:text-gray-300 font-medium block leading-relaxed">${u.nama_unit}</span>
                                </label>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        `;

        const dateInput = container.querySelector('[name="tanggal_terbit"]');
        if (dateInput && typeof flatpickr !== 'undefined') {
            flatpickr(dateInput, { locale: 'id', dateFormat: 'Y-m-d' });
        }
    }

    function addEditTujuanField() {
        const container = document.getElementById('editTujuanContainer');
        const count = container.querySelectorAll('.tujuan-item').length;
        if (count >= 15) return notify('warning', 'Peringatan', 'Maksimal 15 poin.');

        const div = document.createElement('div');
        div.className = 'tujuan-item flex gap-3';
        div.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${count + 1}.</label>
            <div class="flex-1 flex gap-2">
                <textarea name="tujuan[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                <button type="button" onclick="removeEditTujuanField(this)" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg"><i class="fas fa-trash"></i></button>
            </div>
        `;
        container.appendChild(div);
        renumberEditFields('#editTujuanContainer .tujuan-item');
    }

    function removeEditTujuanField(btn) {
        btn.closest('.tujuan-item').remove();
        renumberEditFields('#editTujuanContainer .tujuan-item');
    }

    function addEditProsedurField() {
        const container = document.getElementById('editProsedurContainer');
        const count = container.querySelectorAll('.prosedur-item').length;
        if (count >= 15) return notify('warning', 'Peringatan', 'Maksimal 15 poin.');

        const div = document.createElement('div');
        div.className = 'prosedur-item flex gap-3';
        div.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${count + 1}.</label>
            <div class="flex-1 flex gap-2">
                <textarea name="prosedur[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                <button type="button" onclick="removeEditProsedurField(this)" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg"><i class="fas fa-trash"></i></button>
            </div>
        `;
        container.appendChild(div);
        renumberEditFields('#editProsedurContainer .prosedur-item');
    }

    function removeEditProsedurField(btn) {
        btn.closest('.prosedur-item').remove();
        renumberEditFields('#editProsedurContainer .prosedur-item');
    }

    function renumberEditFields(selector) {
        document.querySelectorAll(selector).forEach((el, i) => {
            el.querySelector('label').textContent = (i + 1) + '.';
        });
    }

    function filterEditListItems(input, listSelector) {
        const val = input.value.toLowerCase();
        const container = document.querySelector(listSelector);
        const clearBtn = input.nextElementSibling;

        if (clearBtn && clearBtn.tagName === 'BUTTON') {
            clearBtn.classList.toggle('hidden', val === '');
        }

        container.querySelectorAll('.option-row').forEach(el => {
            const text = el.querySelector('label').textContent.toLowerCase();
            el.style.display = text.includes(val) ? 'flex' : 'none';
        });
    }

    function clearEditSearchInput(btn, listSelector) {
        const input = btn.previousElementSibling;
        input.value = '';
        filterEditListItems(input, listSelector);
        input.focus();
    }

    async function submitEditSOPForm(event) {
        event.preventDefault();
        saveEditActivePageData();

        for (let i = 0; i < editSopContents.length; i++) {
            const p = editSopContents[i];
            if (!p.judul_sop || !p.nomor_dokumen || !p.pengertian) {
                switchEditSopContent(i);
                return notify('error', 'Validasi Gagal', `Halaman ${i + 1} belum lengkap.`);
            }
            if (p.kebijakan.length === 0 || p.unit_terkait.length === 0) {
                switchEditSopContent(i);
                return notify('error', 'Validasi Gagal', `Halaman ${i + 1}: Minimal 1 Kebijakan dan 1 Unit.`);
            }
        }

        const form = document.getElementById('editSopForm');
        const submitBtn = document.getElementById('submitEditSopBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui';

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');

        formData.append('judul_sop', editSopContents[0].judul_sop);
        formData.append('nomor_dokumen', editSopContents[0].nomor_dokumen);
        formData.append('tanggal_terbit', editSopContents[0].tanggal_terbit);
        formData.append('pengertian', editSopContents[0].pengertian);

        editSopContents[0].tujuan.forEach((v, i) => formData.append(`tujuan[${i}]`, v));
        editSopContents[0].kebijakan.forEach((v, i) => formData.append(`kebijakan[${i}]`, v));
        editSopContents[0].prosedur.forEach((v, i) => formData.append(`prosedur[${i}]`, v));
        editSopContents[0].unit_terkait.forEach((v, i) => formData.append(`unit_terkait[${i}]`, v));

        editSopContents.forEach((p, i) => {
            formData.append(`contents[${i}][judul_sop]`, p.judul_sop);
            formData.append(`contents[${i}][nomor_dokumen]`, p.nomor_dokumen);
            formData.append(`contents[${i}][nomor_revisi]`, p.nomor_revisi);
            formData.append(`contents[${i}][halaman]`, p.halaman);
            formData.append(`contents[${i}][tanggal_terbit]`, p.tanggal_terbit);
            formData.append(`contents[${i}][pengertian]`, p.pengertian);

            p.tujuan.forEach((v, j) => formData.append(`contents[${i}][tujuan][${j}]`, v));
            p.prosedur.forEach((v, j) => formData.append(`contents[${i}][prosedur][${j}]`, v));
            p.kebijakan.forEach((v, j) => formData.append(`contents[${i}][kebijakan][${j}]`, v));
            p.unit_terkait.forEach((v, j) => formData.append(`contents[${i}][unit_terkait][${j}]`, v));
        });

        try {
            const response = await fetch("{{ url('sop') }}/" + currentEditSopId, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                closeModal('modalEditSOP');
                notify('success', 'Berhasil', result.message);

                window.dispatchEvent(new CustomEvent('update-sop-draft', { detail: result.data }));

                setTimeout(() => {
                    window.openDraftPreview(result.data, true);
                }, 500);
            } else {
                notify('error', 'Gagal', result.message || 'Terjadi kesalahan');
            }
        } catch (error) {
            console.error('Fetch error:', error);
            notify('error', 'Gagal', 'Terjadi kesalahan sistem');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Perbarui';
        }
    }

    function resetEditSopForm() {
        openEditSopModal(currentEditSopId);
    }
</script>