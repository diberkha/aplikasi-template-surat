@extends('layouts.app')

@section('title', 'Data Jabatan')

@section('content')
    <div x-data="jabatanTable()" class="space-y-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Data Jabatan</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola informasi data jabatan</p>
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
                            <li><button @click="sortOption='a-z'; toggleFilter=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">A-Z</button>
                            </li>
                            <li><button @click="sortOption='z-a'; toggleFilter=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">Z-A</button>
                            </li>
                            <li><button @click="sortOption='latest'; toggleFilter=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">Terbaru</button>
                            </li>
                            <li><button @click="sortOption='oldest'; toggleFilter=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">Terlama</button>
                            </li>
                            <li class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                                <button @click="sortOption=null; toggleFilter=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400 text-sm">Hapus Filter</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="relative flex-1 sm:flex-initial">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                    <input type="text" x-model="search" placeholder="Cari jabatan..."
                        class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white w-full sm:w-64 text-sm">
                </div>

                <button @click="openCreateModal()"
                    class="flex items-center space-x-2 px-3 sm:px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm whitespace-nowrap">
                    <i class="fas fa-plus"></i>
                    <span class="hidden sm:inline">Tambah Jabatan</span>
                    <span class="sm:hidden">Tambah</span>
                </button>
            </div>
        </div>


        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Jabatan</h3>
            </div>

            @if($jabatans->count() > 0)
                <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                No</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nama Jabatan</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="(item, index) in paginatedData()" :key="item.id">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap"
                                    x-text="index + 1 + ((currentPage - 1) * itemsPerPage)"></td>
                                <td class="px-6 py-4" x-text="item.nama_jabatan"></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <button @click="openEditModal(item.id, item.nama_jabatan)"
                                            class="inline-flex items-center p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <button @click="openDeleteModal(item.id, item.nama_jabatan)"
                                            class="inline-flex items-center p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-if="paginatedData().length === 0">
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                        <h6 class="text-base font-medium text-gray-600 dark:text-gray-400">Belum ada data jabatan</h6>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div
                class="px-4 sm:px-6 py-4 bg-gray-50 dark:bg-gray-800 flex flex-wrap items-center justify-between gap-3 border-t border-gray-200 dark:border-gray-700">

                <div class="flex items-center space-x-2">
                    <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 hidden sm:inline">Items per page:</span>
                    <select x-model.number="itemsPerPage" @change="currentPage = 1"
                        class="border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1 dark:bg-gray-700 dark:text-white text-xs sm:text-sm">
                        <option>5</option>
                        <option>10</option>
                        <option>15</option>
                        <option>20</option>
                    </select>
                </div>

                <div class="flex items-center space-x-1 sm:space-x-2">
                    <button @click="prevPage()" :disabled="currentPage === 1"
                        class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <template x-for="(page, index) in pages()" :key="index">
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

                    <button @click="nextPage()" :disabled="currentPage === totalPages || totalPages === 0"
                        class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 w-full sm:w-auto text-center sm:text-left">
                    <span x-text="startItem"></span> -
                    <span x-text="endItem"></span>
                    dari
                    <span x-text="filteredSortedData().length"></span>
                </div>

            </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                    <h6 class="text-base font-medium text-gray-600 dark:text-gray-400">Belum ada data jabatan</h6>
                </div>
            @endif

        @include('master-data.jabatan.partials.modal-create')
        @include('master-data.jabatan.partials.modal-edit')
        @include('master-data.jabatan.partials.modal-delete')

    </div>

    <script>
        function jabatanTable() {
            return {
                search: '',
                sortOption: null,
                data: @json($jabatans),

                itemsPerPage: 10,
                currentPage: 1,

                get totalItems() {
                    return this.filteredSortedData().length;
                },

                get totalPages() {
                    return Math.ceil(this.totalItems / this.itemsPerPage) || 1;
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

                goToPage(page) {
                    this.currentPage = page;
                },

                get startItem() {
                    return this.totalItems === 0 ? 0 : ((this.currentPage - 1) * this.itemsPerPage + 1);
                },

                get endItem() {
                    return Math.min(this.currentPage * this.itemsPerPage, this.totalItems);
                },

                paginatedData() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = this.currentPage * this.itemsPerPage;
                    return this.filteredSortedData().slice(start, end);
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },

                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                },

                get sortText() {
                    switch (this.sortOption) {
                        case null: return 'Filter';
                        case 'a-z': return 'A-Z';
                        case 'z-a': return 'Z-A';
                        case 'latest': return 'Terbaru';
                        case 'oldest': return 'Terlama';
                    }
                },

                filteredSortedData() {
                    let filtered = this.data.filter(item =>
                        item.nama_jabatan.toLowerCase().includes(this.search.toLowerCase())
                    );

                    switch (this.sortOption) {
                        case 'a-z':
                            filtered.sort((a, b) => a.nama_jabatan.localeCompare(b.nama_jabatan));
                            break;
                        case 'z-a':
                            filtered.sort((a, b) => b.nama_jabatan.localeCompare(a.nama_jabatan));
                            break;
                        case 'latest':
                            filtered.sort((a, b) => b.id - a.id);
                            break;
                        case 'oldest':
                            filtered.sort((a, b) => a.id - b.id);
                            break;
                        default:
                            filtered.sort((a, b) => b.id - a.id);
                            break;
                    }

                    return filtered;
                },

                openCreateModal() {
                    document.getElementById('modalCreateJabatan').classList.remove('hidden');
                },

                openEditModal(id, nama) {
                    window.originalJabatan = { id: id, nama_jabatan: nama };
                    const modal = document.getElementById('modalEditJabatan');
                    modal.classList.remove('hidden');
                    document.getElementById('edit_id_jabatan').value = id;
                    document.getElementById('edit_nama_jabatan').value = nama;
                    document.getElementById('formEditJabatan').action = "{{ route('master-data.jabatan.update', '') }}/" + id;
                },

                resetEditJabatan() {
                    if (window.originalJabatan) {
                        document.getElementById('edit_nama_jabatan').value = window.originalJabatan.nama_jabatan;
                    }
                },

                openDeleteModal(id, nama) {
                    const modal = document.getElementById('modalDeleteJabatan');
                    modal.classList.remove('hidden');
                    document.getElementById('delete-nama-jabatan').textContent = nama;
                    document.getElementById('formDeleteJabatan').action = "{{ route('master-data.jabatan.destroy', '') }}/" + id;
                }
            }
        }
    </script>

@endsection
