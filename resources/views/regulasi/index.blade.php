@extends('layouts.app')

@section('title', 'Regulasi - E-Office')

@section('content')
    <div class="space-y-6" x-data="regulasi()" x-init="init()">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Regulasi</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola regulasi yang menjadi dasar penyusunan setiap
                    template surat</p>
            </div>

            <div class="flex items-center space-x-3 mt-4 lg:mt-0">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" placeholder="Cari regulasi..." x-model="search"
                        x-on:input.debounce.300ms="filterRegulasi()"
                        class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white w-64">
                </div>

                <button onclick="openModal('modalCreate')"
                    class="flex items-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Regulasi</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <div>
                        <p class="text-green-800 dark:text-green-200 font-medium">Berhasil!</p>
                        <p class="text-green-700 dark:text-green-300 text-sm mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <div>
                        <p class="text-red-800 dark:text-red-200 font-medium">Terjadi kesalahan!</p>
                        <ul class="text-red-700 dark:text-red-300 text-sm mt-1 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Regulasi</h3>
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
                                Nama Surat</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tipe Surat</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Menimbang</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Mengingat</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tanggal Dibuat</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($regulasis as $index => $regulasi)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900 dark:text-white font-medium">{{ $index + 1 }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg mr-3">
                                            <i class="fas fa-file-alt text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        <div>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-white block">{{ $regulasi->surat->nama_surat ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeColor = [
                                            'Surat Hukum & Kerja Sama' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        ][$regulasi->template->nama_template_surat ?? ''] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }}">
                                        {{ $regulasi->template->nama_template_surat ?? 'Tidak ada tipe surat' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 dark:text-gray-300 max-w-xs">
                                        <div class="line-clamp-3">
                                            {{ $regulasi->menimbang }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 dark:text-gray-300 max-w-xs">
                                        <div class="line-clamp-3">
                                            {{ $regulasi->mengingat }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="text-sm text-gray-600 dark:text-gray-400">{{ $regulasi->formattedCreatedAt }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="showDetail({{ $regulasi->id_regulasi }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/30 transition-colors"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye text-sm"></i>
                                        </button>

                                        <button onclick="openDeleteRegulasi(
                                            {{ $regulasi->id_regulasi }}, 
                                            '{{ addslashes($regulasi->surat->nama_surat ?? 'N/A') }}', 
                                            '{{ addslashes($regulasi->template->nama_template_surat ?? 'N/A') }}', 
                                            '{{ $regulasi->formattedCreatedAt }}', 
                                            '{{ addslashes(Str::limit($regulasi->menimbang, 100)) }}'
                                        )" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/30 transition-colors"
                                            title="Hapus Regulasi">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <div
                                            class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                                            <i class="fas fa-inbox text-2xl"></i>
                                        </div>
                                        <p class="text-lg font-medium text-gray-700 dark:text-gray-300">Belum ada data regulasi
                                        </p>
                                        <p class="text-sm mt-1 text-gray-500 dark:text-gray-400">Klik "Tambah Regulasi" untuk
                                            menambahkan data pertama</p>
                                        <button onclick="openModal('modalCreate')"
                                            class="mt-4 inline-flex items-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                            <i class="fas fa-plus"></i>
                                            <span>Tambah Regulasi</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($regulasis->count() > 0)
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 dark:text-gray-300">Items per page:</span>
                            <select x-model.number="itemsPerPage" @change="currentPage = 1; update()"
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

                            <button @click="nextPage()" :disabled="currentPage === totalPages"
                                class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="text-sm text-gray-600 dark:text-gray-300">
                            <span x-text="startItem"></span> -
                            <span x-text="endItem"></span>
                            dari
                            <span x-text="filteredCount"></span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('regulasi.partials.modal-create')
    @include('regulasi.partials.modal-detail')
    @include('regulasi.partials.modal-edit')
    @include('regulasi.partials.modal-delete')

    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('regulasi', () => ({
                search: '',
                itemsPerPage: 10,
                currentPage: 1,
                rows: [],
                filteredCount: 0,

                init() {
                    const container = document.querySelector('[x-data="regulasi()"]') || document;
                    this.rows = Array.from(container.querySelectorAll('tbody tr'));
                    this.update();
                },

                get totalPages() {
                    return Math.max(1, Math.ceil(this.getFilteredRows().length / this.itemsPerPage));
                },

                get startItem() {
                    return this.filteredCount === 0 ? 0 : (this.currentPage - 1) * this.itemsPerPage + 1;
                },

                get endItem() {
                    return Math.min(this.currentPage * this.itemsPerPage, this.filteredCount);
                },

                getFilteredRows() {
                    const searchTerm = this.search.toLowerCase();
                    return this.rows.filter(row => {
                        const text = row.textContent.toLowerCase();
                        return text.includes(searchTerm);
                    });
                },

                update() {
                    const all = this.rows;
                    const filtered = this.getFilteredRows();
                    this.filteredCount = filtered.length;

                    all.forEach(r => r.style.display = 'none');

                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    filtered.slice(start, end).forEach(r => r.style.display = '');
                },

                filterRegulasi() {
                    this.currentPage = 1;
                    this.update();
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                        this.update();
                    }
                },

                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                        this.update();
                    }
                }
            }));
        });

        let currentRegulasiId = null;

        async function getRegulasiDetail(id) {
            try {
                const response = await fetch(`/regulasi/detail/${id}`);
                const result = await response.json();

                if (result.success) {
                    return result.data;
                } else {
                    throw new Error('Gagal mengambil data');
                }
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        }

        async function showDetail(id) {
            try {
                currentRegulasiId = id;
                const data = await getRegulasiDetail(id);

                const detailContent = document.getElementById('detailContent');
                detailContent.innerHTML = `
                <div class="space-y-6">
                    <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">${data.nama_surat}</h2>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${data.badge_color}">
                                ${data.tipe_surat}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Dibuat Oleh</p>
                                <p class="font-medium text-gray-900 dark:text-white mt-1">${data.created_by}</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Dibuat</p>
                                <p class="font-medium text-gray-900 dark:text-white mt-1">${data.created_at}</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Terakhir Diubah</p>
                                <p class="font-medium text-gray-900 dark:text-white mt-1">${data.updated_at}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Menimbang</h3>
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-medium rounded">
                                    Pertimbangan
                                </span>
                            </div>
                            <div class="whitespace-pre-line text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 p-4 rounded-lg">
                                ${data.menimbang}
                            </div>
                            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                Berisi pertimbangan hukum atau dasar penyusunan regulasi
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mengingat</h3>
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-medium rounded">
                                    Acuan
                                </span>
                            </div>
                            <div class="whitespace-pre-line text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 p-4 rounded-lg">
                                ${data.mengingat}
                            </div>
                            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                <i class="fas fa-book mr-2"></i>
                                Berisi peraturan atau ketentuan yang menjadi acuan
                            </div>
                        </div>
                    </div>
                </div>
            `;

                document.getElementById('editButton').classList.remove('hidden');

                openModal('modalDetail');
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('detailContent').innerHTML = `
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                        <i class="fas fa-exclamation-triangle text-2xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Gagal Memuat Detail</h3>
                    <p class="text-gray-600 dark:text-gray-400">Terjadi kesalahan saat memuat data regulasi. Silakan coba lagi.</p>
                    <button onclick="closeModal('modalDetail')"
                            class="mt-4 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Tutup
                    </button>
                </div>
            `;
                document.getElementById('editButton').classList.add('hidden');
                openModal('modalDetail');
            }
        }

        function openDeleteRegulasi(id, namaSurat, tipeSurat, tanggalDibuat, previewMenimbang) {
            document.getElementById('delete-nama-surat').textContent = namaSurat;
            document.getElementById('delete-tipe-surat').textContent = tipeSurat;
            document.getElementById('delete-tanggal-dibuat').textContent = tanggalDibuat;
            document.getElementById('delete-preview-menimbang').textContent = previewMenimbang;

            const form = document.getElementById('formDeleteRegulasi');
            form.action = `/regulasi/${id}`;

            openModal('modalDeleteRegulasi');
        }

        async function openEditModal(id) {
            try {
                currentRegulasiId = id;

                const response = await fetch(`/regulasi/edit-data/${id}`);
                const result = await response.json();

                if (result.success) {
                    const regulasi = result.data.regulasi;
                    const surats = result.data.surats;

                    originalRegulasiData = {
                        id_template_surat: regulasi.id_template_surat,
                        id_surat: regulasi.id_surat,
                        menimbang: regulasi.menimbang,
                        mengingat: regulasi.mengingat
                    };

                    document.getElementById('editIdRegulasi').value = regulasi.id_regulasi;
                    document.getElementById('editTemplateSurat').value = regulasi.id_template_surat;
                    document.getElementById('editMenimbang').value = regulasi.menimbang;
                    document.getElementById('editMengingat').value = regulasi.mengingat;

                    const editMenimbang = document.getElementById('editMenimbang');
                    const editMengingat = document.getElementById('editMengingat');
                    const editMenimbangCounter = document.getElementById('editMenimbangCounter');
                    const editMengingatCounter = document.getElementById('editMengingatCounter');

                    if (editMenimbang && editMenimbangCounter) {
                        updateCounter(editMenimbang, editMenimbangCounter);
                    }
                    if (editMengingat && editMengingatCounter) {
                        updateCounter(editMengingat, editMengingatCounter);
                    }

                    document.getElementById('editRegulasiForm').action = `/regulasi/${regulasi.id_regulasi}`;

                    const suratSelect = document.getElementById('editSurat');
                    suratSelect.innerHTML = '<option value="">-- Pilih Surat --</option>';

                    surats.forEach(surat => {
                        const option = document.createElement('option');
                        option.value = surat.id_surat;
                        option.textContent = surat.nama_surat;
                        if (surat.id_surat == regulasi.id_surat) {
                            option.selected = true;
                        }
                        suratSelect.appendChild(option);
                    });

                    suratSelect.disabled = false;

                    openModal('modalEdit');
                } else {
                    throw new Error('Gagal mengambil data untuk edit');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal memuat data untuk edit');
            }
        }

        async function getSuratForEdit() {
            const templateId = document.getElementById('editTemplateSurat').value;
            const suratSelect = document.getElementById('editSurat');

            if (!templateId) {
                suratSelect.innerHTML = '<option value="">-- Pilih Template Surat --</option>';
                suratSelect.disabled = true;
                return;
            }

            suratSelect.innerHTML = '<option value="">Memuat data surat...</option>';
            suratSelect.disabled = true;

            try {
                const response = await fetch(`/regulasi/get-surat/${templateId}`);
                const data = await response.json();

                suratSelect.innerHTML = '<option value="">-- Pilih Surat --</option>';

                data.forEach(surat => {
                    const option = document.createElement('option');
                    option.value = surat.id_surat;
                    option.textContent = surat.nama_surat;
                    suratSelect.appendChild(option);
                });

                suratSelect.disabled = false;

            } catch (error) {
                console.error('Error:', error);
                suratSelect.innerHTML = '<option value="">Error loading data</option>';
                suratSelect.disabled = false;
            }
        }

        function editRegulasi() {
            if (currentRegulasiId) {
                closeModal('modalDetail');

                openEditModal(currentRegulasiId);
            }
        }

        function resetEditRegulasi() {
            if (originalRegulasiData) {
                document.getElementById('editTemplateSurat').value = originalRegulasiData.id_template_surat;
                document.getElementById('editMenimbang').value = originalRegulasiData.menimbang;
                document.getElementById('editMengingat').value = originalRegulasiData.mengingat;

                const editMenimbang = document.getElementById('editMenimbang');
                const editMengingat = document.getElementById('editMengingat');
                const editMenimbangCounter = document.getElementById('editMenimbangCounter');
                const editMengingatCounter = document.getElementById('editMengingatCounter');

                if (editMenimbang && editMenimbangCounter) {
                    updateCounter(editMenimbang, editMenimbangCounter);
                }
                if (editMengingat && editMengingatCounter) {
                    updateCounter(editMengingat, editMengingatCounter);
                }

                getSuratForEdit();
            }
        }

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function getSuratByTemplate() {
            const templateId = document.getElementById('template_surat').value;
            const suratSelect = document.getElementById('surat');

            if (!templateId) {
                suratSelect.innerHTML = '<option value="">-- Pilih Template Surat terlebih dahulu --</option>';
                suratSelect.disabled = true;
                return;
            }

            suratSelect.innerHTML = '<option value="">Memuat data surat...</option>';
            suratSelect.disabled = true;

            fetch(`/regulasi/get-surat/${templateId}`)
                .then(response => response.json())
                .then(data => {
                    suratSelect.innerHTML = '<option value="">-- Pilih Surat --</option>';

                    if (data.length === 0) {
                        suratSelect.innerHTML += '<option value="" disabled>Tidak ada surat untuk template ini</option>';
                    } else {
                        data.forEach(surat => {
                            const option = document.createElement('option');
                            option.value = surat.id_surat;
                            option.textContent = surat.nama_surat;
                            suratSelect.appendChild(option);
                        });
                    }
                    suratSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    suratSelect.innerHTML = '<option value="">Error loading data</option>';
                    suratSelect.disabled = false;
                });
        }

        function updateCounter(textarea, counter) {
            const len = textarea.value.length;
            if (counter) {
                counter.textContent = `${len} karakter`;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const menimbang = document.getElementById('menimbang');
            const mengingat = document.getElementById('mengingat');
            const menimbangCounter = document.getElementById('menimbangCounter');
            const mengingatCounter = document.getElementById('mengingatCounter');

            if (menimbang && menimbangCounter) {
                updateCounter(menimbang, menimbangCounter);
                menimbang.addEventListener('input', () => updateCounter(menimbang, menimbangCounter));
            }

            if (mengingat && mengingatCounter) {
                updateCounter(mengingat, mengingatCounter);
                mengingat.addEventListener('input', () => updateCounter(mengingat, mengingatCounter));
            }

            const templateSelect = document.getElementById('template_surat');
            if (templateSelect) {
                templateSelect.addEventListener('change', getSuratByTemplate);
            }

            const editMenimbang = document.getElementById('editMenimbang');
            const editMengingat = document.getElementById('editMengingat');
            const editMenimbangCounter = document.getElementById('editMenimbangCounter');
            const editMengingatCounter = document.getElementById('editMengingatCounter');

            if (editMenimbang && editMenimbangCounter) {
                editMenimbang.addEventListener('input', function () {
                    updateCounter(this, editMenimbangCounter);
                });
            }

            if (editMengingat && editMengingatCounter) {
                editMengingat.addEventListener('input', function () {
                    updateCounter(this, editMengingatCounter);
                });
            }

            document.addEventListener('keydown', function (e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    const searchInput = document.querySelector('input[placeholder="Cari regulasi..."]');
                    if (searchInput) searchInput.focus();
                }
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeModal('modalCreate');
                closeModal('modalDetail');
                closeModal('modalEdit');
                closeModal('modalDeleteRegulasi');
            }
        });

        document.addEventListener('click', function (event) {
            const modals = ['modalCreate', 'modalDetail', 'modalEdit', 'modalDeleteRegulasi'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal && event.target === modal) {
                    closeModal(modalId);
                }
            });
        });
    </script>
@endsection