@extends('layouts.app')

@section('title', 'Data Pegawai - E-Office')

@section('content')
    <div x-data="pegawaiTable()" class="space-y-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Data Pegawai</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola informasi data pegawai</p>
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
                
                <div x-data="{ toggleType: false }" class="relative">
                    <button type="button" @click="toggleType = !toggleType"
                        class="flex items-center space-x-2 px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                        <i class="fas fa-users text-gray-600 dark:text-gray-400"></i>
                        <span class="text-gray-700 dark:text-gray-300" x-text="selectedType === '' ? 'Jenis Pegawai' : selectedType"></span>
                        <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs"></i>
                    </button>

                    <div x-show="toggleType" @click.away="toggleType = false" x-transition
                        class="absolute mt-2 left-0 w-40 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50">
                        <ul class="py-1">
                            <li><button @click="selectedType='PNS'; toggleType=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">PNS</button>
                            </li>
                            <li><button @click="selectedType='PPPK'; toggleType=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">PPPK</button>
                            </li>
                            <li><button @click="selectedType='NON ASN'; toggleType=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">NON ASN</button>
                            </li>
                            <li class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                                <button @click="selectedType=''; toggleType=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400 text-sm">Hapus Filter</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="relative flex-1 sm:flex-initial">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                    <input type="text" x-model="search" placeholder="Cari pegawai..."
                        class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white w-full sm:w-64 text-sm">
                </div>

                <button @click="openCreateModal()"
                    class="flex items-center space-x-2 px-3 sm:px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm whitespace-nowrap">
                    <i class="fas fa-plus"></i>
                    <span class="hidden sm:inline">Tambah Pegawai</span>
                    <span class="sm:hidden">Tambah</span>
                </button>
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Pegawai</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                No</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nama</th>
                            <th x-show="selectedType !== 'NON ASN'"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                NIP</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Jabatan</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Jenis Pegawai</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Masa Kerja (TMT)</th>
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
                                <td class="px-6 py-4 text-gray-900 dark:text-white" x-text="item.nama"></td>
                                <td class="px-6 py-4" x-text="item.nip" x-show="selectedType !== 'NON ASN'"></td>
                                <td class="px-6 py-4" x-text="item.jabatan || '-'"></td>
                                <td class="px-6 py-4" x-text="item.jenis_pegawai"></td>
                                <td class="px-6 py-4" x-text="formatDate(item.masa_kerja)"></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <button @click="openEditModal(item.id)"
                                            class="inline-flex items-center p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <button @click="openDeleteModal(item.id, item.nama, item.nip)"
                                            class="inline-flex items-center p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
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
        </div>

        @include('master-data.pegawai.partials.modal-create')
        @include('master-data.pegawai.partials.modal-edit')
        @include('master-data.pegawai.partials.modal-delete')

    </div>

    <script>
        function pegawaiTable() {
            return {
                search: '',
                sortOption: null,
                selectedType: '',
                data: @json($pegawai),

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
                    let filtered = this.data.filter(item => {
                        const matchesSearch = item.nama.toLowerCase().includes(this.search.toLowerCase()) ||
                            (item.nip && item.nip.toLowerCase().includes(this.search.toLowerCase())) ||
                            (item.jabatan && item.jabatan.toLowerCase().includes(this.search.toLowerCase()));
                        
                        const matchesType = this.selectedType === '' || item.jenis_pegawai === this.selectedType;

                        return matchesSearch && matchesType;
                    });

                    switch (this.sortOption) {
                        case 'a-z':
                            filtered.sort((a, b) => a.nama.localeCompare(b.nama));
                            break;
                        case 'z-a':
                            filtered.sort((a, b) => b.nama.localeCompare(a.nama));
                            break;
                        case 'latest':
                            filtered.sort((a, b) => b.id - a.id);
                            break;
                        case 'oldest':
                            filtered.sort((a, b) => a.id - b.id);
                            break;
                    }

                    return filtered;
                },

                formatDate(dateStr) {
                    if(!dateStr) return '-';
                    const date = new Date(dateStr);
                    return date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                },

                openCreateModal() {
                    const modal = document.getElementById('modalCreatePegawai');
                    modal.classList.remove('hidden');
                },

                openEditModal(id) {
                    const modal = document.getElementById('modalEditPegawai');
                    modal.classList.remove('hidden');
                    
                    fetch(`/api/pegawai/${id}`)
                        .then(r => r.json())
                        .then(data => {
                            document.getElementById('edit_id_pegawai').value = data.id;
                            document.getElementById('edit_nama_pegawai').value = data.nama;
                            document.getElementById('edit_nip_pegawai').value = data.nip;
                            document.getElementById('edit_jabatan_pegawai').value = data.jabatan;
                            document.getElementById('edit_jenis_pegawai').value = data.jenis_pegawai;
                            document.getElementById('edit_masa_kerja_pegawai').value = data.masa_kerja;
                            
                            document.getElementById('edit_sisa_cuti_n').value = data.sisa_cuti_n;
                            document.getElementById('edit_sisa_cuti_n1').value = data.sisa_cuti_n1;
                            document.getElementById('edit_sisa_cuti_n2').value = data.sisa_cuti_n2;

                            document.getElementById('formEditPegawai').action = "{{ route('master-data.pegawai.update', '') }}/" + data.id;
                            
                            if (typeof toggleNIPField === 'function') {
                                toggleNIPField(data.jenis_pegawai, 'edit');
                            }
                            if (typeof updateMasaKerjaLabel === 'function') {
                                updateMasaKerjaLabel(data.jenis_pegawai, 'edit');
                            }
                        });
                },

                openDeleteModal(id, nama, nip) {
                    const modal = document.getElementById('modalDeletePegawai');
                    modal.classList.remove('hidden');
                    document.getElementById('delete-nama-pegawai').textContent = nama;
                    document.getElementById('delete-nip-pegawai').textContent = nip || '-';
                    document.getElementById('formDeletePegawai').action = "{{ route('master-data.pegawai.destroy', '') }}/" + id;
                }
            }
        }
    </script>

    <script>
        function updateMasaKerjaLabel(type, context) {
            const labelId = context === 'create' ? 'label_masa_kerja_create' : 'label_masa_kerja_edit';
            const label = document.getElementById(labelId);
            if (!label) return;

            if (type === 'PNS' || type === 'PPPK') {
                label.innerHTML = 'TMT CPNS <span class="text-red-500">*</span>';
            } else {
                label.innerHTML = 'Masa Kerja <span class="text-red-500">*</span>';
            }
        }
    </script>

@endsection
