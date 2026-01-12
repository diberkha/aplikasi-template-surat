@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="w-full max-w-md bg-white shadow-2xl rounded-2xl p-8" x-data="{ show: false }">
        <div class="text-center mb-8">
            <div class="w-20 h-20 flex items-center justify-center mx-auto mb-4">
                <img src="{{ asset('img/icon-logo-rs.png') }}" alt="Logo RS" class="w-full h-full object-contain">
            </div>
            <h2 class="text-3xl font-bold text-gray-800">E-Office</h2>
            <p class="text-gray-600 mt-2">Silakan login ke akun Anda</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <span class="text-red-700 font-medium">{{ $errors->first() }}</span>
                </div>
            </div>
        @endif

        @if (session('info'))
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    <span class="text-blue-700 font-medium">{{ session('info') }}</span>
                </div>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" name="username"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        value="{{ old('username') }}" placeholder="Masukkan username" required autofocus>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" name="password"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        placeholder="Masukkan password" required>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 font-medium transition-colors shadow-lg">
                Login
            </button>
        </form>
    </div>
@endsection