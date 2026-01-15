@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('content')
    <div class="space-y-8 pb-8" x-data="arsipSurat()">
        <div class="flex flex-col space-y-4 mb-6">
            {{-- Top Row: Title (Left) and Actions (Right) --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Arsip Surat</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        Total <span x-text="filteredData.length"></span> surat tersimpan dalam sistem
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-64 lg:w-72">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-xs"></i>
                        </div>
                        <input type="text" x-model.debounce.300ms="search" placeholder="Cari..."
                            class="pl-9 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white w-full text-sm">
                    </div>
                    <button type="button" onclick="openModal('modalImportSurat')"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors shadow-sm w-full sm:w-auto">
                        <i class="fas fa-file-upload mr-2"></i>
                        Import Surat
                    </button>
                </div>
            </div>

            {{-- Bottom Row: Filters (Start Left) --}}
            <div class="flex flex-wrap items-center justify-start gap-2 sm:gap-3 w-full">
                <div x-data="{ toggleSort: false }" class="relative flex-1 sm:flex-initial">
                    <button type="button" @click="toggleSort = !toggleSort"
                        class="w-full flex items-center justify-between sm:justify-start space-x-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-filter text-gray-600 dark:text-gray-400"></i>
                            <span class="text-gray-700 dark:text-gray-300" x-text="sortLabel"></span>
                        </div>
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
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400 text-sm">Hapus
                                    Filter</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div x-data="{ toggleFilter: false }" class="relative flex-1 sm:flex-initial">
                    <button type="button" @click="toggleFilter = !toggleFilter"
                        class="w-full flex items-center justify-between sm:justify-start space-x-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-copy text-gray-600 dark:text-gray-400"></i>
                            <span class="text-gray-700 dark:text-gray-300 truncate max-w-[80px] sm:max-w-none"
                                x-text="selectedTemplateName"></span>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs text-right"></i>
                    </button>

                    <div x-show="toggleFilter" @click.away="toggleFilter = false" x-transition
                        class="absolute mt-2 left-0 w-64 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50">
                        <ul class="py-1 max-h-64 overflow-y-auto sidebar-scrollbar">
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

                <div x-data="{ open: false }" class="relative flex-1 sm:flex-initial">
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between sm:justify-start space-x-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-calendar-alt text-gray-600 dark:text-gray-400"></i>
                            <span class="text-gray-700 dark:text-gray-300 truncate max-w-[80px] sm:max-w-none"
                                x-text="dateDisplay"></span>
                        </div>
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

                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Tata Usaha'))
                    <div x-data="{ toggleRuangan: false }" class="relative flex-1 sm:flex-initial">
                        <button type="button" @click="toggleRuangan = !toggleRuangan"
                            class="w-full flex items-center justify-between sm:justify-start space-x-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-building text-gray-600 dark:text-gray-400"></i>
                                <span class="text-gray-700 dark:text-gray-300 truncate max-w-[80px] sm:max-w-none"
                                    x-text="selectedRuanganName"></span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs text-right"></i>
                        </button>

                        <div x-show="toggleRuangan" @click.away="toggleRuangan = false" x-transition
                            class="absolute mt-2 left-0 w-64 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50">
                            <ul class="py-1 max-h-64 overflow-y-auto sidebar-scrollbar">
                                @foreach($ruanganOptions as $ruangan)
                                    <li>
                                        <button type="button"
                                            @click="ruanganFilter = '{{ $ruangan->id_ruangan }}'; toggleRuangan = false; applyFilters()"
                                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">
                                            {{ $ruangan->nama_ruangan }}
                                        </button>
                                    </li>
                                @endforeach
                                <li class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                                    <button type="button" @click="ruanganFilter = ''; toggleRuangan = false; applyFilters()"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400 text-sm">
                                        Hapus Filter
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"
                                        x-text="item.nama_surat_display"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"
                                        x-text="item.nomor_surat"></td>
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
                                                                                                                                                                        }"
                                                    @scroll.window="openDownload = false" class="relative">
                                                    <button type="button" x-ref="button" @click="toggle()"
                                                        class="inline-flex items-center p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                                        <i class="fas fa-download text-sm"></i>
                                                    </button>
                                                    <template x-teleport="body">
                                                        <div x-show="openDownload" x-ref="dropdown"
                                                            @click.outside="openDownload = false" x-transition
                                                            class="fixed w-40 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-1 z-[9999]">
                                                            <a :href="item.download_url"
                                                                class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                <i class="fas fa-file-pdf text-red-600 mr-2 w-4"></i> PDF
                                                            </a>
                                                            <template x-if="item.docx_url !== '#'">
                                                                <a :href="item.docx_url"
                                                                    class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                    <i class="fas fa-file-word text-green-600 mr-2 w-4"></i>
                                                                    DOCX
                                                                </a>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="!item.file_path">
                                                <button type="button"
                                                    @click="notify('error', 'Gagal', 'File surat tidak tersedia untuk diunduh', false)"
                                                    class="inline-flex items-center p-1.5 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-400 transition-colors">
                                                    <i class="fas fa-download text-sm"></i>
                                                </button>
                                            </template>

                                            @if(auth()->user()->hasRole('Admin'))
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
                            <template x-if="paginatedData.length === 0">
                                <tr>
                                    <td :colspan="('{{ auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Tata Usaha') }}' ? 7 : 6)"
                                        class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                            <h6 class="block mb-2 text-gray-400 dark:text-gray-500">Belum ada data
                                                surat</h6>
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
                                                                                                                                                                parseInt(p) === parseInt(currentPage) ? 'bg-green-600 border-green-600 text-white shadow-sm' : 
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
                <div
                    class="mt-4 bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
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

    <!-- Modal Import Surat -->
    <div id="modalImportSurat" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
            <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
                onclick="closeModal('modalImportSurat')"></div>

            <div
                class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-lg w-full overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700">

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Import Surat</h3>
                    <button onclick="closeModal('modalImportSurat')"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('arsip-surat.import') }}" method="POST" enctype="multipart/form-data"
                    class="flex flex-col flex-1 overflow-hidden" x-data="{ 
                                                            openTipe: false, 
                                                            tipeSuratLabel: '',
                                                            options: [
                                                                { value: 'Surat Keputusan Direktur', label: 'Surat Keputusan Direktur' },
                                                                { value: 'Standar Operasional Prosedur (SOP)', label: 'Standar Operasional Prosedur (SOP)' },
                                                            ],
                                                            select(opt) {
                                                                this.tipeSurat = opt.value;
                                                                this.tipeSuratLabel = opt.label;
                                                                this.openTipe = false;
                                                            }
                                                        }">
                    @csrf
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Tipe Surat <span
                                    class="text-red-500">*</span></label>

                            <div class="relative" @click.outside="openTipe = false">
                                <input type="hidden" name="tipe_surat" :value="tipeSurat" required>

                                <button type="button" @click="openTipe = !openTipe"
                                    class="w-full px-4 py-2 text-left border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white flex justify-between items-center transition-all focus:ring-2 focus:ring-green-500 outline-none">
                                    <span x-text="tipeSuratLabel || 'Pilih Tipe Surat'"
                                        :class="!tipeSuratLabel && 'text-gray-400 font-normal'"
                                        class="text-gray-700 dark:text-gray-300"></span>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                                        :class="openTipe && 'rotate-180'"></i>
                                </button>

                                <div x-show="openTipe" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-end="opacity-0 transform scale-95"
                                    class="absolute z-[9999] mt-1 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-2xl overflow-hidden"
                                    style="display: none;">
                                    <ul class="py-1">
                                        <template x-for="opt in options" :key="opt.value">
                                            <li>
                                                <button type="button" @click="select(opt)"
                                                    class="w-full px-4 py-2.5 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20 hover:text-green-600 dark:hover:text-green-400 transition-colors flex items-center justify-between group">
                                                    <span x-text="opt.label"></span>
                                                    <i class="fas fa-check text-green-500 opacity-0 group-hover:opacity-100 transition-opacity"
                                                        x-show="tipeSurat === opt.value"></i>
                                                </button>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Nama Surat <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_surat" required
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-green-500 focus:border-green-500"
                                placeholder="Masukkan nama surat">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Nomor Surat
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_surat" required
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-green-500 focus:border-green-500"
                                placeholder="Masukkan nomor surat">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Tanggal Surat <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_dibuat" required
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-green-500 focus:border-green-500">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">File Surat
                                (PDF/DOCX) <span class="text-red-500">*</span></label>
                            <input type="file" name="file_surat" accept=".pdf,.docx" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-900 dark:file:text-green-300 border border-gray-300 dark:border-gray-600 rounded-lg p-1">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Max 10MB</p>
                        </div>
                    </div>

                    <div
                        class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex justify-end space-x-3 flex-shrink-0">
                        <button type="button" onclick="closeModal('modalImportSurat')"
                            class="px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-normal transition-colors">
                            Import
                        </button>
                    </div>
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
                @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Tata Usaha'))
                    ruanganOptions: @json($ruanganOptions ?? []),
                @endif
                search: '',
                sortOption: '',
                templateFilter: '',
                ruanganFilter: '{{ request('ruangan_id') }}',
                search: '',
                sortOption: '',
                templateFilter: '',
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

            if (this.appliedStartDate) {
                data = data.filter(item => item.tanggal_dibuat.substring(0, 10) >= this.appliedStartDate);
            }
            if (this.appliedEndDate) {
                data = data.filter(item => item.tanggal_dibuat.substring(0, 10) <= this.appliedEndDate);
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
                default: return 'Filter';
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

        applyFilters() {
            let url = new URL(window.location.href);

            if (this.ruanganFilter) {
                url.searchParams.set('ruangan_id', this.ruanganFilter);
            } else {
                url.searchParams.delete('ruangan_id');
            }
            window.location.href = url.toString();
        },

                                                            get dateDisplay() {
            if (this.appliedStartDate && this.appliedEndDate) {
                return `${this.formatDate(this.appliedStartDate)} - ${this.formatDate(this.appliedEndDate)}`;
            } else if (this.appliedStartDate) {
                return this.formatDate(this.appliedStartDate);
            } else if (this.appliedEndDate) {
                return this.formatDate(this.appliedEndDate);
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
            document.getElementById('detail-nomor-surat').textContent = nomor;
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

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                ['modalDetailSurat', 'modalDeleteSurat'].forEach(id => closeModal(id));
            }
        });
    </script>
@endsection