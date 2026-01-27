@props([
    'title' => 'Template Surat',
    'subtitle' => null,
    'showSearch' => true,
    'showFilter' => true,
    'tableTitle' => 'Daftar Template Surat',
    'searchPlaceholder' => 'Cari template...',
    'count' => 0,
    'emptyMessage' => 'Belum ada data template surat'
])

@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="space-y-6" {{ $attributes }} x-data="{
    search: '',
    sortOption: '',
    items: [],
    currentPage: 1,
    itemsPerPage: 10,

    get filteredData() {
        let result = this.items.filter(i =>
            i.nama_template_surat.toLowerCase().includes(this.search.toLowerCase())
        );

        if (this.sortOption === 'a-z') {
            result.sort((a, b) => a.nama_template_surat.localeCompare(b.nama_template_surat));
        } else if (this.sortOption === 'z-a') {
            result.sort((a, b) => b.nama_template_surat.localeCompare(a.nama_template_surat));
        } else if (this.sortOption === 'latest') {
            result.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        } else if (this.sortOption === 'oldest') {
            result.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        }

        return result;
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

    goToPage(page) {
        this.currentPage = page;
    },

    get startItem() {
        return this.filteredData.length === 0 ? 0 : (this.currentPage - 1) * this.itemsPerPage + 1;
    },

    get endItem() {
        return Math.min(this.currentPage * this.itemsPerPage, this.filteredData.length);
    },

    nextPage() {
        if (this.currentPage < this.totalPages) this.currentPage++;
    },

    prevPage() {
        if (this.currentPage > 1) this.currentPage--;
    },

    get sortText() {
        switch (this.sortOption) {
            case '':
            case null: return 'Urutkan';
            case 'a-z': return 'A-Z';
            case 'z-a': return 'Z-A';
            case 'latest': return 'Terbaru';
            case 'oldest': return 'Terlama';
            default: return 'Urutkan';
        }
    },
    setSort(opt) {
        this.sortOption = opt;
        this.currentPage = 1;
    }
}">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
            @if ($subtitle)
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>

        @if ($showSearch || $showFilter)
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mt-4 lg:mt-0 w-full lg:w-auto">
                <div class="flex items-center gap-2">
                    @if ($showFilter)
                        <div class="relative flex-1 sm:flex-initial min-w-[120px]" x-data="{open:false}">
                            <button @click="open = !open" type="button"
                                class="w-full flex items-center justify-between space-x-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-filter text-gray-600 dark:text-gray-400"></i>
                                    <span class="text-gray-700 dark:text-gray-300 truncate max-w-[80px]" x-text="sortText"></span>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300 text-xs transition-transform" :class="open && 'rotate-180'"></i>
                            </button>
                            <div x-show="open" @click.away="open=false" x-cloak x-transition
                                class="absolute left-0 mt-2 w-40 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50">
                                <div class="py-1">
                                    <button @click.prevent="setSort('a-z'); open=false" class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">A-Z</button>
                                    <button @click.prevent="setSort('z-a'); open=false" class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">Z-A</button>
                                    <button @click.prevent="setSort('latest'); open=false" class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">Terbaru</button>
                                    <button @click.prevent="setSort('oldest'); open=false" class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">Terlama</button>
                                    <div class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                                        <button @click.prevent="setSort(null); open=false" class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400 text-sm">Hapus Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($showSearch)
                    <div class="relative flex-1 sm:w-64 lg:w-72">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-xs"></i>
                        </div>
                        <input type="text"
                               x-model="search"
                               placeholder="{{ $searchPlaceholder }}"
                               class="pl-9 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white w-full text-sm transition-all">
                    </div>
                @endif
            </div>
        @endif
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if ($count > 0)
            @if ($tableTitle)
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $tableTitle }}</h3>
                </div>
            @endif

            {{ $slot }}
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                <h6 class="text-base font-medium text-gray-600 dark:text-gray-400">{{ $emptyMessage }}</h6>
            </div>
        @endif
    </div>
</div>
@endsection
