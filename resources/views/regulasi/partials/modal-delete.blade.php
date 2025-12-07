<div id="modalDeleteRegulasi"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full relative">

        <button type="button" onclick="closeModal('modalDeleteRegulasi')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-red-600 dark:text-red-400">Konfirmasi Hapus Regulasi</h3>
        </div>

        <div class="p-6">
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Apakah Anda yakin ingin menghapus regulasi ini? Data yang dihapus tidak dapat dikembalikan.
            </p>
            <div class="mt-4 bg-red-50 dark:bg-red-900/20 p-4 rounded-lg border border-red-200 dark:border-red-800">
                <p class="text-sm mb-2">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Nama Surat:</span>
                    <span id="delete-nama-surat" class="text-gray-800 dark:text-gray-200">-</span>
                </p>
                <p class="text-sm mb-2">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Tipe Surat:</span>
                    <span id="delete-tipe-surat" class="text-gray-800 dark:text-gray-200">-</span>
                </p>
                <p class="text-sm">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Tanggal Dibuat:</span>
                    <span id="delete-tanggal-dibuat" class="text-gray-800 dark:text-gray-200">-</span>
                </p>
            </div>

            <div
                class="mt-4 bg-yellow-50 dark:bg-yellow-900/10 p-3 rounded-lg border border-yellow-200 dark:border-yellow-800">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Menimbang:</p>
                <p id="delete-preview-menimbang" class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                    -
                </p>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
            <button type="button" onclick="closeModal('modalDeleteRegulasi')"
                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">
                Batal
            </button>
            <form id="formDeleteRegulasi" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus Regulasi
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>