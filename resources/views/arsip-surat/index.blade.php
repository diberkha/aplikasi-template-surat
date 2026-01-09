@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('content')
    <div class="space-y-6" x-data="arsipSurat()">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Arsip Surat</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Total <span x-text="filteredData.length"></span> surat tersimpan dalam sistem
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3 mt-4 lg:mt-0">
                <div x-data="{ toggleSort: false }" class="relative">
                    <button type="button" @click="toggleSort = !toggleSort"
                        class="flex items-center space-x-2 px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                        <i class="fas fa-filter text-gray-600 dark:text-gray-400"></i>
                        <span class="text-gray-700 dark:text-gray-300" x-text="sortLabel"></span>
                        <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs"></i>
                    </button>

                    <div x-show="toggleSort" @click.away="toggleSort = false" x-transition
                        class="absolute mt-2 left-0 w-40 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50">
                        <ul class="py-1">
                            <li><button type="button" @click="sortOption = 'a-z'; toggleSort = false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">A-Z</button>
                            </li>
                            <li><button type="button" @click="sortOption = 'z-a'; toggleSort = false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">Z-A</button>
                            </li>
                            <li><button type="button" @click="sortOption = 'latest'; toggleSort = false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">Terbaru</button>
                            </li>
                            <li><button type="button" @click="sortOption = 'oldest'; toggleSort = false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">Terlama</button>
                            </li>
                            <li class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                                <button type="button" @click="sortOption = ''; toggleSort = false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400 text-sm">Hapus Filter</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div x-data="{ toggleFilter: false }" class="relative">
                    <button type="button" @click="toggleFilter = !toggleFilter"
                        class="flex items-center space-x-2 px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                        <i class="fas fa-copy text-gray-600 dark:text-gray-400"></i>
                        <span class="text-gray-700 dark:text-gray-300" x-text="selectedTemplateName"></span>
                        <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs"></i>
                    </button>

                    <div x-show="toggleFilter" @click.away="toggleFilter = false" x-transition
                        class="absolute mt-2 left-0 w-64 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50">
                        <ul class="py-1 max-h-64 overflow-y-auto sidebar-scrollbar">
                            @foreach($templateOptions as $template)
                                <li>
                                    <button type="button" @click="templateFilter = '{{ $template->id_template_surat }}'; toggleFilter = false"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">
                                        {{ $template->nama_template_surat }}
                                    </button>
                                </li>
                            @endforeach
                            <li class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                                <button type="button" @click="templateFilter = ''; toggleFilter = false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400 text-sm">
                                    Hapus Filter
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open"
                        class="flex items-center space-x-2 px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                        <i class="fas fa-calendar-alt text-gray-600 dark:text-gray-400"></i>
                        <span class="text-gray-700 dark:text-gray-300" x-text="dateDisplay"></span>
                        <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute mt-2 left-0 w-56 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50 p-4">
                        <div class="space-y-2">
                            <label class="block text-xs text-gray-500 dark:text-gray-400">Tanggal Mulai</label>
                            <input type="date" x-model="startDate" x-ref="startDatePicker"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm" />

                            <label class="block text-xs text-gray-500 dark:text-gray-400">Tanggal Akhir</label>
                            <input type="date" x-model="endDate" x-ref="endDatePicker"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm" />

                            <div class="flex space-x-2 pt-2">
                                <button type="button" @click="applyDateFilter(); open = false"
                                    class="flex-1 px-3 py-1.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700">Terapkan</button>
                                <button type="button" @click="clearDateFilter(); open = false"
                                    class="flex-1 px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative flex-1 sm:flex-initial">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                    <input type="text" x-model.debounce.300ms="search" placeholder="Cari arsip..."
                        class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white w-full sm:w-64 text-sm">
                </div>
            </div>
        </div>


        @if(isset($debugRecent) && $debugRecent)
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg mt-4">
                <div class="mb-2 font-medium text-yellow-800">Debug: Recent Surat (for diagnosis)</div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-gray-600">
                            <th class="pb-2">ID</th>
                            <th class="pb-2">Nama Surat</th>
                            <th class="pb-2">Nomor</th>
                            <th class="pb-2">Tanggal</th>
                            <th class="pb-2">Have SKDirektur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($debugRecent as $d)
                            <tr class="border-t">
                                <td class="py-2">{{ $d->id_surat }}</td>
                                <td class="py-2">{{ $d->nama_surat }}</td>
                                <td class="py-2">{{ $d->nomor_surat }}</td>
                                <td class="py-2">{{ optional($d->tanggal_dibuat)->format('Y-m-d') }}</td>
                                <td class="py-2">{{ $d->skDirektur ? 'yes' : 'no' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif




        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Surat</h3>
            </div>

            @if($totalSurat > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tipe Surat</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nama Surat</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nomor Surat</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tanggal Dibuat</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-for="(item, index) in paginatedData" :key="item.id_surat">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900 dark:text-white" x-text="(currentPage - 1) * itemsPerPage + index + 1"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                            :class="item.badge_color" x-text="item.tipe_surat_display">
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white" x-text="item.nama_surat_display"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white" x-text="item.nomor_surat"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white" x-text="formatDate(item.tanggal_dibuat)"></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <button type="button" @click="showDetailSurat(item.id_surat, item.nama_surat_display, item.nomor_surat, item.tipe_surat_display, item.tanggal_dibuat, item.username, item.file_path, item.docx_url)"
                                                class="inline-flex items-center p-1.5 text-purple-500 hover:text-purple-600 dark:text-purple-400 dark:hover:text-purple-300 transition-colors">
                                                <i class="fas fa-eye text-sm"></i>
                                            </button>

                                            <template x-if="item.file_path">
                                                <div x-data="{ 
                                                    openDownload: false,
                                                    toggle() {
                                                        this.openDownload = !this.openDownload;
                                                        if (this.openDownload) {
                                                            this.$nextTick(() => {
                                                                const button = this.$refs.button;
                                                                const dropdown = this.$refs.dropdown;
                                                                const rect = button.getBoundingClientRect();
                                                                dropdown.style.position = 'fixed';
                                                                dropdown.style.top = (rect.bottom + 5) + 'px';
                                                                dropdown.style.left = (rect.right - 160) + 'px'; 
                                                            });
                                                        }
                                                    }
                                                }" @scroll.window="openDownload = false" class="relative">
                                                    <button type="button" x-ref="button" @click="toggle()"
                                                        class="inline-flex items-center p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                                        <i class="fas fa-download text-sm"></i>
                                                    </button>
                                                    <template x-teleport="body">
                                                        <div x-show="openDownload" x-ref="dropdown" @click.outside="openDownload = false" x-transition
                                                            class="fixed w-40 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-1 z-[9999]">
                                                            <a :href="item.download_url" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                <i class="fas fa-file-pdf text-red-600 mr-2 w-4"></i> PDF
                                                            </a>
                                                            <template x-if="item.docx_url !== '#'">
                                                                <a :href="item.docx_url" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                    <i class="fas fa-file-word text-green-600 mr-2 w-4"></i> DOCX
                                                                </a>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="!item.file_path">
                                                <button type="button" @click="notify('error', 'Gagal', 'File surat tidak tersedia untuk diunduh', false)"
                                                    class="inline-flex items-center p-1.5 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-400 transition-colors">
                                                    <i class="fas fa-download text-sm"></i>
                                                </button>
                                            </template>

                                            @if(auth()->user()->hasRole('Admin'))
                                            <button type="button" @click="openDeleteModal(item.id_surat, item.nama_surat_display, item.nomor_surat, item.tipe_surat_display)"
                                                class="inline-flex items-center p-1.5 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template x-if="paginatedData.length === 0">
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                            <h6 class="text-base font-medium text-gray-600 dark:text-gray-400">Belum ada data surat</h6>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center space-x-2">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 hidden sm:inline">Items per page:</span>
                            <select x-model="itemsPerPage" @change="currentPage = 1"
                                class="border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1 dark:bg-gray-700 dark:text-white text-xs sm:text-sm">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                            </select>
                        </div>

                        <div class="flex items-center space-x-1 sm:space-x-2">
                            <button @click="setPage(currentPage - 1)" :disabled="currentPage <= 1"
                                class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-chevron-left"></i>
                            </button>

                            <template x-for="(p, index) in pages()" :key="index">
                                <button @click="p !== '...' && setPage(p)"
                                    x-text="p"
                                    :disabled="p === '...'"
                                    class="h-8 min-w-[32px] sm:h-10 sm:min-w-[40px] px-2 sm:px-3 flex items-center justify-center rounded-lg border text-xs sm:text-sm font-semibold transition-colors"
                                    :class="p === currentPage 
                                        ? 'bg-green-600 border-green-600 text-white shadow-sm' 
                                        : (p === '...' 
                                            ? 'border-transparent text-gray-500 dark:text-gray-400 cursor-default' 
                                            : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600')">
                                </button>
                            </template>

                            <button @click="setPage(currentPage + 1)" :disabled="currentPage >= totalPages"
                                class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 w-full sm:w-auto text-center sm:text-left">
                            <span x-text="filteredData.length === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1"></span> - 
                            <span x-text="Math.min(currentPage * itemsPerPage, filteredData.length)"></span> dari 
                            <span x-text="filteredData.length"></span>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                    <h6 class="text-base font-medium text-gray-600 dark:text-gray-400">Belum ada data surat</h6>


                    @if(request()->hasAny(['search', 'template', 'start_date', 'end_date']))
                        <a href="{{ route('arsip-surat.index') }}"
                            class="inline-flex items-center px-4 py-2 mt-4 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            Tampilkan Semua Surat
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>

    <div id="modalDeleteSurat"
        class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-green-600 dark:text-green-400">Konfirmasi Hapus Surat</h3>
                <button onclick="closeModal('modalDeleteSurat')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6">
                <p class="text-gray-600 dark:text-gray-400 mb-4">Apakah Anda yakin ingin menghapus surat ini?</p>
                <div class="mt-4 bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                    <p class="text-sm mb-2">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Nama Surat:</span>
                        <span id="delete-nama-surat" class="text-gray-800 dark:text-gray-200">-</span>
                    </p>
                    <p class="text-sm mb-2">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Nomor Surat:</span>
                        <span id="delete-nomor-surat" class="text-gray-800 dark:text-gray-200">-</span>
                    </p>
                    <p class="text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Tipe Surat:</span>
                        <span id="delete-tipe-surat" class="text-gray-800 dark:text-gray-200">-</span>
                    </p>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                <button type="button" onclick="closeModal('modalDeleteSurat')"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    Batal
                </button>
                <form id="formDeleteSurat" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Hapus Surat
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('arsip-surat.partials.modal-detail')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('arsipSurat', () => ({
                allData: @json($surat),
                templateOptions: @json($templateOptions),
                search: '',
                sortOption: '',
                templateFilter: '',
                startDate: '',
                endDate: '',
                itemsPerPage: 10,
                currentPage: 1,
                toggleSort: false,
                toggleFilter: false,
                
                get filteredData() {
                    let data = [...this.allData];

                    if (this.search) {
                        const s = this.search.toLowerCase();
                        data = data.filter(item => 
                            item.nama_surat_display.toLowerCase().includes(s) ||
                            item.nomor_surat.toLowerCase().includes(s) ||
                            item.username.toLowerCase().includes(s) ||
                            item.tipe_surat_display.toLowerCase().includes(s)
                        );
                    }

                    if (this.templateFilter) {
                        data = data.filter(item => item.id_template_surat == this.templateFilter);
                    }

                    if (this.startDate) {
                        data = data.filter(item => item.tanggal_dibuat >= this.startDate);
                    }
                    if (this.endDate) {
                        data = data.filter(item => item.tanggal_dibuat <= this.endDate);
                    }

                    if (this.sortOption === 'a-z') {
                        data.sort((a, b) => a.nama_surat_display.localeCompare(b.nama_surat_display));
                    } else if (this.sortOption === 'z-a') {
                        data.sort((a, b) => b.nama_surat_display.localeCompare(a.nama_surat_display));
                    } else if (this.sortOption === 'latest') {
                        data.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    } else if (this.sortOption === 'oldest') {
                        data.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                    }

                    return data;
                },

                get paginatedData() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredData.slice(start, start + this.itemsPerPage);
                },

                get totalPages() {
                    return Math.max(1, Math.ceil(this.filteredData.length / this.itemsPerPage));
                },

                pages() {
                     const total = this.totalPages;
                     if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);

                     const current = this.currentPage;
                     const range = [1];

                     if (current > 3) range.push('...');

                     let start = Math.max(2, current - 1);
                     let end = Math.min(total - 1, current + 1);

                     if (current <= 3) {
                         end = 4;
                     }

                     if (current >= total - 2) {
                         start = total - 3;
                     }

                     for (let i = start; i <= end; i++) {
                         range.push(i);
                     }

                     if (current < total - 2) range.push('...');

                     range.push(total);
                     
                     return range;
                },

                get sortLabel() {
                    switch (this.sortOption) {
                        case 'a-z': return 'A-Z';
                        case 'z-a': return 'Z-A';
                        case 'latest': return 'Terbaru';
                        case 'oldest': return 'Terlama';
                        default: return 'Filter';
                    }
                },

                get selectedTemplateName() {
                    if (!this.templateFilter) return 'Template';
                    const tpl = this.templateOptions.find(t => t.id_template_surat == this.templateFilter);
                    return tpl ? tpl.nama_template_surat : 'Template';
                },

                get dateDisplay() {
                    if (this.startDate && this.endDate) {
                        return `${this.formatDate(this.startDate)} - ${this.formatDate(this.endDate)}`;
                    } else if (this.startDate) {
                        return `Dari ${this.formatDate(this.startDate)}`;
                    } else if (this.endDate) {
                        return `Hingga ${this.formatDate(this.endDate)}`;
                    }
                    return 'Tanggal';
                },

                formatDate(dateStr) {
                    if (!dateStr) return '';
                    const d = new Date(dateStr);
                    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                },

                setPage(page) {
                    if (page >= 1 && page <= this.totalPages) {
                        this.currentPage = page;
                    }
                },

                applyDateFilter() {
                   this.open = false;
                   this.currentPage = 1;
                },

                clearDateFilter() {
                    this.startDate = '';
                    this.endDate = '';
                    this.currentPage = 1;
                    this.open = false;
                }
            }));

        });

        function showDetailSurat(idSurat, nama, nomor, tipe, tanggal, dibuatOleh, filePath, docxUrl) {
            const formatLongDate = (dateString) => {
                if (!dateString) return '-';
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            };

            document.getElementById('detail-nama-surat').textContent = nama;
            document.getElementById('detail-nomor-surat').textContent = nomor;
            document.getElementById('detail-tanggal-dibuat').textContent = formatLongDate(tanggal);
            const dibuatOlehEl = document.getElementById('detail-dibuat-oleh');
            if (dibuatOlehEl) {
                dibuatOlehEl.textContent = dibuatOleh;
            }

            const tipeBadge = {
                'Surat Keputusan Direktur': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                'Standar Operasional Prosedur (SOP)': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                'Surat Izin Cuti': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            }[tipe] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';

            document.getElementById('detail-tipe-surat').innerHTML =
                `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${tipeBadge}">
                ${tipe}
            </span>`;

            if (filePath && filePath !== '') {
                document.getElementById('detail-file-exists').classList.remove('hidden');
                document.getElementById('detail-no-file').classList.add('hidden');
                document.getElementById('detail-download-dropdown').classList.remove('hidden');

                const fileName = filePath.split('/').pop();
                document.getElementById('detail-file-nama').textContent = fileName;
                document.getElementById('detail-download-pdf').href = `/arsip-surat/${idSurat}/download`;
                document.getElementById('detail-pdf-preview').src = `/arsip-surat/${idSurat}`;
            } else {
                document.getElementById('detail-file-exists').classList.add('hidden');
                document.getElementById('detail-no-file').classList.remove('hidden');
                document.getElementById('detail-download-dropdown').classList.add('hidden');
            }

            const modal = document.getElementById('modalDetailSurat');
            modal.dataset.suratId = idSurat;
            modal.dataset.docxUrl = docxUrl;
            modal.classList.remove('hidden');
        }

        function downloadAsWord() {
            const modal = document.getElementById('modalDetailSurat');
            const docxUrl = modal.dataset.docxUrl;
            
            if (!docxUrl || docxUrl === '#') {
                notify('error', 'Gagal', 'File Word tidak tersedia untuk tipe surat ini.', false);
                return;
            }
            
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = docxUrl;
            form.style.display = 'none';
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function openDeleteModal(id, namaSurat, nomorSurat, tipeSurat) {
            document.getElementById('delete-nama-surat').textContent = namaSurat;
            document.getElementById('delete-nomor-surat').textContent = nomorSurat;
            document.getElementById('delete-tipe-surat').textContent = tipeSurat;
            document.getElementById('formDeleteSurat').action = `/arsip-surat/${id}`;
            document.getElementById('modalDeleteSurat').classList.remove('hidden');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                ['modalDetailSurat', 'modalDeleteSurat'].forEach(id => closeModal(id));
            }
        });
    </script>
@endsection