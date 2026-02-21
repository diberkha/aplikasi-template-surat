<div id="modalDeleteUndangan" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalDeleteUndangan')"></div>

        <div
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:max-w-md w-full border border-gray-200 dark:border-gray-700">

            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-red-50 dark:bg-red-900/20">
                <h3 class="text-lg font-semibold text-red-600 dark:text-red-400 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Hapus Template
                </h3>
                <button onclick="closeModal('modalDeleteUndangan')"
                    class="p-2 -mr-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form action="" method="POST" id="formDeleteUndangan">
                @csrf
                @method('DELETE')

                <div class="p-6">
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        Apakah Anda yakin ingin menghapus template surat <strong id="delete-undangan-template-name"
                            class="text-gray-900 dark:text-white"></strong>?
                    </p>
                    <p class="text-sm text-red-600 dark:text-red-400">
                        <i class="fas fa-info-circle mr-1"></i>
                        Data yang dihapus tidak dapat dikembalikan
                    </p>
                </div>

                <div
                    class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3 bg-gray-50 dark:bg-gray-700/50">
                    <button type="button" onclick="closeModal('modalDeleteUndangan')"
                        class="px-5 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors shadow-sm hover:shadow-md">
                        <i class="fas fa-trash-alt mr-2"></i>Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
