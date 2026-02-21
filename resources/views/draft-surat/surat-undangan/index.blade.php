@extends('layouts.app')

@section('title', 'Draft Surat Undangan')

@section('content')
    <div class="space-y-6" x-data="draftUndangan()"
        @update-undangan-draft.window="allData = allData.map(item => item.id_surat === $event.detail.id_surat ? $event.detail : item)">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Draft Surat Undangan</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Daftar Surat Undangan yang masih berstatus draft dan belum diarsipkan
                </p>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center gap-3 mt-4 lg:mt-0 w-full lg:w-auto">
                <div class="flex items-center gap-2 w-full lg:w-auto">
                    <div x-data="{ toggleSort: false }" class="relative flex-1 lg:flex-none lg:w-32">
                        <button type="button" @click="toggleSort = !toggleSort"
                            class="w-full flex items-center justify-between space-x-2 px-3 h-[42px] border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-sort-alpha-down text-gray-600 dark:text-gray-400"></i>
                                <span class="text-gray-700 dark:text-gray-300 truncate max-w-[50px] sm:max-w-[70px]"
                                    x-text="sortLabel"></span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs transition-transform"
                                :class="toggleSort && 'rotate-180'"></i>
                        </button>

                        <div x-show="toggleSort" @click.away="toggleSort = false" x-transition x-cloak
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
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400 text-sm">Hapus
                                        Filter</button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="relative flex-1 lg:flex-none lg:w-40">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between space-x-2 px-3 h-[42px] border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar-alt text-gray-600 dark:text-gray-400"></i>
                                <span class="text-gray-700 dark:text-gray-300 truncate max-w-[50px] sm:max-w-[80px]"
                                    x-text="dateDisplay"></span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs transition-transform"
                                :class="open && 'rotate-180'"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition x-cloak
                            class="absolute mt-2 right-0 w-64 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-xl z-50 p-4">
                            <div class="space-y-3">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Tanggal Mulai</label>
                                    <input type="date" x-model="startDate"
                                        class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-green-500 outline-none" />
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Tanggal Akhir</label>
                                    <input type="date" x-model="endDate"
                                        class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-green-500 outline-none" />
                                </div>

                                <div class="flex space-x-2 pt-1">
                                    <button type="button" @click="applyDateFilter(); open = false"
                                        class="flex-1 px-3 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors">Terapkan</button>
                                    <button type="button" @click="clearDateFilter(); open = false"
                                        class="flex-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative w-full lg:w-80 group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-xs"></i>
                    </div>
                    <input type="text" x-model.debounce.300ms="search" placeholder="Cari draft..."
                        class="pl-9 pr-10 h-[42px] border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white w-full text-sm transition-all outline-none">
                    <button type="button" x-show="search" @click="search = ''"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar-x">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hal</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nomor Surat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Dibuat</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="(item, index) in paginatedData" :key="item.id_surat">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"
                                    x-text="(currentPage - 1) * itemsPerPage + index + 1"></td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    <div class="truncate max-w-xs lg:max-w-md"
                                        x-text="item.surat_undangan ? item.surat_undangan.hal : item.nama_surat"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white" x-text="item.nomor_surat || '-'"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"
                                    x-text="formatDate(item.created_at)"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button @click="showDetailDraft(item)"
                                            class="p-1.5 text-purple-500 hover:text-purple-600 dark:text-purple-400 dark:hover:text-purple-300 transition-colors"
                                            title="Preview Draft">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button @click="editDraft(item.id_surat)"
                                            class="p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                            title="Edit Draft">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            @click="arsipkanDraft(item.id_surat, item.surat_undangan ? item.surat_undangan.hal : item.nama_surat)"
                                            class="p-1.5 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors"
                                            title="Arsipkan Surat">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                        <button
                                            @click="deleteDraft(item.id_surat, item.surat_undangan ? item.surat_undangan.hal : item.nama_surat)"
                                            class="p-1.5 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                            title="Hapus Draft">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-if="paginatedData.length === 0">
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                        <h6 class="block mb-2 text-gray-400 dark:text-gray-500">Belum ada draft surat undangan</h6>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800"
                x-show="filteredData.length > 0">
                <div class="flex flex-wrap items-center justify-between gap-3">
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
                        <button @click="setPage(currentPage - 1)" :disabled="currentPage <= 1"
                            class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <template x-for="page in totalPages" :key="page">
                            <button @click="setPage(page)"
                                :class="currentPage === page ? 'bg-green-600 text-white' : 'border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700'"
                                class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg transition-colors text-xs sm:text-sm"
                                x-text="page" x-show="totalPages <= 7 || (page === 1 || page === totalPages || (page >= currentPage - 1 && page <= currentPage + 1))"></button>
                        </template>

                        <button @click="setPage(currentPage + 1)" :disabled="currentPage >= totalPages"
                            class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-300">
                        <span x-text="startItem"></span> - <span x-text="endItem"></span> dari <span x-text="filteredData.length"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('draft-surat.partials.modal-preview')
    @include('template-surat.surat-undangan.partials.modal-preview-pdf')
    @include('draft-surat.surat-undangan.partials.modal-archive')
    @include('draft-surat.surat-undangan.partials.modal-delete')
    @include('draft-surat.surat-undangan.partials.modal-edit')

    <script>
        function draftUndangan() {
            return {
                allData: @json($drafts),
                search: '',
                sortOption: '',
                startDate: '',
                endDate: '',
                currentPage: 1,
                itemsPerPage: 10,

                get sortLabel() {
                    const labels = {
                        'a-z': 'A-Z',
                        'z-a': 'Z-A',
                        'latest': 'Terbaru',
                        'oldest': 'Terlama'
                    };
                    return labels[this.sortOption] || 'Urutkan';
                },

                get dateDisplay() {
                    if (!this.startDate && !this.endDate) return 'Tanggal';
                    if (this.startDate && this.endDate) {
                        const start = new Date(this.startDate).toLocaleDateString('id-ID', { month: 'short', day: 'numeric' });
                        const end = new Date(this.endDate).toLocaleDateString('id-ID', { month: 'short', day: 'numeric' });
                        return `${start} - ${end}`;
                    }
                    if (this.startDate) return new Date(this.startDate).toLocaleDateString('id-ID', { month: 'short', day: 'numeric' });
                    return new Date(this.endDate).toLocaleDateString('id-ID', { month: 'short', day: 'numeric' });
                },

                get filteredData() {
                    let result = this.allData;

                    if (this.search) {
                        const s = this.search.toLowerCase();
                        result = result.filter(item => {
                            const hal = item.surat_undangan?.hal || '';
                            const nomor = item.nomor_surat || '';
                            return hal.toLowerCase().includes(s) || nomor.toLowerCase().includes(s);
                        });
                    }

                    if (this.startDate || this.endDate) {
                        result = result.filter(item => {
                            const itemDate = new Date(item.created_at);
                            if (this.startDate && itemDate < new Date(this.startDate)) return false;
                            if (this.endDate) {
                                const endDate = new Date(this.endDate);
                                endDate.setHours(23, 59, 59, 999);
                                if (itemDate > endDate) return false;
                            }
                            return true;
                        });
                    }

                    if (this.sortOption === 'a-z') {
                        result.sort((a, b) => {
                            const aHal = (a.surat_undangan?.hal || '').toLowerCase();
                            const bHal = (b.surat_undangan?.hal || '').toLowerCase();
                            return aHal.localeCompare(bHal);
                        });
                    } else if (this.sortOption === 'z-a') {
                        result.sort((a, b) => {
                            const aHal = (a.surat_undangan?.hal || '').toLowerCase();
                            const bHal = (b.surat_undangan?.hal || '').toLowerCase();
                            return bHal.localeCompare(aHal);
                        });
                    } else if (this.sortOption === 'latest') {
                        result.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    } else if (this.sortOption === 'oldest') {
                        result.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                    }

                    return result;
                },

                get totalPages() {
                    return Math.ceil(this.filteredData.length / this.itemsPerPage) || 1;
                },

                get paginatedData() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredData.slice(start, start + this.itemsPerPage);
                },

                get startItem() {
                    return this.filteredData.length === 0 ? 0 : (this.currentPage - 1) * this.itemsPerPage + 1;
                },

                get endItem() {
                    const end = this.currentPage * this.itemsPerPage;
                    return end > this.filteredData.length ? this.filteredData.length : end;
                },

                applyDateFilter() {
                    this.currentPage = 1;
                },

                clearDateFilter() {
                    this.startDate = '';
                    this.endDate = '';
                    this.currentPage = 1;
                },

                setPage(page) {
                    if (page >= 1 && page <= this.totalPages) {
                        this.currentPage = page;
                    }
                },

                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },

                formatDate(dateString) {
                    if (!dateString) return '-';
                    const date = new Date(dateString);
                    return date.toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                },

                async arsipkanDraft(id, hal) {
                    document.getElementById('arsipkan-nama-undangan').textContent = hal || '-';
                    
                    const btnConfirm = document.getElementById('btnConfirmArsipkanUndangan');
                    btnConfirm.onclick = async () => {
                        btnConfirm.disabled = true;
                        btnConfirm.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengarsipkan...';

                        try {
                            const response = await fetch("{{ route('surat-undangan.archive', ':id') }}".replace(':id', id), {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json'
                                }
                            });

                            const data = await response.json();

                            if (data.success) {
                                this.allData = this.allData.filter(item => item.id_surat !== id);
                                closeModal('modalArsipkanUndangan');
                                notify('success', 'Berhasil', 'Draft berhasil diarsipkan');
                                setTimeout(() => {
                                    window.location.href = "{{ route('arsip-surat.index') }}";
                                }, 1500);
                            } else {
                                notify('error', 'Gagal', data.message || 'Gagal mengarsipkan draft');
                            }
                        } catch (error) {
                            console.error(error);
                            notify('error', 'Gagal', 'Terjadi kesalahan');
                        } finally {
                            btnConfirm.disabled = false;
                            btnConfirm.innerHTML = 'Arsipkan Surat';
                        }
                    };

                    openModal('modalArsipkanUndangan');
                },

                async editDraft(id) {
                    openEditUndanganModal(id);
                },

                showDetailDraft(item) {
                    window.openDraftPreview(item);
                },

                async deleteDraft(id, hal) {
                    document.getElementById('delete-nama-undangan').textContent = hal || '-';
                    
                    const btnConfirm = document.getElementById('btnConfirmDeleteUndangan');
                    btnConfirm.onclick = async () => {
                        btnConfirm.disabled = true;
                        btnConfirm.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menghapus...';

                        try {
                            const response = await fetch("{{ route('arsip-surat.destroy', ':id') }}".replace(':id', id), {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });

                            const data = await response.json();

                            if (data.success) {
                                const index = this.allData.findIndex(item => item.id_surat === id);
                                if (index > -1) {
                                    this.allData.splice(index, 1);
                                }
                                
                                if (this.currentPage > this.totalPages) {
                                    this.currentPage = Math.max(1, this.totalPages);
                                }
                                
                                closeModal('modalDeleteUndangan');
                                notify('success', 'Berhasil', 'Draft berhasil dihapus');
                            } else {
                                notify('error', 'Gagal', data.message || 'Gagal menghapus draft');
                            }
                        } catch (error) {
                            console.error(error);
                            notify('error', 'Gagal', 'Terjadi kesalahan');
                        } finally {
                            btnConfirm.disabled = false;
                            btnConfirm.innerHTML = 'Hapus Surat';
                        }
                    };

                    openModal('modalDeleteUndangan');
                }
            }
        }
    </script>
@endsection
