<div id="modalCreateSOP" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalCreateSOP'); resetFormSOP();"></div>

        <div
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-4xl w-full max-h-[95vh] overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700">

            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Buat Standar Operasional Prosedur (SOP)
                </h3>
                <button type="button" onclick="closeModal('modalCreateSOP'); resetFormSOP();"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form action="{{ route('template-surat.sop.store') }}" method="POST" id="sopForm"
                onsubmit="submitSOPForm(event)" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <input type="hidden" name="template_id" id="template_surat_sop">

                <div
                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700/30 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center space-x-2 overflow-x-auto no-scrollbar py-1" id="sopContentTabs">
                    </div>
                    <button type="button" onclick="addNewSopContent()"
                        class="flex-shrink-0 ml-2 p-1.5 bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/60 transition-colors"
                        title="Tambah Halaman">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <div class="p-6 space-y-6 overflow-y-auto flex-1 custom-scrollbar" id="sopContentArea">
                    <div class="flex flex-col items-center justify-center py-12 text-gray-500">
                        <i class="fas fa-spinner fa-spin text-3xl mb-4"></i>
                        <p>Memuat data...</p>
                    </div>
                </div>

                <div
                    class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex justify-end space-x-3 flex-shrink-0">
                    <button type="button" onclick="resetFormSOP()"
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
    let sopContents = [];
    let activePageIndex = 0;
    let masterRegulasi = [];
    let masterUnit = [];

    document.addEventListener('DOMContentLoaded', async function () {
        await Promise.all([loadRegulasiOptions(), loadUnitOptions()]);
        initDefaultSopContent();
    });

    async function loadRegulasiOptions() {
        masterRegulasi = @json($regulasis);
    }

    async function loadUnitOptions() {
        masterUnit = @json($units);
    }

    function initDefaultSopContent() {
        sopContents = [createBlankSopContent(1)];
        renderSopTabs();
        renderActivePage();
    }

    function createBlankSopContent(halaman) {
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

    function addNewSopContent() {
        saveActivePageData();
        const newPageNum = sopContents.length + 1;
        sopContents.push(createBlankSopContent(newPageNum));
        updateHalamanCounts();
        activePageIndex = sopContents.length - 1;
        renderSopTabs();
        renderActivePage();
    }

    function removeSopContent(index) {
        if (sopContents.length <= 1) return;
        sopContents.splice(index, 1);
        updateHalamanCounts();
        activePageIndex = Math.min(activePageIndex, sopContents.length - 1);
        renderSopTabs();
        renderActivePage();
    }

    function updateHalamanCounts() {
        const total = sopContents.length;
        sopContents.forEach((p, i) => {
            p.halaman = (i + 1) + '/' + total;
        });
    }

    function switchSopContent(index) {
        saveActivePageData();
        activePageIndex = index;
        renderSopTabs();
        renderActivePage();
    }

    function renderSopTabs() {
        const container = document.getElementById('sopContentTabs');
        container.innerHTML = '';
        sopContents.forEach((page, i) => {
            const activeClass = i === activePageIndex
                ? 'bg-green-600 text-white'
                : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700';

            const tab = document.createElement('div');
            tab.className = `flex items-center space-x-1 px-3 py-1.5 rounded-lg text-sm font-medium cursor-pointer transition-all ${activeClass}`;
            tab.onclick = () => switchSopContent(i);
            tab.innerHTML = `
                <span>Halaman ${i + 1}</span>
                ${sopContents.length > 1 ? `<i class="fas fa-times ml-1.5 opacity-60 hover:opacity-100" onclick="event.stopPropagation(); removeSopContent(${i})"></i>` : ''}
            `;
            container.appendChild(tab);
        });
    }

    function saveActivePageData() {
        const content = document.getElementById('sopContentArea');
        if (!content || sopContents.length === 0) return;

        const page = sopContents[activePageIndex];
        page.judul_sop = content.querySelector('[name="judul_sop"]')?.value || '';
        page.nomor_revisi = content.querySelector('[name="nomor_revisi"]')?.value || '';
        page.halaman = content.querySelector('[name="halaman"]')?.value || '';
        page.tanggal_terbit = content.querySelector('[name="tanggal_terbit"]')?.value || '';
        page.pengertian = content.querySelector('[name="pengertian"]')?.value || '';

        page.nomor_dok_parts = [
            content.querySelector('#nomor_dok_part1')?.value || '',
            content.querySelector('#nomor_dok_part2')?.value || '',
            content.querySelector('#nomor_dok_part3')?.value || '',
            content.querySelector('#nomor_dok_part4')?.value || ''
        ];
        page.nomor_dokumen = page.nomor_dok_parts.join('/');

        page.tujuan = Array.from(content.querySelectorAll('[name="tujuan[]"]')).map(el => el.value);
        page.prosedur = Array.from(content.querySelectorAll('[name="prosedur[]"]')).map(el => el.value);

        page.kebijakan = Array.from(content.querySelectorAll('input[name="kebijakan[]"]:checked')).map(el => el.value);
        page.unit_terkait = Array.from(content.querySelectorAll('input[name="unit_terkait[]"]:checked')).map(el => el.value);
    }

    function renderActivePage() {
        const container = document.getElementById('sopContentArea');
        const page = sopContents[activePageIndex];

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
                            <input type="text" id="nomor_dok_part1" value="${page.nomor_dok_parts[0]}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                            <span class="text-gray-500">/</span>
                            <input type="text" id="nomor_dok_part2" value="${page.nomor_dok_parts[1]}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                            <span class="text-gray-500">/</span>
                            <input type="text" id="nomor_dok_part3" value="${page.nomor_dok_parts[2]}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                            <span class="text-gray-500">/</span>
                            <input type="text" id="nomor_dok_part4" value="${page.nomor_dok_parts[3]}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-gray-700 dark:text-gray-300">No. Revisi</label>
                            <input type="text" name="nomor_revisi" value="${page.nomor_revisi}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
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
                    <div id="tujuanContainer" class="space-y-3">
                        ${page.tujuan.map((t, i) => `
                            <div class="tujuan-item flex gap-3">
                                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${i + 1}.</label>
                                <div class="flex-1 flex gap-2">
                                    <textarea name="tujuan[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y">${t}</textarea>
                                    ${page.tujuan.length > 1 ? '<button type="button" onclick="removeTujuanField(this)" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg"><i class="fas fa-trash"></i></button>' : ''}
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    <button type="button" onclick="addTujuanField()" class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-colors">
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
                            onkeyup="filterListItems(this, '#kebijakanList')" 
                            class="w-full pl-9 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition-all">
                        <button type="button" onclick="clearSearchInput(this, '#kebijakanList')" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hidden group-focus-within:flex">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div id="kebijakanList" class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 max-h-64 overflow-y-auto bg-white dark:bg-gray-800 custom-scrollbar">
                        ${masterRegulasi.map((r, i) => `
                            <div class="option-row flex items-start mb-2 pb-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors px-1 rounded">
                                <input type="checkbox" name="kebijakan[]" value="${r.id_regulasi}" id="kebijakan_${i}" 
                                    ${page.kebijakan.includes(String(r.id_regulasi)) ? 'checked' : ''} 
                                    class="mt-1 h-4 w-4 text-green-600 border-green-600 focus:ring-green-500 rounded cursor-pointer">
                                <label for="kebijakan_${i}" class="ml-3 flex-1 cursor-pointer">
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
                    <div id="prosedurContainer" class="space-y-3">
                        ${page.prosedur.map((p, i) => `
                            <div class="prosedur-item flex gap-3">
                                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${i + 1}.</label>
                                <div class="flex-1 flex gap-2">
                                    <textarea name="prosedur[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y">${p}</textarea>
                                    ${page.prosedur.length > 1 ? '<button type="button" onclick="removeProsedurField(this)" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg"><i class="fas fa-trash"></i></button>' : ''}
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    <button type="button" onclick="addProsedurField()" class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-colors">
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
                            onkeyup="filterListItems(this, '#unitList')" 
                            class="w-full pl-9 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition-all">
                        <button type="button" onclick="clearSearchInput(this, '#unitList')" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hidden group-focus-within:flex">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div id="unitList" class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 max-h-64 overflow-y-auto bg-white dark:bg-gray-800 custom-scrollbar">
                        ${masterUnit.map((u, i) => `
                            <div class="option-row flex items-start mb-2 pb-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors px-1 rounded">
                                <input type="checkbox" name="unit_terkait[]" value="${u.id_unit}" id="unit_${i}" 
                                    ${page.unit_terkait.includes(String(u.id_unit)) ? 'checked' : ''} 
                                    class="mt-1 h-4 w-4 text-green-600 border-green-600 focus:ring-green-500 rounded cursor-pointer">
                                <label for="unit_${i}" class="ml-3 flex-1 cursor-pointer">
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

    function addTujuanField() {
        const container = document.getElementById('tujuanContainer');
        const count = container.querySelectorAll('.tujuan-item').length;
        if (count >= 15) return notify('warning', 'Peringatan', 'Maksimal 15 poin.');

        const div = document.createElement('div');
        div.className = 'tujuan-item flex gap-3';
        div.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${count + 1}.</label>
            <div class="flex-1 flex gap-2">
                <textarea name="tujuan[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                <button type="button" onclick="removeTujuanField(this)" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg"><i class="fas fa-trash"></i></button>
            </div>
        `;
        container.appendChild(div);
        renumberFields('#tujuanContainer .tujuan-item');
    }

    function removeTujuanField(btn) {
        btn.closest('.tujuan-item').remove();
        renumberFields('#tujuanContainer .tujuan-item');
    }

    function addProsedurField() {
        const container = document.getElementById('prosedurContainer');
        const count = container.querySelectorAll('.prosedur-item').length;
        if (count >= 15) return notify('warning', 'Peringatan', 'Maksimal 15 poin.');

        const div = document.createElement('div');
        div.className = 'prosedur-item flex gap-3';
        div.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-8 flex-shrink-0">${count + 1}.</label>
            <div class="flex-1 flex gap-2">
                <textarea name="prosedur[]" rows="2" required class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                <button type="button" onclick="removeProsedurField(this)" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg"><i class="fas fa-trash"></i></button>
            </div>
        `;
        container.appendChild(div);
        renumberFields('#prosedurContainer .prosedur-item');
    }

    function removeProsedurField(btn) {
        btn.closest('.prosedur-item').remove();
        renumberFields('#prosedurContainer .prosedur-item');
    }

    function renumberFields(selector) {
        document.querySelectorAll(selector).forEach((el, i) => {
            el.querySelector('label').textContent = (i + 1) + '.';
        });
    }

    function filterListItems(input, listSelector) {
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

    function clearSearchInput(btn, listSelector) {
        const input = btn.previousElementSibling;
        input.value = '';
        filterListItems(input, listSelector);
        input.focus();
    }

    function submitSOPForm(event) {
        event.preventDefault();
        saveActivePageData();



        const form = document.getElementById('sopForm');
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan';


        const processedContents = JSON.parse(JSON.stringify(sopContents));

        for (let i = 0; i < processedContents.length; i++) {
            const p = processedContents[i];

            if (!p.judul_sop || !p.nomor_dokumen || !p.tanggal_terbit || !p.pengertian) {
                switchSopContent(i);
                notify('error', 'Validasi Gagal', `Data Halaman ${i + 1} tidak lengkap (Judul, Nomor, Tanggal, Pengertian harus diisi)`);
                return;
            }

            p.tujuan = p.tujuan.filter(i => i && i.trim() !== '');
            p.kebijakan = p.kebijakan.filter(i => i && i.trim() !== '');
            p.prosedur = p.prosedur.filter(i => i && i.trim() !== '');
            p.unit_terkait = p.unit_terkait.filter(i => i && i.trim() !== '');

            const missing = [];
            if (p.tujuan.length === 0) missing.push('Tujuan');
            if (p.kebijakan.length === 0) missing.push('Kebijakan');
            if (p.prosedur.length === 0) missing.push('Prosedur');
            if (p.unit_terkait.length === 0) missing.push('Unit Terkait');

            if (missing.length > 0) {
                switchSopContent(i);
                notify('error', 'Validasi Gagal', `Halaman ${i + 1}: ${missing.join(', ')} wajib diisi minimal 1 item.`);
                return;
            }
        }

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('template_id', document.getElementById('template_surat_sop').value);

        formData.append('judul_sop', processedContents[0].judul_sop);
        formData.append('nomor_dokumen', processedContents[0].nomor_dokumen);
        formData.append('tanggal_terbit', processedContents[0].tanggal_terbit);
        formData.append('pengertian', processedContents[0].pengertian);

        processedContents[0].tujuan.forEach((v, i) => formData.append(`tujuan[${i}]`, v));
        processedContents[0].kebijakan.forEach((v, i) => formData.append(`kebijakan[${i}]`, v));
        processedContents[0].prosedur.forEach((v, i) => formData.append(`prosedur[${i}]`, v));
        processedContents[0].unit_terkait.forEach((v, i) => formData.append(`unit_terkait[${i}]`, v));

        processedContents.forEach((p, i) => {
            formData.append(`contents[${i}][judul_sop]`, p.judul_sop);
            formData.append(`contents[${i}][nomor_dokumen]`, p.nomor_dokumen);
            formData.append(`contents[${i}][nomor_revisi]`, p.nomor_revisi || '');
            formData.append(`contents[${i}][halaman]`, p.halaman || '');
            formData.append(`contents[${i}][tanggal_terbit]`, p.tanggal_terbit);
            formData.append(`contents[${i}][pengertian]`, p.pengertian);

            p.tujuan.forEach((v, j) => formData.append(`contents[${i}][tujuan][${j}]`, v));
            p.prosedur.forEach((v, j) => formData.append(`contents[${i}][prosedur][${j}]`, v));
            p.kebijakan.forEach((v, j) => formData.append(`contents[${i}][kebijakan][${j}]`, v));
            p.unit_terkait.forEach((v, j) => formData.append(`contents[${i}][unit_terkait][${j}]`, v));
        });

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    closeModal('modalCreateSOP');
                    sopContents = [createBlankSopContent(1)];
                    activePageIndex = 0;
                    renderSopTabs();
                    renderActivePage();
                    notify('success', 'Berhasil', result.message);

                    setTimeout(() => {
                        openPreviewPDF(result.file_url, result.nomor_surat, result.surat_id, result.judul_sop, result.tanggal_terbit, false);
                    }, 500);
                } else {
                    let msg = result.message || 'Terjadi kesalahan';
                    if (result.errors) {
                        const errDetails = Object.values(result.errors).flat().join('\n');
                        msg += '\n' + errDetails;
                    }
                    notify('error', 'Gagal', msg);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                notify('error', 'Gagal', 'Terjadi kesalahan sistem');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Simpan';
            });
    }

    function resetFormSOP() {
        sopContents = [createBlankSopContent(1)];
        activePageIndex = 0;
        renderSopTabs();
        renderActivePage();
    }
</script>