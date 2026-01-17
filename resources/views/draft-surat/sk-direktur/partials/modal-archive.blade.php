<div id="modalArsipkanSk" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-green-600 dark:text-green-400">Konfirmasi Arsipkan Surat</h3>
            <button onclick="closeModal('modalArsipkanSk')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">Apakah Anda yakin ingin mengarsipkan SK Direktur ini ke
                dalam arsip? Setelah diarsipkan, surat tidak dapat diubah kembali.</p>
            <div
                class="mt-4 bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                <p class="text-sm mb-2">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Tentang:</span>
                    <span id="arsipkan-nama-sk" class="text-gray-800 dark:text-gray-200">-</span>
                </p>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
            <button type="button" onclick="closeModal('modalArsipkanSk')"
                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                Batal
            </button>
            <button type="button" id="btnConfirmArsipkanSk"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Arsipkan Surat
            </button>
        </div>
    </div>
</div>