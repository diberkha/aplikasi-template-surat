<div id="modalDeleteSK" class="fixed inset-0 z-[70] hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
        onclick="closeModal('modalDeleteSK')"></div>

    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div
            class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full border border-gray-200 dark:border-gray-700">
            <button type="button" onclick="closeModal('modalDeleteSK')"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                <i class="fas fa-times"></i>
            </button>

            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-green-600 dark:text-green-400">Konfirmasi Hapus</h3>
            </div>

            <div class="p-6">
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Apakah Anda yakin ingin menghapus template surat ini? Data yang dihapus tidak dapat dikembalikan.
                </p>
                <div
                    class="mt-4 bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                    <p class="text-sm mb-2">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Nama Template:</span>
                        <span id="delete-sk-template-name" class="text-gray-800 dark:text-gray-200">-</span>
                    </p>
                </div>
            </div>

            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3 bg-gray-50 dark:bg-gray-800/50 rounded-b-xl">
                <button type="button" onclick="closeModal('modalDeleteSK')"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all font-normal">
                    Batal
                </button>
                <form id="formDeleteSK" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all shadow-green-600/20 font-normal">
                        Hapus Template
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>