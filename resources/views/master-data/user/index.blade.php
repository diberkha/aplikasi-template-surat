@extends('layouts.app')

@section('title', 'Data Pengguna - E-Office')

@section('content')
    <div x-data="userTable()" x-init="init()" class="space-y-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Data Pengguna</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola informasi dan pengaturan pengguna</p>
            </div>

            <div class="flex items-center space-x-3 mt-4 lg:mt-0">

                <div x-data="{ toggleFilter: false }" class="relative">
                    <button type="button" @click="toggleFilter = !toggleFilter"
                        class="flex items-center space-x-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-filter text-gray-600 dark:text-gray-400"></i>
                        <span class="text-gray-700 dark:text-gray-300" x-text="sortOrderText"></span>
                        <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300"></i>
                    </button>

                    <div x-show="toggleFilter" @click.away="toggleFilter = false" x-transition
                        class="absolute mt-2 right-0 w-40 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50">
                        <ul class="py-1">
                            <li><button @click="sortOrder='a-z'; toggleFilter=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">A-Z</button>
                            </li>
                            <li><button @click="sortOrder='z-a'; toggleFilter=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Z-A</button>
                            </li>
                            <li><button @click="sortOrder='latest'; toggleFilter=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Terbaru</button>
                            </li>
                            <li><button @click="sortOrder='oldest'; toggleFilter=false"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Terlama</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" x-model="search" placeholder="Cari pengguna..."
                        class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white w-64">
                </div>

                <button @click="openCreateModal()"
                    class="flex items-center space-x-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Pengguna</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400 mr-2"></i>
                    <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 mr-2"></i>
                    <span class="text-red-800 dark:text-red-200">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Pengguna</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                No</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Username</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nama Ruangan</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="(user, index) in paginatedUsers()" :key="user.id">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap"
                                    x-text="index + 1 + ((currentPage - 1) * itemsPerPage)"></td>
                                <td class="px-6 py-4">
                                    <span x-text="user.username"></span>
                                    <span
                                        class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200"
                                        x-show="user.id === {{ auth()->id() }}">Anda</span>
                                </td>
                                <td class="px-6 py-4" x-text="user.ruangan || 'Tidak ada ruangan'"></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <button @click="openEdit(user)"
                                            class="inline-flex items-center p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <button @click="openDelete(user)"
                                            class="inline-flex items-center p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                            x-show="user.id !== {{ auth()->id() }}">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                        <span class="inline-flex items-center p-2 text-gray-400 cursor-not-allowed"
                                            x-show="user.id === {{ auth()->id() }}">
                                            <i class="fas fa-trash text-sm"></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div
                class="px-6 py-4 bg-gray-50 dark:bg-gray-800 flex items-center justify-between border-t border-gray-200 dark:border-gray-700">

                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600 dark:text-gray-300">Items per page:</span>
                    <select x-model.number="itemsPerPage"
                        class="border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1 dark:bg-gray-700 dark:text-white">
                        <option>5</option>
                        <option>10</option>
                        <option>15</option>
                        <option>20</option>
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <button @click="prevPage()" :disabled="currentPage === 1"
                        class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <template x-for="page in pages()" :key="page">
                        <button @click="goToPage(page)"
                            class="min-w-[38px] px-3 py-1 rounded-lg border text-sm font-semibold transition-colors"
                            :class="page === currentPage
                                ? 'bg-green-600 text-white border-green-600 shadow-sm'
                                : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600'">
                            <span x-text="page"></span>
                        </button>
                    </template>

                    <button @click="nextPage()" :disabled="currentPage === totalPages"
                        class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <div class="text-sm text-gray-600 dark:text-gray-300">
                    <span x-text="startItem"></span> -
                    <span x-text="endItem"></span>
                    dari
                    <span x-text="filteredUsers().length"></span>
                </div>

            </div>
        </div>

        @include('master-data.user.partials.modal-create')
        @include('master-data.user.partials.modal-edit')
        @include('master-data.user.partials.modal-delete')
    </div>

    <script>
        function userTable() {
            return {
                search: '',
                sortOrder: null,
                users: @json($usersJs),

                itemsPerPage: 10,
                currentPage: 1,

                init() { },

                get totalPages() {
                    return Math.max(1, Math.ceil(this.filteredUsers().length / this.itemsPerPage));
                },
                pages() {
                    const total = this.totalPages;
                    if (total <= 10) return Array.from({ length: total }, (_, i) => i + 1);

                    let start = Math.max(1, this.currentPage - 4);
                    let end = start + 9;
                    if (end > total) {
                        end = total;
                        start = Math.max(1, end - 9);
                    }

                    return Array.from({ length: end - start + 1 }, (_, i) => start + i);
                },
                goToPage(page) {
                    this.currentPage = page;
                },
                pages() {
                    return Array.from({ length: this.totalPages }, (_, i) => i + 1);
                },
                goToPage(page) {
                    this.currentPage = page;
                },

                get startItem() {
                    return this.filteredUsers().length === 0 ? 0 : (this.currentPage - 1) * this.itemsPerPage + 1;
                },

                get endItem() {
                    return Math.min(this.currentPage * this.itemsPerPage, this.filteredUsers().length);
                },

                paginatedUsers() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = this.currentPage * this.itemsPerPage;
                    return this.filteredUsers().slice(start, end);
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },

                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                },

                get sortOrderText() {
                    switch (this.sortOrder) {
                        case null: return 'Filter';
                        case 'a-z': return 'A-Z';
                        case 'z-a': return 'Z-A';
                        case 'latest': return 'Terbaru';
                        case 'oldest': return 'Terlama';
                    }
                },

                filteredUsers() {
                    let result = this.users.filter(u =>
                        u.username.toLowerCase().includes(this.search.toLowerCase()) ||
                        (u.ruangan && u.ruangan.toLowerCase().includes(this.search.toLowerCase()))
                    );

                    switch (this.sortOrder) {
                        case 'a-z': return result.sort((a, b) => a.username.localeCompare(b.username));
                        case 'z-a': return result.sort((a, b) => b.username.localeCompare(a.username));
                        case 'latest': return result.sort((a, b) => b.id - a.id);
                        case 'oldest': return result.sort((a, b) => a.id - b.id);
                    }
                    return result;
                },

                openCreateModal() {
                    document.getElementById('modalCreateUser').classList.remove('hidden');
                },

                openEdit(user) {
                    this.originalUser = { ...user };
                    const modal = document.getElementById('modalEditUser');
                    modal.classList.remove('hidden');

                    document.getElementById('edit_id').value = user.id;
                    document.getElementById('edit_username').value = user.username;
                    document.getElementById('edit_id_ruangan').value = user.id_ruangan;
                    document.getElementById('password_edit').value = '';
                    document.getElementById('password_confirmation_edit').value = '';
                    document.getElementById('formEditUser').action = "{{ route('master-data.user.update', '') }}/" + user.id;
                },

                resetEditUser() {
                    document.getElementById('edit_username').value = this.originalUser.username;
                    document.getElementById('edit_id_ruangan').value = this.originalUser.id_ruangan;
                    document.getElementById('password_edit').value = '';
                    document.getElementById('password_confirmation_edit').value = '';
                },

                openDelete(user) {
                    const modal = document.getElementById('modalDeleteUser');
                    modal.classList.remove('hidden');
                    document.getElementById('delete-username').textContent = user.username;
                    document.getElementById('delete-ruangan-user').textContent = user.ruangan || 'Tidak ada ruangan';
                    document.getElementById('formDeleteUser').action = "{{ route('master-data.user.destroy', '') }}/" + user.id;
                }
            }
        }
    </script>
@endsection