@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ optional(Auth::user()->ruangan)->nama_ruangan ?? Auth::user()->username }}! 👋</h1>
            <p class="text-blue-100">Sistem E-Office - Kelola surat menyurat dengan mudah dan efisien</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Surat</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalSurat }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <i class="fas fa-folder-open text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400 overflow-hidden">
                        <i class="fas fa-info-circle flex-shrink-0"></i>
                        <span class="truncate">
                            @if(Auth::user()->hasRole('Admin'))
                                Dalam arsip sistem
                            @else
                                Dalam arsip user
                            @endif
                        </span>
                    </div>
                    <a href="{{ route('arsip-surat.index') }}" 
                       class="flex-shrink-0 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium transition-colors flex items-center gap-1">
                        Lihat <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Template Surat</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalTemplate }}</p>
                        </div>
                        <div class="p-3 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                            <i class="fas fa-copy text-indigo-600 dark:text-indigo-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2 text-sm text-indigo-600 dark:text-indigo-400 overflow-hidden">
                        <i class="fas fa-list-ul flex-shrink-0"></i>
                        <span class="truncate">Template tersedia</span>
                    </div>
                    @if(Auth::user()->hasRole(['Admin', 'Direktur', 'Tata Usaha']))
                        <a href="{{ route('template-surat.sk-direktur.index') }}" 
                           class="flex-shrink-0 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium transition-colors flex items-center gap-1">
                            Kelola <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    @else
                        <a href="{{ route('template-surat.cuti.index') }}" 
                           class="flex-shrink-0 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium transition-colors flex items-center gap-1">
                            Lihat <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Surat Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $suratHariIni }}</p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                            <i class="fas fa-plus-circle text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-start gap-3">
                    <div class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400 overflow-hidden w-full">
                        <i class="fas fa-calendar-day flex-shrink-0"></i>
                        <span class="truncate">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Surat Bulan Ini</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $suratBulanIni }}</p>
                        </div>
                        <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-lg">
                            <i class="fas fa-chart-line text-orange-600 dark:text-orange-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2 text-sm text-orange-600 dark:text-orange-400 overflow-hidden">
                        <i class="fas fa-clock flex-shrink-0"></i>
                        <span class="truncate">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                    </div>
                    <a href="{{ route('arsip-surat.index', ['start_date' => \Carbon\Carbon::now()->startOfMonth()->toDateString(), 'end_date' => \Carbon\Carbon::now()->endOfMonth()->toDateString()]) }}" 
                       class="flex-shrink-0 text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 text-sm font-medium transition-colors flex items-center gap-1">
                        Detail <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection