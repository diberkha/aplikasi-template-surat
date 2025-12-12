@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ optional(Auth::user()->ruangan)->nama_ruangan ?? Auth::user()->username }}! 👋</h1>
            <p class="text-blue-100">Sistem E-Office - Kelola surat menyurat dengan mudah dan efisien</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Surat</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalSurat }}</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                        <i class="fas fa-envelope text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between text-sm text-green-600">
                    <span class="flex items-center"><i class="fas fa-chart-line mr-1"></i> Semua surat dalam sistem</span>
                    <a href="{{ route('arsip-surat.index') }}" class="text-green-700 dark:text-green-400 font-medium hover:underline">Lihat</a>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Jumlah Template Surat</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalTemplate }}</p>
                    </div>
                    <div class="p-3 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                        <i class="fas fa-file-alt text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between text-sm text-green-600">
                    <span class="flex items-center"><i class="fas fa-layer-group mr-1"></i> Template tersedia</span>
                    <a href="{{ route('template-surat.hukum.index') }}" class="text-indigo-600 dark:text-indigo-300 font-medium hover:underline">Kelola</a>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Surat Dibuat Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $suratHariIni }}</p>
                    </div>
                    <div class="p-3 bg-emerald-100 dark:bg-emerald-900 rounded-lg">
                        <i class="fas fa-file-signature text-emerald-600 dark:text-emerald-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-green-600">
                    <i class="fas fa-calendar-day mr-1"></i>
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Surat Tersimpan</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $suratTersimpan }}</p>
                    </div>
                    <div class="p-3 bg-amber-100 dark:bg-amber-900 rounded-lg">
                        <i class="fas fa-archive text-amber-600 dark:text-amber-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between text-sm text-amber-600">
                    <span class="flex items-center"><i class="fas fa-database mr-1"></i> Dalam arsip sistem</span>
                    <a href="{{ route('arsip-surat.index') }}" class="text-amber-700 dark:text-amber-400 font-medium hover:underline">Arsip</a>
                </div>
            </div>
        </div>
    </div>
@endsection