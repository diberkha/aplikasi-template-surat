@extends('layouts.app')

@section('title', 'Preview Surat - E-Office')

@section('content')
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h1 class="text-xl font-semibold">Preview Surat</h1>
            <div class="space-x-2">
                <button onclick="document.getElementById('pdfFrame').contentWindow.print()"
                    class="px-4 py-2 bg-blue-600 text-white rounded">Print</button>
                <a href="{{ $fileUrl }}" target="_blank" class="px-4 py-2 bg-green-600 text-white rounded">Download</a>
                <a href="{{ route('arsip-surat.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Kembali</a>
            </div>
        </div>

        <div class="bg-white rounded shadow overflow-hidden" style="height:80vh;">
            <iframe id="pdfFrame" src="{{ $fileUrl }}" frameborder="0" class="w-full h-full"></iframe>
        </div>
    </div>
@endsection