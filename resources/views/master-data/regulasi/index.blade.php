@extends('layouts.app')

@section('title', 'Regulasi - E-Office')

@section('content')
    <div class="space-y-6" x-data="regulasi()" x-init="init()">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Regulasi</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola informasi data regulasi</p>
            </div>

            <div class="flex flex-wrap items-center gap-3 mt-4 lg:mt-0">
                <div x-data="{ toggleFilter: false }" class="relative">
                    <button type="button" @click="toggleFilter = !toggleFilter"
                        class="flex items-center space-x-2 px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                        <i class="fas fa-filter text-gray-600 dark:text-gray-400"></i>
                        <span class="text-gray-700 dark:text-gray-300" x-text="sortText"></span>
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
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400 text-sm">Hapus Filter</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="relative flex-1 sm:flex-initial">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                    <input type="text" placeholder="Cari regulasi..." x-model="search"
                        x-on:input.debounce.300ms="filterRegulasi()"
                        class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white w-full sm:w-64 text-sm">
                </div>

                <button onclick="openModal('modalCreate')"
                    class="flex items-center space-x-2 px-3 sm:px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm whitespace-nowrap">
                    <i class="fas fa-plus"></i>
                    <span class="hidden sm:inline">Tambah Regulasi</span>
                    <span class="sm:hidden">Tambah</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <div>
                        <p class="text-green-800 dark:text-green-200 font-medium">Berhasil!</p>
                        <p class="text-green-700 dark:text-green-300 text-sm mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <div>
                        <p class="text-red-800 dark:text-red-200 font-medium">Terjadi kesalahan!</p>
                        <ul class="text-red-700 dark:text-red-300 text-sm mt-1 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Regulasi</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Isi Regulasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="(regulasi, index) in paginatedData()" :key="regulasi.id_regulasi">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900 dark:text-white" x-text="index + 1 + ((currentPage - 1) * itemsPerPage)"></span>
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
                        <tr x-show="filteredCount === 0">
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                                        <i class="fas fa-inbox text-2xl"></i>
                                    </div>
                                    <p class="text-lg font-medium text-gray-700 dark:text-gray-300">Belum ada data regulasi</p>
                                    <button @click="openModal('modalCreate')"
                                        class="mt-4 inline-flex items-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                        <i class="fas fa-plus"></i>
                                        <span>Tambah Regulasi</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($regulasis->count() > 0)
                <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center space-x-2">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 hidden sm:inline">Items per page:</span>
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
                                class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </button>

                            <template x-for="page in pages()" :key="page">
                                <button @click="page !== '...' && goToPage(page)"
                                    class="h-8 min-w-[32px] sm:h-10 sm:min-w-[40px] px-2 sm:px-3 flex items-center justify-center rounded-lg border text-xs sm:text-sm font-semibold transition-colors"
                                    :class="page === currentPage
                                        ? 'bg-green-600 text-white border-green-600 shadow-sm'
                                        : (page === '...' 
                                            ? 'border-transparent text-gray-500 dark:text-gray-400 cursor-default' 
                                            : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600')"
                                    :disabled="page === '...'">
                                    <span x-text="page"></span>
                                </button>
                            </template>

                            <button @click="nextPage()" :disabled="currentPage === totalPages"
                                class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 w-full sm:w-auto text-center sm:text-left">
                            <span x-text="startItem"></span> -
                            <span x-text="endItem"></span>
                            dari
                            <span x-text="filteredCount"></span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
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
                        default: return 'Filter';
                    }
                },
                
                pages() {
                     const total = this.totalPages;
                     if (total <= 10) return Array.from({ length: total }, (_, i) => i + 1);

                     const delta = 1; 
                     const range = [];
                     const rangeWithDots = [];
                     let l;

                     range.push(1);
                     for (let i = this.currentPage - delta; i <= this.currentPage + delta; i++) {
                         if (i < total && i > 1) {
                             range.push(i);
                         }
                     }
                     range.push(total);

                     const uniqueRange = [...new Set(range)].sort((a, b) => a - b);

                     for (let i of uniqueRange) {
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

        async function openEditModal(id) {
            try {
                const response = await fetch(`/master-data/regulasi/edit-data/${id}`);
                const result = await response.json();

                if (result.success) {
                    const regulasi = result.data.regulasi;
                    document.getElementById('editIdRegulasi').value = regulasi.id_regulasi;
                    document.getElementById('editIsiRegulasiField').value = regulasi.isi_regulasi;

                    const editIsiRegulasiField = document.getElementById('editIsiRegulasiField');
                    const editIsiRegulasiCounter = document.getElementById('editIsiRegulasiCounter');
                    if (editIsiRegulasiField && editIsiRegulasiCounter) {
                        updateCounter(editIsiRegulasiField, editIsiRegulasiCounter);
                    }

                    document.getElementById('editRegulasiForm').action = `/master-data/regulasi/${regulasi.id_regulasi}`;
                    openModal('modalEdit');
                } else {
                    throw new Error('Gagal mengambil data untuk edit');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal memuat data untuk edit');
            }
        }

        function editRegulasi(id) {
            openEditModal(id);
        }

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function getSuratByTemplate() {
            const templateId = document.getElementById('template_surat').value;
            const suratSelect = document.getElementById('surat');

            if (!templateId) {
                suratSelect.innerHTML = '<option value="">-- Pilih Template Surat terlebih dahulu --</option>';
                suratSelect.disabled = true;
                return;
            }

            suratSelect.innerHTML = '<option value="">Memuat data surat...</option>';
            suratSelect.disabled = true;

            fetch(`/master-data/regulasi/get-surat/${templateId}`)
                .then(response => response.json())
                .then(data => {
                    suratSelect.innerHTML = '<option value="">-- Pilih Surat --</option>';

                    if (data.length === 0) {
                        suratSelect.innerHTML += '<option value="" disabled>Tidak ada surat untuk template ini</option>';
                    } else {
                        data.forEach(surat => {
                            const option = document.createElement('option');
                            option.value = surat.id_surat;
                            option.textContent = surat.nama_surat;
                            suratSelect.appendChild(option);
                        });
                    }
                    suratSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    suratSelect.innerHTML = '<option value="">Error loading data</option>';
                    suratSelect.disabled = false;
                });
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
                    const searchInput = document.querySelector('input[placeholder="Cari regulasi..."]');
                    if (searchInput) searchInput.focus();
                }
            });
        });
    </script>
@endsection