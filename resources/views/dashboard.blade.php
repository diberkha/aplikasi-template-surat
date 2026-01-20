@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <div
            class="relative overflow-hidden bg-gradient-to-r from-green-600 via-green-500 to-emerald-500 rounded-3xl p-8 text-white shadow-xl">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-green-400 opacity-20 rounded-full blur-3xl">
            </div>

            <div class="relative z-10">
                @php
                    $hour = \Carbon\Carbon::now()->hour;
                    $greeting = 'Selamat Datang';
                    if ($hour >= 5 && $hour < 11) {
                        $greeting = 'Selamat Pagi';
                    } elseif ($hour >= 11 && $hour < 15) {
                        $greeting = 'Selamat Siang';
                    } elseif ($hour >= 15 && $hour < 18) {
                        $greeting = 'Selamat Sore';
                    } else {
                        $greeting = 'Selamat Malam';
                    }
                @endphp
                <h1 class="text-3xl font-bold mb-3 tracking-tight">{{ $greeting }},
                    {{ optional(Auth::user()->ruangan)->nama_ruangan ?? Auth::user()->username }}! 👋
                </h1>
                <p class="text-green-50/90 text-lg font-medium">Sistem E-Office | Kelola surat menyurat dengan mudah, cepat
                    dan efisien</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                <div
                    class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity duration-300">
                    <i class="fas fa-folder-open text-9xl text-blue-600"></i>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total
                                Surat</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalSurat }}</p>
                        </div>
                        <div
                            class="p-4 bg-blue-50 dark:bg-blue-900/30 rounded-2xl group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50 transition-colors duration-300">
                            <i class="fas fa-folder-open text-blue-600 dark:text-blue-400 text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div
                    class="relative z-10 mt-6 pt-4 border-t border-gray-50 dark:border-gray-700 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400 font-medium">
                        <i class="fas fa-info-circle"></i>
                        <span>{{ Auth::user()->hasRole('Admin') ? 'Arsip Sistem' : 'Arsip User' }}</span>
                    </div>
                    <a href="{{ route('arsip-surat.index') }}"
                        class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-bold flex items-center gap-1 group/link">
                        Lihat <i
                            class="fas fa-arrow-right text-xs transform group-hover/link:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <div
                class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                <div
                    class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity duration-300">
                    <i class="fas fa-copy text-9xl text-indigo-600"></i>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Template Surat</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalTemplate }}</p>
                        </div>
                        <div
                            class="p-4 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/50 transition-colors duration-300">
                            <i class="fas fa-copy text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div
                    class="relative z-10 mt-6 pt-4 border-t border-gray-50 dark:border-gray-700 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2 text-sm text-indigo-600 dark:text-indigo-400 font-medium">
                        <i class="fas fa-list-ul"></i>
                        <span>Template tersedia</span>
                    </div>
                    <a href="{{ route('template-surat.cuti.index') }}"
                        class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-bold flex items-center gap-1 group/link">
                        {{ Auth::user()->hasRole(['Admin', 'Tata Usaha']) ? 'Kelola' : 'Lihat' }} <i
                            class="fas fa-arrow-right text-xs transform group-hover/link:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <div
                class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                <div
                    class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity duration-300">
                    <i class="fas fa-calendar-check text-9xl text-green-600"></i>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Surat
                                Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $suratHariIni }}</p>
                        </div>
                        <div
                            class="p-4 bg-green-50 dark:bg-green-900/30 rounded-2xl group-hover:bg-green-100 dark:group-hover:bg-green-900/50 transition-colors duration-300">
                            <i class="fas fa-plus-circle text-green-600 dark:text-green-400 text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div
                    class="relative z-10 mt-6 pt-4 border-t border-gray-50 dark:border-gray-700 flex items-center justify-start gap-3">
                    <div class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400 font-medium w-full">
                        <i class="fas fa-calendar-day"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </div>

            <div
                class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                <div
                    class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity duration-300">
                    <i class="fas fa-chart-line text-9xl text-orange-600"></i>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Surat
                                Bulan Ini</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $suratBulanIni }}</p>
                        </div>
                        <div
                            class="p-4 bg-orange-50 dark:bg-orange-900/30 rounded-2xl group-hover:bg-orange-100 dark:group-hover:bg-orange-900/50 transition-colors duration-300">
                            <i class="fas fa-chart-line text-orange-600 dark:text-orange-400 text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div
                    class="relative z-10 mt-6 pt-4 border-t border-gray-50 dark:border-gray-700 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2 text-sm text-orange-600 dark:text-orange-400 font-medium">
                        <i class="fas fa-clock"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                    </div>
                    <a href="{{ route('arsip-surat.index', ['start_date' => \Carbon\Carbon::now()->startOfMonth()->toDateString(), 'end_date' => \Carbon\Carbon::now()->endOfMonth()->toDateString()]) }}"
                        class="text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 text-sm font-bold flex items-center gap-1 group/link">
                        Detail <i
                            class="fas fa-arrow-right text-xs transform group-hover/link:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
