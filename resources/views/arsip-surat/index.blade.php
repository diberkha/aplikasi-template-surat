@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('content')
    <div class="space-y-8 pb-8" x-data="arsipSurat()">
        <div class="flex flex-col space-y-4 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Arsip Surat</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        Total <span x-text="filteredData.length"></span> surat tersimpan dalam sistem
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-64 lg:w-72 group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-xs"></i>
                        </div>
                        <input type="text" x-model.debounce.300ms="search" placeholder="Cari..."
                            class="pl-9 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white w-full text-sm transition-all outline-none">
                        <button type="button" x-show="search" @click="search = ''; applyFilters()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <button type="button" onclick="openModal('modalImportSurat')"
                        class="flex items-center justify-center space-x-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium whitespace-nowrap active:scale-95 w-full sm:w-auto">
                        <i class="fas fa-file-upload"></i>
                        <span>Import Surat</span>
                    </button>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-start gap-2 w-full mt-2">
                <div x-data="{ toggleSort: false }" class="relative flex-1 sm:flex-initial min-w-[120px]">
                    <button type="button" @click="toggleSort = !toggleSort"
                        class="w-full flex items-center justify-between space-x-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-filter text-gray-600 dark:text-gray-400"></i>
                            <span class="text-gray-700 dark:text-gray-300 truncate max-w-[80px]" x-text="sortLabel"></span>
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
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-701 dark:text-gray-300 text-sm">Terlama</button>
                            </li>
                            <li class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                                <button type="button" @click="sortOption = ''; toggleSort = false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400 text-sm">Hapus
                                    Filter</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div x-data="{ toggleFilter: false }" class="relative flex-1 sm:flex-initial min-w-[140px]">
                    <button type="button" @click="toggleFilter = !toggleFilter"
                        class="w-full flex items-center justify-between space-x-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-copy text-gray-600 dark:text-gray-400"></i>
                            <span class="text-gray-700 dark:text-gray-300 truncate max-w-[100px]"
                                x-text="selectedTemplateName"></span>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs transition-transform"
                            :class="toggleFilter && 'rotate-180'"></i>
                    </button>

                    <div x-show="toggleFilter" @click.away="toggleFilter = false" x-transition x-cloak
                        class="absolute mt-2 left-0 w-64 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50">
                        <ul class="py-1 max-h-64 overflow-y-auto sidebar-scrollbar list-none">
                            @foreach($templateOptions as $template)
                                <li>
                                    <button type="button"
                                        @click="templateFilter = '{{ $template->id_template_surat }}'; toggleFilter = false"
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

                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Tata Usaha'))
                    <div x-data="{ toggleRuangan: false }" class="relative flex-1 sm:flex-initial min-w-[140px]">
                        <button type="button" @click="toggleRuangan = !toggleRuangan"
                            class="w-full flex items-center justify-between space-x-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-building text-gray-600 dark:text-gray-400"></i>
                                <span class="text-gray-700 dark:text-gray-300 truncate max-w-[100px]"
                                    x-text="selectedRuanganName"></span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs transition-transform"
                                :class="toggleRuangan && 'rotate-180'"></i>
                        </button>

                        <div x-show="toggleRuangan" @click.away="toggleRuangan = false" x-transition x-cloak
                            class="absolute mt-2 left-0 w-64 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50">
                            <div class="px-3 py-2 border-b border-gray-100 dark:border-gray-700">
                                <div class="relative">
                                    <input type="text" x-model="searchRuangan" placeholder="Cari ruangan..."
                                        class="w-full pl-2 pr-8 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-green-500 outline-none transition-all">
                                    <button type="button" x-show="searchRuangan" @click="searchRuangan = ''"
                                        class="absolute inset-y-0 right-0 pr-2 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                                        <i class="fas fa-times-circle text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            <ul class="max-h-64 overflow-y-auto sidebar-scrollbar list-none py-1">
                                <template x-for="ruangan in filteredRuanganOptions" :key="ruangan.id_ruangan">
                                    <li>
                                        <button type="button"
                                            @click="ruanganFilter = ruangan.id_ruangan; toggleRuangan = false; applyFilters()"
                                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm"
                                            x-text="ruangan.nama_ruangan">
                                        </button>
                                    </li>
                                </template>
                                <li x-show="filteredRuanganOptions.length === 0"
                                    class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400 italic">
                                    Tidak ditemukan
                                </li>
                            </ul>
                            <div class="border-t border-gray-100 dark:border-gray-700 p-1">
                                <button type="button" @click="ruanganFilter = ''; toggleRuangan = false; applyFilters()"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400 text-sm">
                                    Hapus Filter
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <div x-data="{ open: false }" class="relative flex-1 sm:flex-initial min-w-[140px]">
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between space-x-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm text-gray-700 dark:text-gray-300">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-calendar-alt text-gray-600 dark:text-gray-400"></i>
                            <span class="truncate max-w-[100px]" x-text="dateDisplay"></span>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs transition-transform"
                            :class="open && 'rotate-180'"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition x-cloak
                        class="absolute mt-2 left-0 sm:right-0 sm:left-auto w-64 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-xl z-50 p-4">
                        <div class="space-y-3">
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Tanggal
                                    Mulai</label>
                                <input type="date" x-model="startDate"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-green-500 outline-none" />
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Tanggal
                                    Akhir</label>
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
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden relative">
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Surat</h3>
                <div class="sm:hidden animate-pulse">
                    <i class="fas fa-arrows-left-right text-gray-400 text-xs"></i>
                </div>
            </div>

            @if($totalSurat > 0)
                <div class="overflow-x-auto custom-scrollbar-x">
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
                                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Tata Usaha'))
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Dibuat Oleh</th>
                                @endif
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-for="(item, index) in paginatedData" :key="item.id_surat">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900 dark:text-white"
                                            x-text="(currentPage - 1) * itemsPerPage + index + 1"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                            :class="item.badge_color" x-text="item.tipe_surat_display">
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-[300px] truncate"
                                        :title="item.nama_surat_display" x-text="item.nama_surat_display"></td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white max-w-[200px] truncate"
                                        :title="item.tipe_surat_display === 'Surat Izin Cuti' ? '-' : item.nomor_surat"
                                        x-text="item.tipe_surat_display === 'Surat Izin Cuti' ? '-' : item.nomor_surat"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"
                                        x-text="formatDate(item.tanggal_dibuat)"></td>
                                    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Tata Usaha'))
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"
                                            x-text="item.ruangan"></td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <button type="button"
                                                @click="showDetailSurat(item.id_surat, item.nama_surat_display, item.nomor_surat, item.tipe_surat_display, item.tanggal_dibuat, item.ruangan, item.file_path, item.docx_url)"
                                                class="inline-flex items-center p-1.5 text-purple-500 hover:text-purple-600 dark:text-purple-400 dark:hover:text-purple-300 transition-colors">
                                                <i class="fas fa-eye text-sm"></i>
                                            </button>

                                            <div x-data="{ 
                                                                                                                                                        openDownload: false, 
                                                                                                                                                        dropdownStyle: '',
                                                                                                                                                        toggle() { 
                                                                                                                                                            this.openDownload = !this.openDownload;
                                                                                                                                                            if (this.openDownload) {
                                                                                                                                                                this.$nextTick(() => {
                                                                                                                                                                    const rect = this.$refs.button.getBoundingClientRect();
                                                                                                                                                                    this.dropdownStyle = `top: ${rect.bottom + 5}px; left: ${rect.right - 160}px;`;
                                                                                                                                                                });
                                                                                                                                                            }
                                                                                                                                                        } 
                                                                                                                                                    }"
                                                @scroll.window="openDownload = false" class="relative">
                                                <button type="button" x-ref="button" @click="toggle()"
                                                    class="inline-flex items-center p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                                    <i class="fas fa-download text-sm"></i>
                                                </button>
                                                <template x-teleport="body">
                                                    <div x-show="openDownload" x-ref="dropdown"
                                                        @click.outside="openDownload = false" x-transition
                                                        :style="dropdownStyle"
                                                        class="fixed w-40 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-1 z-[9999]">
                                                        <template
                                                            x-if="item.docx_url !== '#' && (!item.file_path || (!item.file_path.includes('arsip/import') && !item.file_path.includes('arsip\\import')))">
                                                            <a :href="item.docx_url"
                                                                class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                <i class="fas fa-file-word text-green-600 mr-2 w-4"></i> DOCX
                                                            </a>
                                                        </template>
                                                        <a :href="item.download_url"
                                                            class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                            <i class="fas fa-file-pdf text-red-600 mr-2 w-4"></i> PDF
                                                        </a>
                                                    </div>
                                                </template>
                                            </div>

                                            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Tata Usaha'))
                                                <button type="button"
                                                    @click="openDeleteModal(item.id_surat, item.nama_surat_display, item.nomor_surat, item.tipe_surat_display)"
                                                    class="inline-flex items-center p-1.5 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            @endif
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
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                    <h6 class="block mb-2 text-gray-400 dark:text-gray-500">Belum ada data surat</h6>

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

    @include('arsip-surat.partials.modal-delete')

    @include('arsip-surat.partials.modal-import')

    @include('arsip-surat.partials.modal-detail')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('arsipSurat', () => ({
                allData: @json($surat),
                templateOptions: @json($templateOptions).filter(t => {
                    const name = t.nama_template_surat.toLowerCase();
                    return name.includes('cuti') || name.includes('sop') || name.includes('sk direktur');
                }),
                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Tata Usaha'))
                                                                                                                            ruanganOptions: @json($ruanganOptions ?? []),
                    searchRuangan: '',
                @endif
                search: '',
                sortOption: '',
                templateFilter: '',
                ruanganFilter: '{{ request('ruangan_id') }}',
                startDate: '{{ request('start_date') }}',
                endDate: '{{ request('end_date') }}',
                appliedStartDate: '{{ request('start_date') }}',
                appliedEndDate: '{{ request('end_date') }}',
                itemsPerPage: 10,
                currentPage: 1,
                toggleSort: false,
                toggleFilter: false,

                get filteredData() {
                let data =[...this.allData];

                if(this.search) {
                const s = this.search.toLowerCase();
                data = data.filter(item =>
                    item.nama_surat_display.toLowerCase().includes(s) ||
                    item.nomor_surat.toLowerCase().includes(s) ||
                    (item.username && item.username.toLowerCase().includes(s)) ||
                    (item.tipe_surat_display && item.tipe_surat_display.toLowerCase().includes(s))
                );
            }

            if (this.templateFilter) {
                data = data.filter(item => item.id_template_surat == this.templateFilter);
            }

            if (this.ruanganFilter) {
                data = data.filter(item => item.id_ruangan == this.ruanganFilter);
            }

            if (this.appliedStartDate && this.appliedEndDate) {
                data = data.filter(item => {
                    const date = item.tanggal_dibuat.substring(0, 10);
                    return date >= this.appliedStartDate && date <= this.appliedEndDate;
                });
            } else if (this.appliedStartDate) {
                data = data.filter(item => item.tanggal_dibuat.substring(0, 10) === this.appliedStartDate);
            } else if (this.appliedEndDate) {
                data = data.filter(item => item.tanggal_dibuat.substring(0, 10) === this.appliedEndDate);
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
                const current = this.currentPage;
                const delta = 1;
                const range = [];
                const rangeWithDots = [];

                range.push(1);

                for(let i = current - delta; i <= current + delta; i++) {
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

                                                                    get sortLabel() {
            switch (this.sortOption) {
                case 'a-z': return 'A-Z';
                case 'z-a': return 'Z-A';
                case 'latest': return 'Terbaru';
                case 'oldest': return 'Terlama';
                default: return 'Urutkan';
            }
        },

                                                                    get selectedTemplateName() {
            if (!this.templateFilter) return 'Tipe Surat';
            const tpl = this.templateOptions.find(t => t.id_template_surat == this.templateFilter);
            return tpl ? tpl.nama_template_surat : 'Tipe Surat';
        },

                                                                    get selectedRuanganName() {
            if (!this.ruanganFilter) return 'Ruangan';
            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Tata Usaha'))
                const r = this.ruanganOptions.find(t => t.id_ruangan == this.ruanganFilter);
                return r ? r.nama_ruangan : 'Ruangan';
            @else
                return 'Ruangan';
            @endif
                                                                    },

                                                                    get filteredRuanganOptions() {
            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Tata Usaha'))
                if (!this.searchRuangan) return this.ruanganOptions;
                const s = this.searchRuangan.toLowerCase();
                return this.ruanganOptions.filter(r => r.nama_ruangan.toLowerCase().includes(s));
            @else
                return [];
            @endif
                                                                    },

        applyFilters() {
            this.currentPage = 1;
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
            if (!dateStr) return '';
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

        setPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
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
        }
                                                                }));
                                                            });

        function showDetailSurat(idSurat, nama, nomor, tipe, tanggal, itemRuangan, filePath, docxUrl) {
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

            const nomorContainer = document.getElementById('detail-nomor-surat-container');
            if (tipe === 'Surat Izin Cuti') {
                nomorContainer.classList.add('hidden');
            } else {
                nomorContainer.classList.remove('hidden');
                document.getElementById('detail-nomor-surat').textContent = nomor;
            }

            document.getElementById('detail-tanggal-dibuat').textContent = formatLongDate(tanggal);
            const dibuatOlehEl = document.getElementById('detail-dibuat-oleh');
            if (dibuatOlehEl) {
                dibuatOlehEl.textContent = itemRuangan;
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

            const isSystemDoc = ['Surat Keputusan Direktur', 'Standar Operasional Prosedur (SOP)', 'Surat Izin Cuti'].includes(tipe);

            if (filePath || isSystemDoc) {
                document.getElementById('detail-file-exists').classList.remove('hidden');
                document.getElementById('detail-no-file').classList.add('hidden');
                document.getElementById('detail-download-dropdown').classList.remove('hidden');

                const cleanNomor = nomor ? nomor.replace(/[\/\\*:\?"<>|]/g, '-') : '';
                let fileName = '';

                if (tipe === 'Standar Operasional Prosedur (SOP)') {
                    fileName = `SOP-${cleanNomor}.pdf`;
                } else if (tipe === 'Surat Keputusan Direktur') {
                    fileName = `SK Direktur-${cleanNomor}.pdf`;
                } else if (tipe === 'Surat Izin Cuti') {
                    fileName = `Surat Izin Cuti-${nama}.pdf`;
                } else {
                    fileName = filePath ? filePath.split('/').pop() : `${tipe}-${cleanNomor || 'Document'}.pdf`;
                }

                document.getElementById('detail-file-nama').textContent = fileName;
                document.getElementById('detail-download-pdf').href = `/arsip-surat/${idSurat}/download`;

                const docxBtn = document.getElementById('detail-download-word');
                if (filePath && (filePath.includes('arsip/import') || filePath.includes('arsip\\import'))) {
                    docxBtn.classList.add('hidden');
                } else {
                    docxBtn.classList.remove('hidden');
                }

                const previewIframe = document.getElementById('detail-pdf-preview');
                const fileIcon = document.getElementById('detail-file-icon');
                const fileTypeLabel = document.getElementById('detail-file-type-label');

                previewIframe.classList.remove('hidden');
                previewIframe.src = `/arsip-surat/${idSurat}`;
                fileIcon.className = 'fas fa-file-pdf text-2xl text-red-500';
                fileTypeLabel.textContent = 'File PDF';
            } else {
                document.getElementById('detail-file-exists').classList.add('hidden');
                document.getElementById('detail-no-file').classList.remove('hidden');
                document.getElementById('detail-download-dropdown').classList.add('hidden');
            }

            const modal = document.getElementById('modalDetailSurat');
            modal.dataset.suratId = idSurat;
            modal.dataset.docxUrl = docxUrl;
            openModal('modalDetailSurat');
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

        function openDeleteModal(id, namaSurat, nomorSurat, tipeSurat) {
            document.getElementById('delete-nama-surat').textContent = namaSurat;
            document.getElementById('delete-nomor-surat').textContent = nomorSurat;
            document.getElementById('delete-tipe-surat').textContent = tipeSurat;
            document.getElementById('formDeleteSurat').action = `/arsip-surat/${id}`;
            openModal('modalDeleteSurat');
        }

        function closeDetailModal() {
            const iframe = document.getElementById('detail-pdf-preview');
            if (iframe) {
                iframe.src = '';
            }
            closeModal('modalDetailSurat');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeDetailModal();
                closeModal('modalDeleteSurat');
                closeModal('modalImportSurat');
            }
        });
    </script>
@endsection