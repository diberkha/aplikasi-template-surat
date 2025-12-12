@props([
    'title' => 'Template Surat',
    'subtitle' => null,
    'filters' => null,
    'viewMode' => 'table',
    'viewModeToggle' => true
])

@extends('layouts.app')

@section('title', $title . ' - E-Office')

@section('content')
<div class="space-y-6">
    <x-page-header :title="$title" :description="$subtitle">
        @if($filters)
            <x-slot name="actions">
                {{ $filters }}
            </x-slot>
        @endif
    </x-page-header>

    @if($viewModeToggle)
        <div class="flex justify-end">
            <div class="inline-flex rounded-lg border border-gray-200 dark:border-gray-700 p-1">
                <button class="px-3 py-1.5 rounded-md {{ $viewMode === 'table' ? 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                    <i class="fas fa-table"></i>
                </button>
                <button class="px-3 py-1.5 rounded-md {{ $viewMode === 'grid' ? 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                    <i class="fas fa-th-large"></i>
                </button>
            </div>
        </div>
    @endif

    {{ $slot }}
</div>
@endsection
