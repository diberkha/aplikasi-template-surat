@props([
    'title' => 'Template Surat',
    'subtitle' => null,
    'showSearch' => true,
    'showFilter' => true,
    'tableTitle' => 'Daftar Template Surat',
    'searchPlaceholder' => 'Cari template...'
])

@extends('layouts.app')

@section('title', $title . ' - E-Office')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
            @if ($subtitle)
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>

        @if ($showSearch || $showFilter)
            <div x-data="{
                    sortOption: '{{ request('sort') }}',
                    get sortText() {
                        switch (this.sortOption) {
                            case null: return 'Filter';
                            case 'a-z': return 'A-Z';
                            case 'z-a': return 'Z-A';
                            case 'latest': return 'Terbaru';
                            case 'oldest': return 'Terlama';
                        }
                    },
                    setSort(opt) {
                        const url = new URL(window.location.href);
                        if (!opt) {
                            url.searchParams.delete('sort');
                        } else {
                            url.searchParams.set('sort', opt);
                        }
                        window.location.href = url.toString();
                    }
                }" class="flex items-center space-x-3 mt-4 lg:mt-0">

                @if ($showFilter)
                    <div class="relative" x-data="{open:false}">
                        <button @click="open = !open" class="flex items-center space-x-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-filter text-gray-600 dark:text-gray-400"></i>
                            <span class="text-gray-700 dark:text-gray-300" x-text="sortText">Filter</span>
                        </button>

                        <div x-show="open" @click.away="open=false" x-cloak class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-20">
                            <div class="py-1">
                                <button @click.prevent="setSort(null); open=false" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200">Reset</button>
                                <button @click.prevent="setSort('a-z'); open=false" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200">A-Z</button>
                                <button @click.prevent="setSort('z-a'); open=false" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200">Z-A</button>
                                <button @click.prevent="setSort('latest'); open=false" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200">Terbaru</button>
                                <button @click.prevent="setSort('oldest'); open=false" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200">Terlama</button>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($showSearch)
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text"
                               placeholder="{{ $searchPlaceholder }}"
                               class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white w-64">
                    </div>
                @endif
            </div>
        @endif
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if ($tableTitle)
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $tableTitle }}</h3>
            </div>
        @endif

        {{ $slot }}
    </div>
</div>
@endsection
