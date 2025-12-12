@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('content')
    <div class="space-y-6" x-data="arsipSurat()">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Arsip Surat</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Total {{ $totalSurat }} surat tersimpan dalam sistem
                </p>
            </div>

            <div class="flex items-center space-x-3 mt-4 lg:mt-0">
                <div x-data="{ toggleFilter: false }" class="relative">
                    <button type="button" @click="toggleFilter = !toggleFilter"
                        class="flex items-center space-x-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-filter text-gray-600 dark:text-gray-400"></i>
                        <span class="text-gray-700 dark:text-gray-300">Template</span>
                        <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300"></i>
                    </button>

                    <div x-show="toggleFilter" @click.away="toggleFilter = false" x-transition
                        class="absolute mt-2 right-0 w-56 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50">
                        <ul class="py-1">
                            <li>
                                <button type="button" onclick="setTemplateFilter('')"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Semua
                                    Template</button>
                            </li>
                            @foreach($templateOptions as $template)
                                <li>
                                    <button type="button" onclick="setTemplateFilter('{{ $template->id_template_surat }}')"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">{{ $template->nama_template_surat }}</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div x-data="{ toggleDate: false }" class="relative">
                    <button type="button" @click="toggleDate = !toggleDate"
                        class="flex items-center space-x-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-calendar-alt text-gray-600 dark:text-gray-400"></i>
                        <span class="text-gray-700 dark:text-gray-300">Tanggal</span>
                        <i class="fas fa-chevron-down text-gray-400 dark:text-gray-300"></i>
                    </button>

                    <div x-show="toggleDate" @click.away="toggleDate = false" x-transition
                        class="absolute mt-2 right-0 w-56 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-50 p-4">
                        <div class="space-y-2">
                            <label class="block text-xs text-gray-500 dark:text-gray-400">Tanggal Mulai</label>
                            <input type="date" id="simpleStartDate" value="{{ request('start_date') }}"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm" />

                            <label class="block text-xs text-gray-500 dark:text-gray-400">Tanggal Akhir</label>
                            <input type="date" id="simpleEndDate" value="{{ request('end_date') }}"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm" />

                            <div class="flex space-x-2 pt-2">
                                <button type="button"
                                    onclick="setDateFilter(document.getElementById('simpleStartDate').value, document.getElementById('simpleEndDate').value)"
                                    class="flex-1 px-3 py-1.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700">Terapkan</button>
                                <button type="button" onclick="clearDateFilter()"
                                    class="flex-1 px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="searchInput" placeholder="Cari surat..." value="{{ request('search') }}"
                        class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white w-64">
                </div>
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

        @if(isset($debugRecent) && $debugRecent)
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg mt-4">
                <div class="mb-2 font-medium text-yellow-800">Debug: Recent Surat (for diagnosis)</div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-gray-600">
                            <th class="pb-2">ID</th>
                            <th class="pb-2">Nama Surat</th>
                            <th class="pb-2">Nomor</th>
                            <th class="pb-2">Tanggal</th>
                            <th class="pb-2">Have SKDirektur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($debugRecent as $d)
                            <tr class="border-t">
                                <td class="py-2">{{ $d->id_surat }}</td>
                                <td class="py-2">{{ $d->nama_surat }}</td>
                                <td class="py-2">{{ $d->nomor_surat }}</td>
                                <td class="py-2">{{ optional($d->tanggal_dibuat)->format('Y-m-d') }}</td>
                                <td class="py-2">{{ $d->skDirektur ? 'yes' : 'no' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

        @if(request()->hasAny(['search', 'template', 'start_date', 'end_date']))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-sm text-blue-800 dark:text-blue-300 font-medium">Filter aktif:</span>

                    @if(request()->has('search'))
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Pencarian: "{{ request('search') }}"
                            <a href="{{ route('arsip-surat.index', request()->except('search')) }}"
                                class="ml-1.5 text-blue-600 hover:text-blue-800">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif

                    @if(request()->has('template') && $selectedTemplate = $templateOptions->firstWhere('id_template_surat', request('template')))
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                            Template: {{ $selectedTemplate->nama_template_surat }}
                            <a href="{{ route('arsip-surat.index', request()->except('template')) }}"
                                class="ml-1.5 text-purple-600 hover:text-purple-800">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif

                    @if(request()->has('start_date') || request()->has('end_date'))
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Tanggal:
                            @if(request()->has('start_date') && request()->has('end_date'))
                                {{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d M Y') }} -
                                {{ \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d M Y') }}
                            @elseif(request()->has('start_date'))
                                Dari {{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d M Y') }}
                            @else
                                Hingga {{ \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d M Y') }}
                            @endif
                            <a href="{{ route('arsip-surat.index', request()->except(['start_date', 'end_date'])) }}"
                                class="ml-1.5 text-blue-600 hover:text-blue-800">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif

                    <a href="{{ route('arsip-surat.index') }}"
                        class="ml-auto text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <i class="fas fa-times mr-1"></i>
                        Hapus semua filter
                    </a>
                </div>
            </div>
        @endif

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Surat</h3>
            </div>

            @if($totalSurat > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tipe Surat</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nama Surat</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nomor Surat</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tanggal Dibuat</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"
                            id="suratTableBody">
                            @foreach($surat as $index => $item)
                                @php
                                    $idSurat = is_object($item) ? $item->id_surat : ($item['id_surat'] ?? '');
                                    $namaSurat = is_object($item) ? $item->nama_surat : ($item['nama_surat'] ?? '');
                                    $nomorSurat = is_object($item) ? $item->nomor_surat : ($item['nomor_surat'] ?? '');
                                    $tipeSurat = is_object($item) ? $item->tipe_surat : ($item['tipe_surat'] ?? '');
                                    $tanggalDibuat = is_object($item) ? $item->tanggal_dibuat : ($item['tanggal_dibuat'] ?? '');
                                    $dibuatOleh = is_object($item) ? ($item->createdBy->username ?? ($item->created_by ?? 'Unknown')) : ($item['username'] ?? 'Unknown');
                                    $filePath = is_object($item) ? $item->file_path : ($item['file_path'] ?? '');

                                    $badgeColor = [
                                        'Surat Hukum & Kerja Sama' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    ][$tipeSurat] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900 dark:text-white font-medium">{{ $index + 1 }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }}">
                                            {{ $tipeSurat }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $namaSurat }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $nomorSurat }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($tanggalDibuat)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <button type="button" onclick="showDetailSurat(
                                                '{{ $idSurat }}',
                                                '{{ addslashes($namaSurat) }}',
                                                '{{ addslashes($nomorSurat) }}',
                                                '{{ addslashes($tipeSurat) }}',
                                                '{{ $tanggalDibuat }}',
                                                '{{ addslashes($dibuatOleh) }}',
                                                '{{ $filePath }}'
                                            )"
                                                class="inline-flex items-center p-1.5 text-purple-500 hover:text-purple-600 dark:text-purple-400 dark:hover:text-purple-300 transition-colors">
                                                <i class="fas fa-eye text-sm"></i>
                                            </button>

                                            @if($filePath)
                                                <a href="{{ route('arsip-surat.download', $idSurat) }}"
                                                    class="inline-flex items-center p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                                    <i class="fas fa-download text-sm"></i>
                                                </a>
                                            @else
                                                <a href="#"
                                                    class="inline-flex items-center p-1.5 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-400 transition-colors"
                                                    onclick="alert('File surat tidak tersedia untuk diunduh')">
                                                    <i class="fas fa-download text-sm"></i>
                                                </a>
                                            @endif

                                            <button type="button"
                                                onclick="openDeleteModal({{ $idSurat }}, '{{ addslashes($namaSurat) }}', '{{ addslashes($nomorSurat) }}', '{{ addslashes($tipeSurat) }}')"
                                                class="inline-flex items-center p-1.5 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 dark:text-gray-300">Items per page:</span>
                            <select id="arsipItemsPerPage" onchange="arsipSetItemsPerPage(this.value)"
                                class="border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1 dark:bg-gray-700 dark:text-white">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                            </select>
                        </div>

                        <div class="flex items-center space-x-2">
                            <button id="arsipPrevBtn" onclick="arsipPrev()"
                                class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40">
                                <i class="fas fa-chevron-left"></i>
                            </button>

                            <div id="arsipPageButtons" class="flex items-center space-x-2"></div>

                            <button id="arsipNextBtn" onclick="arsipNext()"
                                class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            <span id="arsipStart">0</span> - <span id="arsipEnd">0</span> dari <span id="arsipTotal">0</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada surat</h3>
                    <p class="text-gray-500 dark:text-gray-400">
                        @if(request()->hasAny(['search', 'template', 'start_date', 'end_date']))
                            Tidak ada surat yang sesuai dengan filter yang dipilih.
                        @else
                            Surat yang dibuat akan muncul di sini.
                        @endif
                    </p>

                    @if(request()->hasAny(['search', 'template', 'start_date', 'end_date']))
                        <a href="{{ route('arsip-surat.index') }}"
                            class="inline-flex items-center px-4 py-2 mt-4 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            Tampilkan Semua Surat
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>

    <div id="modalDeleteSurat"
        class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-red-600 dark:text-red-400">Konfirmasi Hapus Surat</h3>
                <button onclick="closeModal('modalDeleteSurat')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6">
                <p class="text-gray-600 dark:text-gray-400 mb-4">Apakah Anda yakin ingin menghapus surat ini?</p>
                <div class="mt-4 bg-red-50 dark:bg-red-900/20 p-4 rounded-lg border border-red-200 dark:border-red-800">
                    <p class="text-sm mb-2">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Nama Surat:</span>
                        <span id="delete-nama-surat" class="text-gray-800 dark:text-gray-200">-</span>
                    </p>
                    <p class="text-sm mb-2">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Nomor Surat:</span>
                        <span id="delete-nomor-surat" class="text-gray-800 dark:text-gray-200">-</span>
                    </p>
                    <p class="text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Tipe Surat:</span>
                        <span id="delete-tipe-surat" class="text-gray-800 dark:text-gray-200">-</span>
                    </p>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                <button type="button" onclick="closeModal('modalDeleteSurat')"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    Batal
                </button>
                <form id="formDeleteSurat" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus Surat
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('arsip-surat.partials.modal-detail')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('arsipSurat', () => ({
                toggleFilter: false,
                init() { }
            }));
        });

        function showDetailSurat(idSurat, nama, nomor, tipe, tanggal, dibuatOleh, filePath) {
            const formatDate = (dateString) => {
                if (!dateString) return '-';
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            };

            document.getElementById('detail-nama-surat').textContent = nama;
            document.getElementById('detail-nomor-surat').textContent = nomor;
            document.getElementById('detail-tanggal-dibuat').textContent = formatDate(tanggal);
            document.getElementById('detail-dibuat-oleh').textContent = dibuatOleh;

            const tipeBadge = {
                'Surat Hukum & Kerja Sama': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            }[tipe] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';

            document.getElementById('detail-tipe-surat').innerHTML =
                `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${tipeBadge}">
                ${tipe}
            </span>`;

            if (filePath && filePath !== '') {
                document.getElementById('detail-file-exists').classList.remove('hidden');
                document.getElementById('detail-no-file').classList.add('hidden');
                document.getElementById('detail-download-dropdown').classList.remove('hidden');

                const fileName = filePath.split('/').pop();
                document.getElementById('detail-file-nama').textContent = fileName;

                document.getElementById('detail-download-pdf').href = `/arsip-surat/${idSurat}/download`;
                
                document.getElementById('detail-pdf-preview').src = `/arsip-surat/${idSurat}`;
            } else {
                document.getElementById('detail-file-exists').classList.add('hidden');
                document.getElementById('detail-no-file').classList.remove('hidden');
                document.getElementById('detail-download-dropdown').classList.add('hidden');
            }

            const modal = document.getElementById('modalDetailSurat');
            modal.dataset.suratId = idSurat;
            modal.classList.remove('hidden');
        }

        function downloadAsWord() {
            const suratId = document.getElementById('modalDetailSurat').dataset.suratId;
            if (!suratId) {
                alert('ID surat tidak ditemukan');
                return;
            }
            
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = `/arsip-surat/${suratId}/download-word`;
            form.style.display = 'none';
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

        function downloadAsRTF() {
            const suratId = document.getElementById('modalDetailSurat').dataset.suratId;
            if (!suratId) {
                alert('ID surat tidak ditemukan');
                return;
            }
            
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = `/arsip-surat/${suratId}/download-rtf`;
            form.style.display = 'none';
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function openDeleteModal(id, namaSurat, nomorSurat, tipeSurat) {
            document.getElementById('delete-nama-surat').textContent = namaSurat;
            document.getElementById('delete-nomor-surat').textContent = nomorSurat;
            document.getElementById('delete-tipe-surat').textContent = tipeSurat;
            document.getElementById('formDeleteSurat').action = `/arsip-surat/${id}`;
            document.getElementById('modalDeleteSurat').classList.remove('hidden');
        }

        let arsipSearchTimeout;
        let arsipItemsPerPage = 10;
        let arsipCurrentPage = 1;

        function renderArsipPagination() {
            const rows = Array.from(document.querySelectorAll('#suratTableBody tr'));
            const matched = rows.filter(r => r.dataset.match === '1');
            const total = matched.length;
            const totalPages = Math.max(1, Math.ceil(total / arsipItemsPerPage));

            if (arsipCurrentPage > totalPages) arsipCurrentPage = totalPages;

            const start = total === 0 ? 0 : (arsipCurrentPage - 1) * arsipItemsPerPage + 1;
            const end = Math.min(arsipCurrentPage * arsipItemsPerPage, total);

            rows.forEach(r => r.style.display = 'none');
            matched.slice(start - 1, end).forEach(r => r.style.display = '');

            const startEl = document.getElementById('arsipStart');
            const endEl = document.getElementById('arsipEnd');
            const totalEl = document.getElementById('arsipTotal');
            const pageButtonsEl = document.getElementById('arsipPageButtons');
            if (startEl) startEl.textContent = start;
            if (endEl) endEl.textContent = end;
            if (totalEl) totalEl.textContent = total;

            if (pageButtonsEl) {
                pageButtonsEl.innerHTML = '';

                const getPages = () => {
                    if (totalPages <= 10) return Array.from({ length: totalPages }, (_, i) => i + 1);

                    let start = Math.max(1, arsipCurrentPage - 4);
                    let end = start + 9;
                    if (end > totalPages) {
                        end = totalPages;
                        start = Math.max(1, end - 9);
                    }
                    return Array.from({ length: end - start + 1 }, (_, i) => start + i);
                };

                getPages().forEach(p => {
                    const btn = document.createElement('button');
                    btn.textContent = p;
                    btn.className = 'min-w-[38px] px-3 py-1 rounded-lg border text-sm font-semibold transition-colors';
                    if (p === arsipCurrentPage) {
                        btn.classList.add('bg-green-600', 'text-white', 'border-green-600', 'shadow-sm');
                    } else {
                        btn.classList.add('bg-white', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-100', 'border-gray-300', 'dark:border-gray-600', 'hover:bg-gray-100', 'dark:hover:bg-gray-600');
                    }
                    btn.addEventListener('click', () => {
                        arsipCurrentPage = p;
                        renderArsipPagination();
                    });
                    pageButtonsEl.appendChild(btn);
                });
            }

            const prevBtn = document.getElementById('arsipPrevBtn');
            const nextBtn = document.getElementById('arsipNextBtn');
            if (prevBtn) prevBtn.disabled = arsipCurrentPage === 1;
            if (nextBtn) nextBtn.disabled = arsipCurrentPage >= totalPages;
        }

        function arsipSetItemsPerPage(val) {
            arsipItemsPerPage = parseInt(val) || 10;
            arsipCurrentPage = 1;
            renderArsipPagination();
        }

        function arsipNext() {
            const rows = Array.from(document.querySelectorAll('#suratTableBody tr'));
            const total = rows.filter(r => r.dataset.match === '1').length;
            const totalPages = Math.max(1, Math.ceil(total / arsipItemsPerPage));
            if (arsipCurrentPage < totalPages) {
                arsipCurrentPage++;
                renderArsipPagination();
            }
        }

        function arsipPrev() {
            if (arsipCurrentPage > 1) {
                arsipCurrentPage--;
                renderArsipPagination();
            }
        }

        function setTemplateFilter(value) {
            const url = new URL(window.location.href);
            if (value === '' || value === null) {
                url.searchParams.delete('template');
            } else {
                url.searchParams.set('template', value);
            }
            window.location.href = url.toString();
        }

        function setDateFilter(start, end) {
            const url = new URL(window.location.href);
            if (start) {
                url.searchParams.set('start_date', start);
            } else {
                url.searchParams.delete('start_date');
            }

            if (end) {
                url.searchParams.set('end_date', end);
            } else {
                url.searchParams.delete('end_date');
            }

            window.location.href = url.toString();
        }

        function clearDateFilter() {
            const url = new URL(window.location.href);
            url.searchParams.delete('start_date');
            url.searchParams.delete('end_date');
            window.location.href = url.toString();
        }

        document.getElementById('searchInput').addEventListener('input', function (e) {
            clearTimeout(arsipSearchTimeout);
            const input = e.target;
            arsipSearchTimeout = setTimeout(() => {
                const searchValue = input.value.toLowerCase();
                const rows = Array.from(document.querySelectorAll('#suratTableBody tr'));
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const namaSurat = (cells[2]?.textContent || '').toLowerCase();
                    const nomorSurat = (cells[3]?.textContent || '').toLowerCase();
                    const tipeSurat = (cells[1]?.textContent || '').toLowerCase();
                    const dibuatOleh = (cells[5]?.textContent || '').toLowerCase();

                    const shouldShow =
                        namaSurat.includes(searchValue) ||
                        nomorSurat.includes(searchValue) ||
                        tipeSurat.includes(searchValue) ||
                        dibuatOleh.includes(searchValue);

                    row.dataset.match = shouldShow ? '1' : '0';
                });

                arsipCurrentPage = 1;
                renderArsipPagination();
            }, 300);
        });

        document.getElementById('searchInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                const searchValue = this.value;
                const currentUrl = new URL(window.location.href);

                if (searchValue) {
                    currentUrl.searchParams.set('search', searchValue);
                } else {
                    currentUrl.searchParams.delete('search');
                }

                window.location.href = currentUrl.toString();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeModal('modalDetailSurat');
                closeModal('modalDeleteSurat');
            }
        });

        document.getElementById('modalDetailSurat').addEventListener('click', function (event) {
            if (event.target === this) {
                closeModal('modalDetailSurat');
            }
        });

        document.getElementById('modalDeleteSurat').addEventListener('click', function (event) {
            if (event.target === this) {
                closeModal('modalDeleteSurat');
            }
        });

        function loadFlatpickr() {
            return new Promise((resolve, reject) => {
                if (window.flatpickr) {
                    resolve();
                    return;
                }

                if (!document.querySelector('link[href*="flatpickr.min.css"]')) {
                    const link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css';
                    document.head.appendChild(link);
                }

                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/flatpickr';
                script.onload = () => {
                    const idScript = document.createElement('script');
                    idScript.src = 'https://npmcdn.com/flatpickr/dist/l10n/id.js';
                    idScript.onload = resolve;
                    idScript.onerror = reject;
                    document.head.appendChild(idScript);
                };
                script.onerror = reject;
                document.head.appendChild(script);
            });
        }

        let flatpickrInstance = null;

        document.addEventListener('alpine:init', () => {
            Alpine.data('dateFilter', () => ({
                open: false,
                init() {
                    this.$watch('open', (value) => {
                        if (value && !flatpickrInstance) {
                            this.initFlatpickr();
                        }
                    });
                },
                async initFlatpickr() {
                    try {
                        await loadFlatpickr();

                        const rangeEl = document.querySelector('#flatpickrRange');
                        if (!rangeEl) {
                            updateDateRangeDisplay();
                            return;
                        }

                        flatpickrInstance = flatpickr(rangeEl, {
                            mode: "range",
                            locale: "id",
                            dateFormat: "Y-m-d",
                            defaultDate: [
                                @if(request()->has('start_date')) "{{ request('start_date') }}" @endif,
                                @if(request()->has('end_date')) "{{ request('end_date') }}" @endif
                        ],
                            onChange: function (selectedDates, dateStr, instance) {
                                if (selectedDates.length === 2) {
                                    const [startDate, endDate] = selectedDates;
                                    document.getElementById('flatpickrStartDate').value =
                                        flatpickrInstance.formatDate(startDate, "Y-m-d");
                                    document.getElementById('flatpickrEndDate').value =
                                        flatpickrInstance.formatDate(endDate, "Y-m-d");

                                    const startDisplay = startDate.toLocaleDateString('id-ID', {
                                        day: 'numeric',
                                        month: 'short',
                                        year: 'numeric'
                                    });
                                    const endDisplay = endDate.toLocaleDateString('id-ID', {
                                        day: 'numeric',
                                        month: 'short',
                                        year: 'numeric'
                                    });
                                    document.getElementById('dateRangeDisplay').textContent =
                                        `${startDisplay} - ${endDisplay}`;
                                } else if (selectedDates.length === 1) {
                                    document.getElementById('flatpickrStartDate').value =
                                        flatpickrInstance.formatDate(selectedDates[0], "Y-m-d");
                                    document.getElementById('flatpickrEndDate').value = '';

                                    const startDisplay = selectedDates[0].toLocaleDateString('id-ID', {
                                        day: 'numeric',
                                        month: 'short',
                                        year: 'numeric'
                                    });
                                    document.getElementById('dateRangeDisplay').textContent =
                                        `Dari ${startDisplay}`;
                                }
                            }
                        });

                        updateDateRangeDisplay();
                    } catch (error) {
                        console.error('Failed to load flatpickr:', error);
                        const rangeElFail = document.getElementById('flatpickrRange');
                        if (rangeElFail) rangeElFail.style.display = 'none';

                        const container = document.querySelector('#dateFilterForm .space-y-3');
                        const fallbackHTML = `
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tanggal Mulai</label>
                            <input type="date" 
                                   name="start_date_fallback"
                                   value="{{ request('start_date') }}"
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm"
                                   onchange="document.getElementById('flatpickrStartDate').value = this.value; updateDateRangeDisplay()">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tanggal Akhir</label>
                            <input type="date" 
                                   name="end_date_fallback"
                                   value="{{ request('end_date') }}"
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm"
                                   onchange="document.getElementById('flatpickrEndDate').value = this.value; updateDateRangeDisplay()">
                        </div>
                    `;
                        container.insertAdjacentHTML('afterbegin', fallbackHTML);
                    }
                }
            }));
        });

        function updateDateRangeDisplay() {
            const startDate = document.getElementById('flatpickrStartDate')?.value;
            const endDate = document.getElementById('flatpickrEndDate')?.value;
            const display = document.getElementById('dateRangeDisplay');

            if (!display) return;

            if (startDate && endDate) {
                const start = new Date(startDate).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
                const end = new Date(endDate).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
                display.textContent = `${start} - ${end}`;
            } else if (startDate) {
                const start = new Date(startDate).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
                display.textContent = `Dari ${start}`;
            } else if (endDate) {
                const end = new Date(endDate).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
                display.textContent = `Hingga ${end}`;
            } else {
                display.textContent = 'Pilih rentang tanggal';
            }
        }

        function applyDateRange() {
            const form = document.getElementById('dateFilterForm');

            const startDate = document.getElementById('flatpickrStartDate').value;
            const endDate = document.getElementById('flatpickrEndDate').value;

            if (startDate && !endDate) {
                document.getElementById('flatpickrEndDate').value = startDate;
            } else if (!startDate && endDate) {
                document.getElementById('flatpickrStartDate').value = endDate;
            }

            form.submit();
        }

        function clearDateRange() {
            if (flatpickrInstance) {
                flatpickrInstance.clear();
            }
            document.getElementById('flatpickrStartDate').value = '';
            document.getElementById('flatpickrEndDate').value = '';
            document.getElementById('dateRangeDisplay').textContent = 'Pilih rentang tanggal';

            const startFallback = document.querySelector('input[name="start_date_fallback"]');
            const endFallback = document.querySelector('input[name="end_date_fallback"]');
            if (startFallback) startFallback.value = '';
            if (endFallback) endFallback.value = '';
        }

        document.addEventListener('DOMContentLoaded', function () {
            loadFlatpickr().catch(() => {
                console.log('Flatpickr loading failed, will use fallback');
            });

            updateDateRangeDisplay();
            try {
                const rows = Array.from(document.querySelectorAll('#suratTableBody tr'));
                rows.forEach(r => r.dataset.match = '1');
                const totalEl = document.getElementById('arsipTotal');
                if (totalEl) totalEl.textContent = rows.length;
                renderArsipPagination();
            } catch (e) {
            }
        });
    </script>
@endsection