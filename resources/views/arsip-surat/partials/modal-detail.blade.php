<div id="modalDetailSurat"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <div
            class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-white dark:bg-gray-800 sticky top-0 z-10">
            <div>
                <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white">Detail Surat</h3>
            </div>
            <button onclick="closeModal('modalDetailSurat')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1.5 sm:p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <i class="fas fa-times text-base sm:text-lg"></i>
            </button>
        </div>

        <div class="overflow-y-auto p-4 sm:p-6" style="max-height: calc(90vh - 150px)">
            <div class="space-y-4 sm:space-y-6">
                <div
                    class="bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                    <h2 class="text-lg sm:text-xl font-medium text-gray-900 dark:text-white mb-4">Informasi Surat</h2>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nama
                                    Surat</label>
                                <p id="detail-nama-surat" class="text-gray-900 dark:text-white"></p>
                            </div>

                            <div id="detail-nomor-surat-container">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nomor
                                    Surat</label>
                                <p id="detail-nomor-surat" class="text-gray-900 dark:text-white"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tipe
                                    Surat</label>
                                <p id="detail-tipe-surat"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tanggal
                                    Dibuat</label>
                                <p id="detail-tanggal-dibuat" class="text-gray-900 dark:text-white"></p>
                            </div>
                        </div>

                        @if(auth()->user()->hasRole(['Admin', 'Tata Usaha']))
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Dibuat
                                    Oleh</label>
                                <p id="detail-dibuat-oleh" class="text-gray-900 dark:text-white"></p>
                            </div>
                        @endif
                    </div>
                </div>

                <div
                    class="bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                        <h2 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white">File Surat</h2>
                        <div id="detail-download-dropdown" class="hidden relative" x-data="{ open: false }">
                            <button @click="open = !open" type="button"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium h-10">
                                <i class="fas fa-download mr-2"></i>
                                Download
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 z-10">
                                <button type="button" onclick="downloadAsWord()" id="detail-download-word"
                                    class="w-full flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-t-lg transition-colors">
                                    <i class="fas fa-file-word text-green-500 mr-3"></i>
                                    DOCX
                                </button>
                                <a id="detail-download-pdf" href="#"
                                    class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-b-lg transition-colors">
                                    <i class="fas fa-file-pdf text-red-500 mr-3"></i>
                                    PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    <div id="detail-file-exists" class="hidden">
                        <div
                            class="mb-4 border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900">
                            <iframe id="detail-pdf-preview" src=""
                                class="w-full border-0 min-h-[350px] md:min-h-[600px]">
                            </iframe>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i id="detail-file-icon" class="fas fa-file-pdf text-2xl text-red-500"></i>
                                <div>
                                    <p id="detail-file-nama" class="text-gray-900 dark:text-white"></p>
                                    <p id="detail-file-type-label" class="text-xs text-gray-500 dark:text-gray-400">File
                                        PDF</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="detail-no-file" class="hidden">
                        <div
                            class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center">
                            <i class="fas fa-file-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada file surat yang tersimpan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end bg-white dark:bg-gray-800 sticky bottom-0">
            <button type="button" onclick="closeModal('modalDetailSurat')"
                class="w-full sm:w-auto px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all font-medium h-11 text-sm">
                Tutup
            </button>
        </div>
    </div>
</div>