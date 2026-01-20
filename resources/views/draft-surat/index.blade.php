@extends('layouts.app')

@section('title', 'Draft Surat')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Draft Surat</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                Kelola draft surat sebelum dipublikasikan ke arsip.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="{{ route('draft-surat.cuti.index') }}"
                class="block bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                        <i class="fas fa-calendar-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Surat Izin Cuti</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola draft pengajuan cuti</p>
                    </div>
                </div>
            </a>

<a href="{{ route('draft-surat.sk-direktur.index') }}"
                class="block bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg text-purple-600 dark:text-purple-400">
                        <i class="fas fa-file-signature text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">SK Direktur</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola draft SK Direktur</p>
                    </div>
                </div>
            </a>

<a href="{{ route('draft-surat.sop.index') }}"
                class="block bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg text-green-600 dark:text-green-400">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">SOP</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola draft SOP</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
