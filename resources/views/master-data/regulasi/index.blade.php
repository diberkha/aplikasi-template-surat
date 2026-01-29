@extends('layouts.app')

@section('title', 'Regulasi')

@section('content')
    <div class="space-y-6" x-data="regulasi()" x-init="init()">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Data Regulasi</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola informasi data regulasi</p>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-4 lg:mt-0">
                <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                    <div x-data="{ toggleFilter: false }" class="relative flex-1 sm:flex-initial">
                        <button type="button" @click="toggleFilter = !toggleFilter"
                            class="w-full flex items-center justify-between sm:justify-start space-x-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-filter text-gray-600 dark:text-gray-400"></i>
                                <span class="text-gray-700 dark:text-gray-300" x-text="sortText"></span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs"></i>
                        </button>

                        <div x-show="toggleFilter" @click.away="toggleFilter = false" x-transition
                            class="absolute mt-2 left-0 w-40 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50">
                            <ul class="py-1">
                                <li><button @click="sortOption='a-z'; toggleFilter=false; filterRegulasi()"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">A-Z</button>
                                </li>
                                <li><button @click="sortOption='z-a'; toggleFilter=false; filterRegulasi()"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">Z-A</button>
                                </li>
                                <li><button @click="sortOption='latest'; toggleFilter=false; filterRegulasi()"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">Terbaru</button>
                                </li>
                                <li><button @click="sortOption='oldest'; toggleFilter=false; filterRegulasi()"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">Terlama</button>
                                </li>
                                <li class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                                    <button @click="sortOption=null; toggleFilter=false; filterRegulasi()"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400 text-sm">Hapus
                                        Filter</button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="relative flex-1 sm:w-48 lg:w-64 group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-xs"></i>
                        </div>
                        <input type="text" x-model="search" placeholder="Cari..."
                            x-on:input.debounce.300ms="filterRegulasi()"
                            class="pl-9 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white w-full text-sm transition-all outline-none">
                        <button type="button" x-show="search" @click="search = ''; filterRegulasi()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                </div>

                <button onclick="openModal('modalCreate')"
                    class="flex items-center justify-center space-x-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium whitespace-nowrap w-full sm:w-auto active:scale-95">
                    <i class="fas fa-plus"></i>
                    <span class="hidden sm:inline">Tambah Regulasi</span>
                    <span class="sm:hidden">Tambah</span>
                </button>
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden relative">
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Regulasi</h3>
                <div class="sm:hidden animate-pulse">
                    <i class="fas fa-arrows-left-right text-gray-400 text-xs"></i>
                </div>
            </div>

            @if($regulasis->count() > 0)
                <div class="overflow-x-auto custom-scrollbar-x">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Isi Regulasi</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-for="(regulasi, index) in paginatedData()" :key="regulasi.id_regulasi">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900 dark:text-white"
                                            x-text="index + 1 + ((currentPage - 1) * itemsPerPage)"></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700 dark:text-gray-300 max-w-xl">
                                            <div class="line-clamp-3" x-text="regulasi.isi_regulasi"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <button @click="editRegulasi(regulasi.id_regulasi)"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/30 transition-colors"
                                                title="Edit Regulasi">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>

                                            <button @click="openDeleteRegulasi(regulasi.id_regulasi, regulasi.isi_regulasi)"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/30 transition-colors"
                                                title="Hapus Regulasi">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </td>
                            </template>
                            <template x-if="paginatedData().length === 0">
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                            <h6 class="block mb-2 text-gray-400 dark:text-gray-500">Belum ada data
                                                regulasi</h6>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                @if($regulasis->count() > 0)
                    <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center space-x-2">
                                <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 hidden sm:inline">Items per
                                    page:</span>
                                <select x-model.number="itemsPerPage" @change="currentPage = 1; update()"
                                    class="border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1 dark:bg-gray-700 dark:text-white text-xs sm:text-sm">
                                    <option>5</option>
                                    <option>10</option>
                                    <option>15</option>
                                    <option>20</option>
                                </select>
                            </div>

                            <div class="flex items-center space-x-1 sm:space-x-2">
                                <button @click="prevPage()" :disabled="currentPage === 1"
                                    class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-chevron-left"></i>
                                </button>

                                <template x-for="(page, index) in pages()" :key="index">
                                    <button @click="page !== '...' && goToPage(page)"
                                        class="h-8 min-w-[32px] sm:h-10 sm:min-w-[40px] px-2 sm:px-3 flex items-center justify-center rounded-lg border text-xs sm:text-sm font-semibold transition-colors"
                                        :class="[
                                                                                                                                                                                    parseInt(page) === parseInt(currentPage) ? 'bg-green-600 text-white border-green-600' :
                                                                                                                                                                                    (page === '...' ? 'border-transparent text-gray-500 dark:text-gray-400 cursor-default' :
                                                                                                                                                                                    'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600'),
                                                                                                                                                                                    (typeof page === 'number' && Math.abs(page - currentPage) > 1 && page !== 1 && page !== totalPages) ? 'hidden md:flex' : 'flex'
                                                                                                                                                                                    ]"
                                        :disabled="page === '...'">
                                        <span x-text="page"></span>
                                    </button>
                                </template>

                                <button @click="nextPage()" :disabled="currentPage === totalPages"
                                    class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>

                            <div
                                class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 w-full sm:w-auto text-center sm:text-left">
                                <span x-text="startItem"></span> -
                                <span x-text="endItem"></span>
                                dari
                                <span x-text="filteredCount"></span>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                    <h6 class="block mb-2 text-gray-400 dark:text-gray-500">Belum ada data regulasi</h6>
                </div>
            @endif
        </div>

        @include('master-data.regulasi.partials.modal-create')
        @include('master-data.regulasi.partials.modal-detail')
        @include('master-data.regulasi.partials.modal-edit')
        @include('master-data.regulasi.partials.modal-delete')

        <style>
            .line-clamp-3 {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        </style>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('regulasi', () => ({
                    search: '',
                    sortOption: null,
                    itemsPerPage: 10,
                    currentPage: 1,
                    regulasis: @json($regulasis),
                    filteredCount: 0,

                    init() {
                        this.filteredCount = this.regulasis.length;
                    },

                    get totalPages() {
                        return Math.max(1, Math.ceil(this.getFilteredSortedData().length / this.itemsPerPage));
                    },

                    get sortText() {
                        switch (this.sortOption) {
                            case 'a-z': return 'A-Z';
                            case 'z-a': return 'Z-A';
                            case 'latest': return 'Terbaru';
                            case 'oldest': return 'Terlama';
                            default: return 'Urutkan';
                        }
                    },

                    pages() {
                        const total = this.totalPages;
                        const current = this.currentPage;
                        const delta = 1;
                        const range = [];
                        const rangeWithDots = [];

                        range.push(1);

                        for (let i = current - delta; i <= current + delta; i++) {
                            if (i < total && i > 1) {
                                range.push(i);
                            }
                        }

                        if (total > 1) range.push(total);

                        let l;
                        for (let i of range) {
                            if (l) {
                                if (i - l === 2) {
                                    rangeWithDots.push(l + 1);
                                } else if (i - l !== 1) {
                                    rangeWithDots.push('...');
                                }
                            }
                            rangeWithDots.push(i);
                            l = i;
                        }

                        return rangeWithDots;
                    },

                    goToPage(page) {
                        this.currentPage = page;
                    },

                    get startItem() {
                        return this.filteredCount === 0 ? 0 : (this.currentPage - 1) * this.itemsPerPage + 1;
                    },

                    get endItem() {
                        return Math.min(this.currentPage * this.itemsPerPage, this.filteredCount);
                    },

                    getFilteredSortedData() {
                        const searchTerm = this.search.toLowerCase();
                        let filtered = this.regulasis.filter(r =>
                            r.isi_regulasi.toLowerCase().includes(searchTerm)
                        );

                        if (this.sortOption === 'latest') {
                            filtered.sort((a, b) => b.id_regulasi - a.id_regulasi);
                        } else if (this.sortOption === 'oldest') {
                            filtered.sort((a, b) => a.id_regulasi - b.id_regulasi);
                        } else if (this.sortOption === 'a-z') {
                            filtered.sort((a, b) => a.isi_regulasi.localeCompare(b.isi_regulasi));
                        } else if (this.sortOption === 'z-a') {
                            filtered.sort((a, b) => b.isi_regulasi.localeCompare(a.isi_regulasi));
                        } else {
                            filtered.sort((a, b) => b.id_regulasi - a.id_regulasi);
                        }

                        this.filteredCount = filtered.length;
                        return filtered;
                    },

                    paginatedData() {
                        const data = this.getFilteredSortedData();
                        const start = (this.currentPage - 1) * this.itemsPerPage;
                        return data.slice(start, start + this.itemsPerPage);
                    },

                    filterRegulasi() {
                        this.currentPage = 1;
                    },

                    editRegulasi(id) {
                        const regulasi = this.regulasis.find(r => r.id_regulasi == id);
                        if (regulasi) {
                            document.getElementById('editIdRegulasi').value = regulasi.id_regulasi;
                            document.getElementById('editIsiRegulasiField').value = regulasi.isi_regulasi;

                            const editIsiRegulasiField = document.getElementById('editIsiRegulasiField');
                            const editIsiRegulasiCounter = document.getElementById('editIsiRegulasiCounter');
                            if (editIsiRegulasiField && editIsiRegulasiCounter) {
                                updateCounter(editIsiRegulasiField, editIsiRegulasiCounter);
                            }

                            document.getElementById('editRegulasiForm').action = `/master-data/regulasi/${regulasi.id_regulasi}`;

                            if (typeof FormDirtyMonitor !== 'undefined') {
                                new FormDirtyMonitor('editRegulasiForm', 'btnSubmitEditRegulasi');
                            }

                            openModal('modalEdit');
                        } else {
                            notify('error', 'Gagal', 'Data regulasi tidak ditemukan', false);
                        }
                    },

                    nextPage() {
                        if (this.currentPage < this.totalPages) {
                            this.currentPage++;
                        }
                    },

                    prevPage() {
                        if (this.currentPage > 1) {
                            this.currentPage--;
                        }
                    }
                }));
            });

            let currentRegulasiId = null;

            function openDeleteRegulasi(id, preview) {
                document.getElementById('delete-preview').textContent = preview;
                const form = document.getElementById('formDeleteRegulasi');
                form.action = `/master-data/regulasi/${id}`;
                openModal('modalDeleteRegulasi');
            }



            function updateCounter(textarea, counter) {
                const len = textarea.value.length;
                if (counter) {
                    counter.textContent = `${len} karakter`;
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const isiRegulasiField = document.getElementById('isiRegulasiField');
                const isiRegulasiCounter = document.getElementById('isiRegulasiCounter');

                if (isiRegulasiField && isiRegulasiCounter) {
                    updateCounter(isiRegulasiField, isiRegulasiCounter);
                    isiRegulasiField.addEventListener('input', () => updateCounter(isiRegulasiField, isiRegulasiCounter));
                }

                const editIsiRegulasiField = document.getElementById('editIsiRegulasiField');
                const editIsiRegulasiCounter = document.getElementById('editIsiRegulasiCounter');

                if (editIsiRegulasiField && editIsiRegulasiCounter) {
                    editIsiRegulasiField.addEventListener('input', function () {
                        updateCounter(this, editIsiRegulasiCounter);
                    });
                }

                document.addEventListener('keydown', function (e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                        e.preventDefault();
                        const searchInput = document.querySelector('input[placeholder="Cari..."]');
                        if (searchInput) searchInput.focus();
                    }
                });
            });
        </script>
@endsection