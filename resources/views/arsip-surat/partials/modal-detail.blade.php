<div id="modalDetailSurat"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <div
            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-white dark:bg-gray-800 sticky top-0">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Surat</h3>
            </div>
            <button onclick="closeModal('modalDetailSurat')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div class="overflow-y-auto p-6" style="max-height: calc(90vh - 120px)">
            <div class="space-y-6">
                <div class="bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Informasi Surat</h2>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nama
                                    Surat</label>
                                <p id="detail-nama-surat" class="text-gray-900 dark:text-white font-medium"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nomor
                                    Surat</label>
                                <p id="detail-nomor-surat" class="text-gray-900 dark:text-white font-medium"></p>
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

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Dibuat
                                Oleh</label>
                            <p id="detail-dibuat-oleh" class="text-gray-900 dark:text-white"></p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">File Surat</h2>

                    <div id="detail-file-exists" class="hidden">
                        <div
                            class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center">
                            <i class="fas fa-file-pdf text-4xl text-red-500 mb-3"></i>

                            <div class="flex items-center justify-center space-x-3 mb-2">
                                <p id="detail-file-nama" class="text-gray-700 dark:text-gray-300 font-medium"></p>
                                <button id="detail-download-btn" type="button"
                                    onclick="document.getElementById('detail-download-link').click()"
                                    class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    <i class="fas fa-download mr-2"></i>
                                    Download
                                </button>
                            </div>

                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">File PDF surat</p>
                            <a id="detail-download-link" href="#" target="_blank" aria-hidden="true" tabindex="-1"
                                class="sr-only inline-flex items-center justify-center w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <i class="fas fa-download mr-2"></i>
                                Download PDF
                            </a>
                        </div>
                    </div>

                    <div id="detail-no-file" class="hidden">
                        <div
                            class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center">
                            <i class="fas fa-file-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada file surat yang tersimpan</p>
                            <div class="mt-4">
                                <button type="button" disabled
                                    class="inline-flex items-center justify-center w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-300 rounded-lg cursor-not-allowed">
                                    <i class="fas fa-download mr-2"></i>
                                    Tidak Tersedia
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3 bg-white dark:bg-gray-800 sticky bottom-0">
            <button type="button" onclick="closeModal('modalDetailSurat')"
                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>