<x-template-header title="Template Surat Keputusan Direktur"
    subtitle="Pilih dan gunakan template Surat Keputusan Direktur yang tersedia"
    tableTitle="Daftar Template Surat Keputusan Direktur" searchPlaceholder="Cari template..."
    :count="$templates->count()" x-init="items = {{ json_encode($templates) }}">

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        No</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Template Surat</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <template x-for="(item, idx) in paginatedData" :key="item.id_template_surat">
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900 dark:text-white"
                                x-text="idx + 1 + ((currentPage - 1) * itemsPerPage)"></span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div
                                    :class="'p-2 bg-' + item.iconBgColor + ' dark:bg-' + item.iconDarkBgColor + ' rounded-lg mr-3'">
                                    <i
                                        :class="'fas fa-' + item.icon + ' text-' + item.iconTextColor + ' dark:text-' + item.iconDarkTextColor"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white"
                                        x-text="item.nama_template_surat"></span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="item.description">
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <button
                                    @click="openSKModal('modalCreateSK', 'Surat Keputusan Direktur', item.id_template_surat)"
                                    class="inline-flex items-center p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                    title="Buat Surat">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                                @if(auth()->user()->hasRole('Admin'))
                                    <button type="button"
                                        @click="openDeleteModalSK(item.id_template_surat, item.nama_template_surat)"
                                        class="inline-flex items-center p-1.5 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                        title="Hapus Template">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                </template>
                <template x-if="paginatedData.length === 0">
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                <h6 class="block mb-2 text-gray-400 dark:text-gray-500">Belum ada data
                                    template surat</h6>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <div class="px-4 sm:px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex flex-wrap items-center justify-between gap-3"
        x-show="filteredData.length > 0">
        <div class="flex items-center space-x-2">
            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 hidden sm:inline">Items per page:</span>
            <select x-model.number="itemsPerPage" @change="currentPage = 1"
                class="border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1 dark:bg-gray-700 dark:text-white text-xs sm:text-sm">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>

        <div class="flex items-center space-x-1 sm:space-x-2">
            <button @click="prevPage()" :disabled="currentPage === 1"
                class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                <i class="fas fa-chevron-left"></i>
            </button>

            <template x-for="(p, index) in pages()" :key="index">
                <button @click="p !== '...' && goToPage(p)" x-text="p" :disabled="p === '...'"
                    class="h-8 min-w-[32px] sm:h-10 sm:min-w-[40px] px-2 sm:px-3 flex items-center justify-center rounded-lg border text-xs sm:text-sm font-semibold transition-colors"
                    :class="[
                        parseInt(p) === parseInt(currentPage) ? 'bg-green-600 border-green-600 text-white shadow-sm' : 
                        (p === '...' ? 'border-transparent text-gray-500 dark:text-gray-400 cursor-default' : 
                        'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600'),
                        (typeof p === 'number' && Math.abs(p - currentPage) > 1 && p !== 1 && p !== totalPages) ? 'hidden md:flex' : 'flex'
                    ]">
                </button>
            </template>

            <button @click="nextPage()" :disabled="currentPage === totalPages"
                class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 w-full sm:w-auto text-center sm:text-left">
            <span x-text="startItem"></span> -
            <span x-text="endItem"></span>
            dari
            <span x-text="filteredData.length"></span>
        </div>
    </div>
</x-template-header>

@include('template-surat.sk-direktur.partials.modal-create')
@include('template-surat.sk-direktur.partials.modal-delete')
@include('template-surat.sk-direktur.partials.modal-preview-pdf')

<script>
    function openSKModal(id, templateName = null, templateId = null) {
        const modal = document.getElementById(id);
        if (modal) {
            window.openModal(id);

            if (templateId) {
                document.getElementById('template_surat_sk').value = templateId;
            }

            if (templateName) {
                const titleElement = modal.querySelector('#modalTitle');
                if (titleElement) {
                    const textarea = document.createElement('textarea');
                    textarea.innerHTML = templateName;
                    const decodedName = textarea.value;
                    titleElement.textContent = 'Buat ' + decodedName;
                }
            }
        }
    }

    function openDeleteModalSK(templateId, templateName) {
        const nameField = document.getElementById('delete-sk-template-name');
        const form = document.getElementById('formDeleteSK');

        if (nameField) {
            nameField.textContent = templateName || '-';
        }

        if (form) {
            const deleteUrlTemplate = '{{ route('template-surat.sk-direktur.destroy', ['template_surat' => '__ID__']) }}';
            form.action = deleteUrlTemplate.replace('__ID__', templateId);
        }

        window.openModal('modalDeleteSK');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const menimbangSK = document.getElementById('menimbangSK');
        const mengingatSK = document.getElementById('mengingatSK');
        const counterMenimbang = document.getElementById('counterMenimbangSK');
        const counterMengingat = document.getElementById('counterMengingatSK');

        if (menimbangSK && counterMenimbang) {
            menimbangSK.addEventListener('input', function () {
                counterMenimbang.textContent = this.value.length + ' karakter';
            });
        }

        if (mengingatSK && counterMengingat) {
            mengingatSK.addEventListener('input', function () {
                counterMengingat.textContent = this.value.length + ' karakter';
            });
        }
    });
</script>