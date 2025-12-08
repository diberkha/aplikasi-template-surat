<!DOCTYPE html>
<html lang="en" x-data="themeHandler()" x-bind:class="dark ? 'dark' : ''">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Office')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script src="{{ asset('js/global-helpers.js') }}"></script>

    <script>
        tailwind.config = { darkMode: 'class' }
    </script>

    <style>
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
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300 min-h-screen">

    <nav
        class="h-16 bg-white dark:bg-gray-800 shadow-lg flex items-center justify-between px-4 md:px-6 sticky top-0 z-50">
        <div class="flex items-center space-x-3 md:space-x-4">
            <button @click="sidebar = true; backdrop = true"
                class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors md:hidden">
                <i class="fas fa-bars text-gray-600 dark:text-gray-300 text-lg"></i>
            </button>

            <button @click="sidebar = !sidebar"
                class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors hidden md:block">
                <i class="fas fa-bars text-gray-600 dark:text-gray-300"></i>
            </button>

            <div class="font-bold text-lg md:text-xl text-blue-600 dark:text-blue-400 truncate">E-Office</div>
        </div>

        <div class="flex items-center space-x-2 md:space-x-4">
            <button @click="toggleDarkMode()"
                class="p-2 md:p-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors relative">
                <i x-show="!dark" class="fas fa-sun text-yellow-500 text-base md:text-lg"></i>
                <i x-show="dark" class="fas fa-moon text-blue-400 text-base md:text-lg"></i>
                <div x-show="darkModeTransition"
                    class="absolute inset-0 bg-white dark:bg-gray-800 rounded-lg opacity-0 animate-ping"
                    style="display: none;"></div>
            </button>

            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow">
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

    <div x-show="backdrop && sidebar" x-transition class="sidebar-backdrop md:hidden"
        @click="sidebar = false; backdrop = false"></div>

    <div class="flex min-h-[calc(100vh-4rem)]">
        <aside x-show="sidebar" x-transition
            class="bg-white dark:bg-gray-800 shadow-xl md:shadow border-r border-gray-200 dark:border-gray-700 overflow-y-auto fixed top-16 left-0 bottom-0 z-40 w-64 md:sticky md:top-16 md:z-auto">

            <nav class="p-4 space-y-1">

                <a href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 py-3 px-4 rounded-xl transition-all group
                   {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-900/20 border-r-2 border-blue-600 text-blue-600 dark:text-blue-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <i class="fas fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>

                <div x-data="{ open: {{ request()->routeIs('template-surat.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full py-3 px-4 rounded-xl transition-all
                        {{ request()->routeIs('template-surat.*') ? 'bg-blue-50 dark:bg-blue-900/20 border-r-2 border-blue-600 text-blue-600 dark:text-blue-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope w-5"></i>
                            <span>Template Surat</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs" :class="open ? 'rotate-180':''"></i>
                    </button>

                    <div x-show="open" x-transition
                        class="ml-6 space-y-1 border-l border-gray-200 dark:border-gray-700 pl-2">

                        <a href="{{ route('template-surat.hukum.index') }}"
                            class="flex items-center space-x-3 py-2 px-3 rounded-lg
                            {{ request()->routeIs('template-surat.hukum.index') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-balance-scale w-4"></i>
                            <span>Surat Hukum & Kerja Sama</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('arsip-surat.index') }}"
                    class="flex items-center space-x-3 py-3 px-4 rounded-xl transition-all
                   {{ request()->routeIs('arsip-surat*') ? 'bg-blue-50 dark:bg-blue-900/20 border-r-2 border-blue-600 text-blue-600 dark:text-blue-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <i class="fas fa-archive w-5"></i>
                    <span>Arsip Surat</span>
                </a>

                <div x-data="{ open: {{ request()->routeIs('master-data.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full py-3 px-4 rounded-xl transition-all
                        {{ request()->routeIs('master-data.*') ? 'bg-blue-50 dark:bg-blue-900/20 border-r-2 border-blue-600 text-blue-600 dark:text-blue-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-database w-5"></i>
                            <span>Master Data</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs" :class="open ? 'rotate-180':''"></i>
                    </button>

                    <div x-show="open" x-transition
                        class="ml-6 space-y-1 border-l border-gray-200 dark:border-gray-700 pl-2">

                        <a href="{{ route('master-data.user.index') }}"
                            class="flex items-center space-x-3 py-2 px-3 rounded-lg
                            {{ request()->routeIs('master-data.user.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-users w-4"></i>
                            <span>User</span>
                        </a>

                        <a href="{{ route('master-data.ruangan.index') }}"
                            class="flex items-center space-x-3 py-2 px-3 rounded-lg
                            {{ request()->routeIs('master-data.ruangan.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-door-open w-4"></i>
                            <span>Ruangan</span>
                        </a>

                    </div>
                </div>

                <a href="{{ route('regulasi.index') }}"
                    class="flex items-center space-x-3 py-3 px-4 rounded-xl transition-all
                    {{ request()->routeIs('regulasi*') ? 'bg-blue-50 dark:bg-blue-900/20 border-r-2 border-blue-600 text-blue-600 dark:text-blue-400 font-medium' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <i class="fas fa-file w-5"></i>
                    <span>Regulasi</span>
                </a>

            </nav>
        </aside>

        <main class="flex-1 p-4 md:p-6 transition-all duration-300 w-full">
            @yield('content')
        </main>
    </div>

    <!-- Global Notification Toast -->
    <div id="globalNotification" class="hidden fixed top-4 right-4 z-[9999] max-w-md">
        <div id="notificationContent" class="rounded-lg shadow-2xl p-4 flex items-start space-x-3 transform transition-all duration-300">
            <div id="notificationIcon" class="flex-shrink-0 mt-0.5"></div>
            <div class="flex-1">
                <p id="notificationTitle" class="font-semibold text-sm"></p>
                <p id="notificationMessage" class="text-sm mt-1"></p>
            </div>
            <button onclick="closeNotification()" class="flex-shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <script>
        // Global Notification System
        function showNotification(type, title, message, autoClose = true) {
            const notification = document.getElementById('globalNotification');
            const content = document.getElementById('notificationContent');
            const icon = document.getElementById('notificationIcon');
            const titleEl = document.getElementById('notificationTitle');
            const messageEl = document.getElementById('notificationMessage');

            // Set content
            titleEl.textContent = title;
            messageEl.textContent = message;

            // Set style based on type
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
                content.className = 'rounded-lg shadow-2xl p-4 flex items-start space-x-3 transform transition-all duration-300 bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500';
                icon.innerHTML = '<i class="fas fa-info-circle text-2xl text-blue-600 dark:text-blue-400"></i>';
                titleEl.className = 'font-semibold text-sm text-blue-800 dark:text-blue-200';
                messageEl.className = 'text-sm mt-1 text-blue-700 dark:text-blue-300';
            }

            // Show notification
            notification.classList.remove('hidden');
            setTimeout(() => {
                content.style.transform = 'translateX(0)';
            }, 10);

            // Auto close after 5 seconds
            if (autoClose) {
                setTimeout(() => {
                    closeNotification();
                }, 5000);
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

        // Check for session flash messages on page load
        document.addEventListener('DOMContentLoaded', function() {
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
                sidebar: window.innerWidth >= 768,
                backdrop: false,
                darkModeTransition: false,

                init() {
                    this.checkDarkModePreference();
                    if (window.innerWidth < 768) this.sidebar = false;
                    window.addEventListener('resize', this.handleResize.bind(this));
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (!localStorage.getItem('dark-theme')) {
                            this.dark = e.matches;
                            this.updateDarkMode();
                        }
                    });
                },

                handleResize() {
                    if (window.innerWidth >= 768) {
                        this.sidebar = true;
                        this.backdrop = false;
                    } else {
                        this.sidebar = false;
                        this.backdrop = false;
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