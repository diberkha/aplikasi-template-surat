@extends('layouts.app')

@section('title', 'Draft Standar Operasional Prosedur (SOP)')

@section('content')
    <div class="space-y-6" x-data="draftSop()"
        @update-sop-draft.window="allData = allData.map(item => item.id_surat === $event.detail.id_surat ? $event.detail : item)">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Draft Standar Operasional Prosedur (SOP)</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Daftar Standar Operasional Prosedur yang masih berstatus draft dan belum diarsipkan
                </p>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center gap-3 mt-4 lg:mt-0 w-full lg:w-auto">
                <div class="flex items-center gap-2 w-full lg:w-auto">
                    <div x-data="{ toggleSort: false }" class="relative flex-1 lg:flex-none lg:w-36">
                        <button type="button" @click="toggleSort = !toggleSort"
                            class="w-full flex items-center justify-between space-x-2 px-3 h-[42px] border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-sort-alpha-down text-gray-600 dark:text-gray-400"></i>
                                <span class="text-gray-700 dark:text-gray-300 truncate max-w-[80px]"
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

                    <div x-data="{ open: false }" class="relative flex-1 lg:flex-none lg:w-44">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between space-x-2 px-3 h-[42px] border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar-alt text-gray-600 dark:text-gray-400"></i>
                                <span class="text-gray-700 dark:text-gray-300 truncate max-w-[100px]"
                                    x-text="dateDisplay"></span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs transition-transform"
                                :class="open && 'rotate-180'"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition x-cloak
                            class="absolute mt-2 left-0 sm:right-0 sm:left-auto w-64 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-xl z-50 p-4">
                            <div class="space-y-3">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Mulai</label>
                                    <input type="date" x-model="startDate"
                                        class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-green-500 outline-none" />
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Akhir</label>
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
                    <button type="button" x-show="search" @click="search = ''; currentPage = 1"
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
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                No</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Judul SOP
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Nomor Dokumen
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tanggal Dibuat
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-center">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="(item, index) in paginatedData" :key="item.id_surat">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"
                                    x-text="(currentPage - 1) * itemsPerPage + index + 1"></td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    <div class="truncate max-w-xs lg:max-w-md"
                                        :title="item.sop ? item.sop.judul_sop : item.nama_surat"
                                        x-text="item.sop ? item.sop.judul_sop : item.nama_surat"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white"
                                        x-text="item.sop ? item.sop.nomor_dokumen : (item.nomor_surat || '-')"></div>
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
                                            @click="arsipkanDraft(item.id_surat, item.sop ? item.sop.judul_sop : item.nama_surat)"
                                            class="p-1.5 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors"
                                            title="Arsipkan Surat">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                        <button
                                            @click="deleteDraft(item.id_surat, item.sop ? item.sop.judul_sop : item.nama_surat)"
                                            class="p-1.5 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                            title="Hapus Draft">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-if="filteredData.length === 0">
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                        <h6 class="block mb-2 text-gray-400 dark:text-gray-500">Belum ada draft standar
                                            operasional prosedur</h6>
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
                        <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 hidden sm:inline">Items per
                            page:</span>
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
                            <button @click="p !== '...' && setPage(p)" x-text="p" :disabled="p === '...'"
                                class="h-8 min-w-[32px] sm:h-10 sm:min-w-[40px] px-2 sm:px-3 flex items-center justify-center rounded-lg border text-xs sm:text-sm font-semibold transition-colors"
                                :class="[
                                                                                                                                parseInt(p) === parseInt(currentPage) ? 'bg-green-600 border-green-600 text-white' :
                                                                                                                                (p === '...' ? 'border-transparent text-gray-500 dark:text-gray-400 cursor-default' :
                                                                                                                                'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600'),
                                                                                                                                (typeof p === 'number' && Math.abs(p - currentPage) > 1 && p !== 1 && p !== totalPages) ? 'hidden md:flex' : 'flex'
                                                                                                                                ]">
                            </button>
                        </template>

                        <button @click="setPage(currentPage + 1)" :disabled="currentPage >= totalPages"
                            class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <div
                        class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 w-full sm:w-auto text-center sm:text-left">
                        <span x-text="filteredData.length === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1"></span> -
                        <span x-text="Math.min(currentPage * itemsPerPage, filteredData.length)"></span> dari
                        <span x-text="filteredData.length"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('draft-surat.sop.partials.modal-edit')
    @include('draft-surat.sop.partials.modal-archive')
    @include('draft-surat.sop.partials.modal-delete')
    @include('draft-surat.partials.modal-preview')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('draftSop', () => ({
                allData: @json($drafts),
                search: '',
                currentPage: 1,
                itemsPerPage: 10,

                sortOption: '',
                startDate: '',
                endDate: '',
                appliedStartDate: '',
                appliedEndDate: '',
                toggleSort: false,
                open: false,

                get filteredData() {
                    let data = [...this.allData];

                    if (this.search) {
                        const s = this.search.toLowerCase();
                        data = data.filter(item => {
                            const judul = item.sop ? item.sop.judul_sop : item.nama_surat;
                            const nomor = item.sop ? item.sop.nomor_dokumen : item.nomor_surat;
                            return judul.toLowerCase().includes(s) || nomor.toLowerCase().includes(s);
                        });
                    }

                    if (this.appliedStartDate && this.appliedEndDate) {
                        data = data.filter(item => {
                            const date = item.created_at.substring(0, 10);
                            return date >= this.appliedStartDate && date <= this.appliedEndDate;
                        });
                    } else if (this.appliedStartDate) {
                        data = data.filter(item => item.created_at.substring(0, 10) === this.appliedStartDate);
                    } else if (this.appliedEndDate) {
                        data = data.filter(item => item.created_at.substring(0, 10) === this.appliedEndDate);
                    }

                    if (this.sortOption === 'a-z') {
                        data.sort((a, b) => {
                            const valA = a.sop ? a.sop.judul_sop : a.nama_surat;
                            const valB = b.sop ? b.sop.judul_sop : b.nama_surat;
                            return valA.localeCompare(valB);
                        });
                    } else if (this.sortOption === 'z-a') {
                        data.sort((a, b) => {
                            const valA = a.sop ? a.sop.judul_sop : a.nama_surat;
                            const valB = b.sop ? b.sop.judul_sop : b.nama_surat;
                            return valB.localeCompare(valA);
                        });
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

                setPage(page) {
                    if (page >= 1 && page <= this.totalPages) {
                        this.currentPage = page;
                    }
                },

                get sortLabel() {
                    switch (this.sortOption) {
                        case 'a-z': return 'A-Z';
                        case 'z-a': return 'Z-A';
                        case 'latest': return 'Terbaru';
                        case 'oldest': return 'Terlama';
                        default: return 'Urutkan';
                    }
                },

                get dateDisplay() {
                    if (this.appliedStartDate && this.appliedEndDate) {
                        return `${this.formatDate(this.appliedStartDate, 'short')} - ${this.formatDate(this.appliedEndDate, 'short')}`;
                    } else if (this.appliedStartDate) {
                        return this.formatDate(this.appliedStartDate, 'long');
                    } else if (this.appliedEndDate) {
                        return this.formatDate(this.appliedEndDate, 'long');
                    }
                    return 'Tanggal';
                },

                formatDate(dateStr, monthStyle = 'long') {
                    if (!dateStr) return '-';
                    const d = new Date(dateStr);
                    if (monthStyle === 'short') {
                        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                        return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
                    }
                    return d.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                },

                applyDateFilter() {
                    this.appliedStartDate = this.startDate;
                    this.appliedEndDate = this.endDate;
                    this.open = false;
                    this.currentPage = 1;
                },

                clearDateFilter() {
                    this.startDate = '';
                    this.endDate = '';
                    this.appliedStartDate = '';
                    this.appliedEndDate = '';
                    this.currentPage = 1;
                    this.open = false;
                },

                editDraft(id) {
                    openEditSopModal(id);
                },

                arsipkanDraft(id, title) {
                    document.getElementById('arsipkan-judul-sop').textContent = title;
                    const btnConfirm = document.getElementById('btnConfirmArsipkanSop');

                    const newBtn = btnConfirm.cloneNode(true);
                    btnConfirm.parentNode.replaceChild(newBtn, btnConfirm);

                    newBtn.addEventListener('click', () => {
                        fetch("{{ route('sop.archive', ':id') }}".replace(':id', id), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({})
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    notify('success', 'Berhasil', 'Surat berhasil diarsipkan');
                                    closeModal('modalArsipkanSop');
                                    setTimeout(() => {
                                        window.location.href = "{{ route('arsip-surat.index') }}";
                                    }, 1000);
                                } else {
                                    notify('error', 'Gagal', data.message || 'Terjadi kesalahan');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                notify('error', 'Gagal', 'Terjadi kesalahan sistem');
                            });
                    });

                    openModal('modalArsipkanSop');
                },

                deleteDraft(id, title) {
                    document.getElementById('delete-judul-sop').textContent = title;
                    const btnConfirm = document.getElementById('btnConfirmDeleteSop');

                    const newBtn = btnConfirm.cloneNode(true);
                    btnConfirm.parentNode.replaceChild(newBtn, btnConfirm);

                    newBtn.addEventListener('click', () => {
                        fetch("{{ route('arsip-surat.destroy', ':id') }}".replace(':id', id), {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    notify('success', 'Berhasil', 'Draft berhasil dihapus');
                                    closeModal('modalDeleteSop');
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                } else {
                                    notify('error', 'Gagal', data.message || 'Terjadi kesalahan');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                notify('error', 'Gagal', 'Terjadi kesalahan sistem');
                            });
                    });

                    openModal('modalDeleteSop');
                },

                showDetailDraft(item) {
                    window.openDraftPreview(item);
                }
            }));
        });
    </script>
@endsection
