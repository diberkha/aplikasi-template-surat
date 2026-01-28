<!DOCTYPE html>
<html lang="en" x-data="themeHandler()" x-bind:class="dark ? 'dark' : ''">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | E-Office</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('img/icon-logo-rs.png') }}">
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script src="{{ asset('js/global-helpers.js') }}"></script>

    <script>
        tailwind.config = { darkMode: 'class' }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        html,
        body {
            height: 100%;
        }

        html {
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }

        :root {
            --sidebar-width: 256px;
            --sidebar-collapsed-width: 80px;
        }

        body:not(.alpine-ready) nav,
        body:not(.alpine-ready) main {
            opacity: 0;
        }

        body.alpine-ready nav,
        body.alpine-ready main {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .sidebar-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }

            button,
            a {
                min-height: 44px;
                min-width: 44px;
            }
        }

        .sidebar-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        .dark .sidebar-scrollbar {
            scrollbar-color: #4b5563 #1f2937;
        }

        .sidebar-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .dark .sidebar-scrollbar::-webkit-scrollbar-track {
            background: #1f2937;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 2px;
        }

        .dark .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: #4b5563;
        }

        nav,
        aside,
        main {
            transition: margin-left 300ms cubic-bezier(0.4, 0, 0.2, 1),
                width 300ms cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        * {
            transition-property: margin-left, margin-right, width, padding-left, padding-right;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        button,
        a,
        input,
        textarea,
        select {
            transition-property: background-color, color, border-color, box-shadow !important;
        }

        .custom-scrollbar-x {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        .custom-scrollbar-x::-webkit-scrollbar {
            height: 4px;
        }

        .custom-scrollbar-x::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar-x::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 2px;
        }

        .dark .custom-scrollbar-x::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
    </style>
</head>

<body
    class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300 min-h-screen flex flex-col"
    style="scrollbar-gutter: stable;" x-cloak>

    <nav class="h-20 bg-white dark:bg-gray-800 shadow-lg flex items-center justify-between pl-4 pr-4 md:pl-6 md:pr-6 sticky top-0 z-50 flex-shrink-0"
        x-bind:style="isDesktop ? 'margin-left:' + (sidebarCollapsed ? '80px' : '256px') + '; width: calc(100% - ' + (sidebarCollapsed ? '80px' : '256px') + ');' : ''">
        <div class="flex items-center">
            <button @click="sidebarOpen = true; backdrop = true"
                class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors md:hidden">
                <i class="fas fa-bars text-gray-600 dark:text-gray-300 text-lg"></i>
            </button>

            <button @click="sidebarCollapsed = !sidebarCollapsed"
                class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors hidden md:block"
                :title="sidebarCollapsed ? 'Expand Sidebar' : 'Collapse Sidebar'">
                <i class="fas fa-bars text-gray-600 dark:text-gray-300"></i>
            </button>
        </div>

        <div class="flex items-center space-x-2 md:space-x-4">
            <button @click="toggleDarkMode()"
                class="p-2 md:p-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors relative">
                <i x-show="!dark" class="far fa-sun text-gray-600 text-base md:text-lg"></i>
                <i x-show="dark" class="far fa-moon text-gray-100 text-base md:text-lg"></i>
                <div x-show="darkModeTransition"
                    class="absolute inset-0 bg-white dark:bg-gray-800 rounded-lg opacity-0 animate-ping"
                    style="display: none;"></div>
            </button>

            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <span class="font-medium hidden sm:block">{{ Auth::user()->ruangan->nama_ruangan ?? 'User' }}</span>
                    <i class="fas fa-chevron-down text-sm hidden sm:block" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-transition @click.outside="open = false"
                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 shadow-xl rounded-xl py-2 z-50 border border-gray-200 dark:border-gray-700 backdrop-blur-sm">
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <p class="font-semibold truncate">{{ Auth::user()->ruangan->nama_ruangan }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->username }}</p>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <i class="fas fa-sign-out-alt mr-3 w-5"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div x-show="backdrop && sidebarOpen" x-transition class="sidebar-backdrop md:hidden"
        @click="sidebarOpen = false; backdrop = false" :class="sidebarOpen ? 'sidebar-open' : ''"></div>

    <div class="flex flex-1 pt-20 md:pt-0">
        <aside x-show="isDesktop || sidebarOpen" x-transition :class="[
                sidebarCollapsed && isDesktop ? 'w-16 md:w-20 overflow-visible' : 'w-64 md:w-64 overflow-y-auto',
                'bg-white dark:bg-gray-800 shadow-xl md:shadow border-r border-gray-200 dark:border-gray-700 fixed left-0 z-40'
            ]" x-bind:style="isDesktop
                ? { top: '0px', height: '100vh' }
                : { top: '80px', height: 'calc(100vh - 80px)' }">

            <div class="flex items-center p-4 border-b border-gray-200 dark:border-gray-700 space-x-3 h-20"
                :class="sidebarCollapsed && isDesktop ? 'justify-center' : ''">
                <img src="{{ asset('img/logo-rs.png') }}" alt="Logo RS" class="h-12 object-contain">
            </div>

            <nav class="p-4 space-y-1">

                <a href="{{ route('dashboard') }}"
                    class="flex items-center py-3 rounded-xl transition-all group
                   {{ request()->routeIs('dashboard') ? 'bg-green-50 dark:bg-green-900/20 border-r-2 border-green-600 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                    :class="sidebarCollapsed && isDesktop ? 'justify-center px-3' : 'space-x-3 px-4'">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span x-show="!sidebarCollapsed || !isDesktop" x-transition>Dashboard</span>
                </a>

                <div x-data="{ open: {{ request()->routeIs('template-surat.*') ? 'true' : 'false' }}, flyout: false }"
                    class="space-y-1 relative">
                    <button @click.prevent="sidebarCollapsed && isDesktop ? flyout = !flyout : open = !open"
                        class="flex items-center justify-between w-full py-3 rounded-xl transition-all
                        {{ request()->routeIs('template-surat.*') ? 'bg-green-50 dark:bg-green-900/20 border-r-2 border-green-600 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        :class="sidebarCollapsed && isDesktop ? 'px-3' : 'px-4'">
                        <div class="flex items-center"
                            :class="sidebarCollapsed && isDesktop ? 'justify-center w-full' : 'space-x-3'">
                            <i class="fas fa-envelope-open-text w-5 text-center"></i>
                            <span x-show="!sidebarCollapsed || !isDesktop" x-transition>Buat Surat</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs" x-show="!sidebarCollapsed || !isDesktop"
                            :class="open ? 'rotate-180':''"></i>
                    </button>

                    <div x-show="open && (!sidebarCollapsed || !isDesktop)" x-transition
                        class="ml-6 space-y-1 border-l border-gray-200 dark:border-gray-700 pl-2">

                        <a href="{{ route('template-surat.sop.index') }}"
                            class="flex items-center space-x-3 py-2 px-3 rounded-lg
                            {{ request()->routeIs('template-surat.sop.index') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-clipboard-list w-4 text-center"></i>
                            <span>Standar Operasional Prosedur (SOP)</span>
                        </a>

                        <a href="{{ route('template-surat.cuti.index') }}"
                            class="flex items-center space-x-3 py-2 px-3 rounded-lg
                            {{ request()->routeIs('template-surat.cuti.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-calendar-check w-4 text-center"></i>
                            <span>Surat Izin Cuti</span>
                        </a>

                        @if(Auth::user()->hasRole(['Admin', 'Tata Usaha']))
                            <a href="{{ route('template-surat.sk-direktur.index') }}"
                                class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                    {{ request()->routeIs('template-surat.sk-direktur.index') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-scroll w-4 text-center"></i>
                                <span>Surat Keputusan Direktur</span>
                            </a>
                        @endif
                    </div>

                    <div x-show="flyout && sidebarCollapsed && isDesktop" x-transition.origin.left
                        @click.outside="flyout = false"
                        class="absolute left-full top-0 ml-3 w-64 bg-white dark:bg-gray-800 shadow-xl border border-gray-200 dark:border-gray-700 rounded-xl p-3 space-y-1 z-50">
                        <a href="{{ route('template-surat.sop.index') }}"
                            class="flex items-center space-x-3 py-2 px-3 rounded-lg
                            {{ request()->routeIs('template-surat.sop.index') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-clipboard-list w-4 text-center"></i>
                            <span> Standar Operasional Prosedur (SOP)</span>
                        </a>

                        <a href="{{ route('template-surat.cuti.index') }}"
                            class="flex items-center space-x-3 py-2 px-3 rounded-lg
                            {{ request()->routeIs('template-surat.cuti.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-calendar-check w-4 text-center"></i>
                            <span>Surat Izin Cuti</span>
                        </a>

                        @if(Auth::user()->hasRole(['Admin', 'Tata Usaha']))
                            <a href="{{ route('template-surat.sk-direktur.index') }}"
                                class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                    {{ request()->routeIs('template-surat.sk-direktur.index') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-scroll w-4 text-center"></i>
                                <span>Surat Keputusan Direktur</span>
                            </a>
                        @endif
                    </div>
                </div>

                <div x-data="{ open: {{ request()->routeIs('draft-surat.*') ? 'true' : 'false' }}, flyout: false }"
                    class="space-y-1 relative">
                    <button @click.prevent="sidebarCollapsed && isDesktop ? flyout = !flyout : open = !open"
                        class="flex items-center justify-between w-full py-3 rounded-xl transition-all
                        {{ request()->routeIs('draft-surat.*') ? 'bg-green-50 dark:bg-green-900/20 border-r-2 border-green-600 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        :class="sidebarCollapsed && isDesktop ? 'px-3' : 'px-4'">
                        <div class="flex items-center"
                            :class="sidebarCollapsed && isDesktop ? 'justify-center w-full' : 'space-x-3'">
                            <i class="fas fa-file-signature w-5 text-center"></i>
                            <span x-show="!sidebarCollapsed || !isDesktop" x-transition>Draft Surat</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs" x-show="!sidebarCollapsed || !isDesktop"
                            :class="open ? 'rotate-180':''"></i>
                    </button>

                    <div x-show="open && (!sidebarCollapsed || !isDesktop)" x-transition
                        class="ml-6 space-y-1 border-l border-gray-200 dark:border-gray-700 pl-2">

                        <a href="{{ route('draft-surat.sop.index') }}"
                            class="flex items-center space-x-3 py-2 px-3 rounded-lg
                            {{ request()->routeIs('draft-surat.sop.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-clipboard-list w-4 text-center"></i>
                            <span>Standar Operasional Prosedur (SOP)</span>
                        </a>

                        <a href="{{ route('draft-surat.cuti.index') }}"
                            class="flex items-center space-x-3 py-2 px-3 rounded-lg
                            {{ request()->routeIs('draft-surat.cuti.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-calendar-check w-4 text-center"></i>
                            <span>Surat Izin Cuti</span>
                        </a>

                        @if(Auth::user()->hasRole(['Admin', 'Tata Usaha']))
                            <a href="{{ route('draft-surat.sk-direktur.index') }}"
                                class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                {{ request()->routeIs('draft-surat.sk-direktur.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-scroll w-4 text-center"></i>
                                <span>Surat Keputusan Direktur</span>
                            </a>
                        @endif
                    </div>

                    <div x-show="flyout && sidebarCollapsed && isDesktop" x-transition.origin.left
                        @click.outside="flyout = false"
                        class="absolute left-full top-0 ml-3 w-64 bg-white dark:bg-gray-800 shadow-xl border border-gray-200 dark:border-gray-700 rounded-xl p-3 space-y-1 z-50">

                        <a href="{{ route('draft-surat.sop.index') }}"
                            class="flex items-center space-x-3 py-2 px-3 rounded-lg
                            {{ request()->routeIs('draft-surat.sop.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-clipboard-list w-4 text-center"></i>
                            <span>Standar Operasional Prosedur (SOP)</span>
                        </a>

                        @if(Auth::user()->hasRole(['Admin', 'Tata Usaha']))
                            <a href="{{ route('draft-surat.sk-direktur.index') }}"
                                class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                {{ request()->routeIs('draft-surat.sk-direktur.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-scroll w-4 text-center"></i>
                                <span>Surat Keputusan Direktur</span>
                            </a>
                        @endif

                        <a href="{{ route('draft-surat.cuti.index') }}"
                            class="flex items-center space-x-3 py-2 px-3 rounded-lg
                            {{ request()->routeIs('draft-surat.cuti.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-calendar-check w-4 text-center"></i>
                            <span>Surat Izin Cuti</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('arsip-surat.index') }}"
                    class="flex items-center py-3 rounded-xl transition-all
                   {{ request()->routeIs('arsip-surat*') ? 'bg-green-50 dark:bg-green-900/20 border-r-2 border-green-600 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                    :class="sidebarCollapsed && isDesktop ? 'justify-center px-3' : 'space-x-3 px-4'">
                    <i class="fas fa-archive w-5 text-center"></i>
                    <span x-show="!sidebarCollapsed || !isDesktop" x-transition>Arsip Surat</span>
                </a>

                @if(Auth::user()->hasRole(['Admin', 'Tata Usaha']))
                    <div x-data="{ open: {{ request()->routeIs('master-data.*') ? 'true' : 'false' }}, flyout: false }"
                        class="space-y-1 relative">
                        <button @click.prevent="sidebarCollapsed && isDesktop ? flyout = !flyout : open = !open"
                            class="flex items-center justify-between w-full py-3 rounded-xl transition-all
                                                {{ request()->routeIs('master-data.*') ? 'bg-green-50 dark:bg-green-900/20 border-r-2 border-green-600 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                            :class="sidebarCollapsed && isDesktop ? 'px-3' : 'px-4'">
                            <div class="flex items-center"
                                :class="sidebarCollapsed && isDesktop ? 'justify-center w-full' : 'space-x-3'">
                                <i class="fas fa-database w-5 text-center"></i>
                                <span x-show="!sidebarCollapsed || !isDesktop" x-transition>Master Data</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs" x-show="!sidebarCollapsed || !isDesktop"
                                :class="open ? 'rotate-180':''"></i>
                        </button>

                        <div x-show="open && (!sidebarCollapsed || !isDesktop)" x-transition
                            class="ml-6 space-y-1 border-l border-gray-200 dark:border-gray-700 pl-2">

                            <a href="{{ route('cuti-bersama.index') }}"
                                class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                    {{ request()->routeIs('cuti-bersama.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-calendar-days w-4 text-center"></i>
                                <span>Cuti Bersama</span>
                            </a>

                            @if(Auth::user()->hasRole('Admin'))
                                <a href="{{ route('master-data.jabatan.index') }}"
                                    class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                                            {{ request()->routeIs('master-data.jabatan.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <i class="fas fa-briefcase w-4 text-center"></i>
                                    <span>Jabatan</span>
                                </a>
                            @endif

                            <a href="{{ route('master-data.pegawai.index') }}"
                                class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                    {{ request()->routeIs('master-data.pegawai.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-id-card w-4 text-center"></i>
                                <span>Pegawai</span>
                            </a>

                            <a href="{{ route('master-data.regulasi.index') }}"
                                class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                    {{ request()->routeIs('master-data.regulasi.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-file w-4 text-center"></i>
                                <span>Regulasi</span>
                            </a>

                            @if(Auth::user()->hasRole('Admin'))
                                <a href="{{ route('master-data.ruangan.index') }}"
                                    class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                                            {{ request()->routeIs('master-data.ruangan.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <i class="fas fa-door-open w-4 text-center"></i>
                                    <span>Ruangan</span>
                                </a>

                                <a href="{{ route('master-data.unit.index') }}"
                                    class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                                            {{ request()->routeIs('master-data.unit.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <i class="fas fa-layer-group w-4 text-center"></i>
                                    <span>Unit</span>
                                </a>

                                <a href="{{ route('master-data.user.index') }}"
                                    class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                                            {{ request()->routeIs('master-data.user.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <i class="fas fa-users w-4 text-center"></i>
                                    <span>User</span>
                                </a>
                            @endif
                        </div>

                        <div x-show="flyout && sidebarCollapsed && isDesktop" x-transition.origin.left
                            @click.outside="flyout = false"
                            class="absolute left-full top-0 ml-3 w-64 bg-white dark:bg-gray-800 shadow-xl border border-gray-200 dark:border-gray-700 rounded-xl p-3 space-y-1 z-50">

                            <a href="{{ route('cuti-bersama.index') }}"
                                class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                    {{ request()->routeIs('cuti-bersama.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-calendar-days w-4 text-center"></i>
                                <span>Cuti Bersama</span>
                            </a>

                            @if(Auth::user()->hasRole('Admin'))
                                <a href="{{ route('master-data.jabatan.index') }}"
                                    class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                                            {{ request()->routeIs('master-data.jabatan.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <i class="fas fa-briefcase w-4 text-center"></i>
                                    <span>Jabatan</span>
                                </a>
                            @endif

                            <a href="{{ route('master-data.pegawai.index') }}"
                                class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                    {{ request()->routeIs('master-data.pegawai.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-id-card w-4 text-center"></i>
                                <span>Pegawai</span>
                            </a>

                            <a href="{{ route('master-data.regulasi.index') }}"
                                class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                    {{ request()->routeIs('master-data.regulasi.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-file w-4 text-center"></i>
                                <span>Regulasi</span>
                            </a>

                            @if(Auth::user()->hasRole('Admin'))
                                <a href="{{ route('master-data.ruangan.index') }}"
                                    class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                                            {{ request()->routeIs('master-data.ruangan.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <i class="fas fa-door-open w-4 text-center"></i>
                                    <span>Ruangan</span>
                                </a>

                                <a href="{{ route('master-data.unit.index') }}"
                                    class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                                            {{ request()->routeIs('master-data.unit.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <i class="fas fa-layer-group w-4 text-center"></i>
                                    <span>Unit</span>
                                </a>

                                <a href="{{ route('master-data.user.index') }}"
                                    class="flex items-center space-x-3 py-2 px-3 rounded-lg
                                                                            {{ request()->routeIs('master-data.user.*') ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <i class="fas fa-users w-4 text-center"></i>
                                    <span>User</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </nav>
        </aside>

        <main class="flex-1 pt-4 px-4 pb-0 md:pt-6 md:px-6 md:pb-0 transition-all duration-300 w-full flex flex-col"
            x-bind:style="isDesktop
                ? { marginLeft: sidebarCollapsed ? '80px' : '256px', width: 'calc(100% - ' + (sidebarCollapsed ? '80px' : '256px') + ')' }
                : { marginLeft: '0', width: '100%' }">
            <div class="flex-1">
                @yield('content')
            </div>

            <footer class="flex-shrink-0 pt-16 pb-6">
                <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                    &copy; 2025 <span class="text-green-600 dark:text-green-400 font-semibold">RSUD dr. Soeratno
                        Gemolong</span>. All rights reserved.
                </p>
            </footer>
        </main>
    </div>

    <div id="globalNotification" class="hidden fixed top-4 right-4 z-[9999] max-w-md">
        <div id="notificationContent"
            class="rounded-lg shadow-2xl p-4 flex items-start space-x-3 transform transition-all duration-300">
            <div id="notificationIcon" class="flex-shrink-0 mt-0.5"></div>
            <div class="flex-1">
                <p id="notificationTitle" class="font-semibold text-sm"></p>
                <p id="notificationMessage" class="text-sm mt-1"></p>
            </div>
            <button onclick="closeNotification()"
                class="flex-shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <script>
        function showNotification(type, title, message, autoClose = true) {
            const notification = document.getElementById('globalNotification');
            const content = document.getElementById('notificationContent');
            const icon = document.getElementById('notificationIcon');
            const titleEl = document.getElementById('notificationTitle');
            const messageEl = document.getElementById('notificationMessage');

            titleEl.textContent = title;
            messageEl.textContent = message;

            if (type === 'success') {
                content.className = 'rounded-lg shadow-2xl p-4 flex items-start space-x-3 transform transition-all duration-300 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500';
                icon.innerHTML = '<i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>';
                titleEl.className = 'font-semibold text-sm text-green-800 dark:text-green-200';
                messageEl.className = 'text-sm mt-1 text-green-700 dark:text-green-300';
            } else if (type === 'error') {
                content.className = 'rounded-lg shadow-2xl p-4 flex items-start space-x-3 transform transition-all duration-300 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500';
                icon.innerHTML = '<i class="fas fa-exclamation-circle text-2xl text-red-600 dark:text-red-400"></i>';
                titleEl.className = 'font-semibold text-sm text-red-800 dark:text-red-200';
                messageEl.className = 'text-sm mt-1 text-red-700 dark:text-red-300';
            } else if (type === 'warning') {
                content.className = 'rounded-lg shadow-2xl p-4 flex items-start space-x-3 transform transition-all duration-300 bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-500';
                icon.innerHTML = '<i class="fas fa-exclamation-triangle text-2xl text-yellow-600 dark:text-yellow-400"></i>';
                titleEl.className = 'font-semibold text-sm text-yellow-800 dark:text-yellow-200';
                messageEl.className = 'text-sm mt-1 text-yellow-700 dark:text-yellow-300';
            } else if (type === 'info') {
                content.className = 'rounded-lg shadow-2xl p-4 flex items-start space-x-3 transform transition-all duration-300 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500';
                icon.innerHTML = '<i class="fas fa-info-circle text-2xl text-green-600 dark:text-green-400"></i>';
                titleEl.className = 'font-semibold text-sm text-green-800 dark:text-green-200';
                messageEl.className = 'text-sm mt-1 text-green-700 dark:text-green-300';
            }

            notification.classList.remove('hidden');
            setTimeout(() => {
                content.style.transform = 'translateX(0)';
            }, 10);

            if (autoClose) {
                setTimeout(() => {
                    closeNotification();
                }, 10000);
            }
        }

        function closeNotification() {
            const notification = document.getElementById('globalNotification');
            const content = document.getElementById('notificationContent');
            content.style.transform = 'translateX(120%)';
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 300);
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                showNotification('success', 'Berhasil!', '{{ session('success') }}');
            @endif

            @if(session('error'))
                showNotification('error', 'Error!', '{{ session('error') }}');
            @endif

            @if(session('warning'))
                showNotification('warning', 'Peringatan!', '{{ session('warning') }}');
            @endif

            @if(session('info'))
                showNotification('info', 'Informasi', '{{ session('info') }}');
            @endif

            @if ($errors->any())
                showNotification('error', 'Validasi Gagal', '{{ $errors->first() }}');
            @endif
        });
    </script>

    <script>
        function themeHandler() {
            return {
                dark: false,
                sidebarOpen: window.innerWidth >= 768,
                sidebarCollapsed: localStorage.getItem('sidebar-collapsed') === 'true',
                backdrop: false,
                isDesktop: window.innerWidth >= 768,
                darkModeTransition: false,

                init() {
                    this.checkDarkModePreference();
                    this.isDesktop = window.innerWidth >= 768;
                    this.sidebarOpen = this.isDesktop;

                    const savedCollapsed = localStorage.getItem('sidebar-collapsed');
                    if (savedCollapsed !== null) {
                        this.sidebarCollapsed = savedCollapsed === 'true';
                    }

                    setTimeout(() => document.body.classList.add('alpine-ready'), 50);

                    window.addEventListener('resize', this.handleResize.bind(this));
                    window.addEventListener('modal-state-changed', () => {
                        this.updateScrollLock();
                    });

                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (!localStorage.getItem('dark-theme')) {
                            this.dark = e.matches;
                            this.updateDarkMode();
                        }
                    });

                    this.$watch('sidebarCollapsed', value => {
                        localStorage.setItem('sidebar-collapsed', value);
                    });

                    this.$watch('sidebarOpen', value => {
                        this.updateScrollLock();
                    });
                },

                handleResize() {
                    const wasDesktop = this.isDesktop;
                    this.isDesktop = window.innerWidth >= 768;

                    if (!wasDesktop && this.isDesktop) {
                        this.sidebarOpen = true;
                        this.backdrop = false;
                    } else if (wasDesktop && !this.isDesktop) {
                        this.sidebarOpen = false;
                        this.backdrop = false;
                        this.sidebarCollapsed = false;
                    }
                    this.updateScrollLock();
                },

                updateScrollLock() {
                    const hasOpenModal = typeof isAnyModalOpen === 'function' && isAnyModalOpen();
                    const isMobileSidebarOpen = !this.isDesktop && this.sidebarOpen;

                    if (isMobileSidebarOpen || hasOpenModal) {
                        document.body.classList.add('overflow-hidden');
                    } else {
                        document.body.classList.remove('overflow-hidden');
                    }

                    if (isMobileSidebarOpen) {
                        document.body.classList.add('sidebar-open');
                    } else {
                        document.body.classList.remove('sidebar-open');
                    }
                },

                checkDarkModePreference() {
                    const saved = localStorage.getItem('dark-theme');
                    if (saved === 'true') this.dark = true;
                    else if (saved === 'false') this.dark = false;
                    else this.dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    this.updateDarkMode();
                },

                toggleDarkMode() {
                    this.darkModeTransition = true;
                    this.dark = !this.dark;
                    this.updateDarkMode();
                    setTimeout(() => this.darkModeTransition = false, 600);
                },

                updateDarkMode() {
                    localStorage.setItem('dark-theme', this.dark);
                    document.documentElement.classList.toggle('dark', this.dark);
                    window.dispatchEvent(new CustomEvent('darkModeChanged', { detail: { dark: this.dark } }));
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const saved = localStorage.getItem('dark-theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'true' || (!saved && systemDark)) document.documentElement.classList.add('dark');
            if ('ontouchstart' in window) document.documentElement.classList.add('touch-device');
        });
    </script>

</body>

</html>