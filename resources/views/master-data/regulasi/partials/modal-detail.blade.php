<div id="modalDetail" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 
            flex justify-between items-center sticky top-0 bg-white dark:bg-gray-800 z-10">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Regulasi</h3>
            <button onclick="closeModal('modalDetail')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div class="px-6 pt-4 flex justify-end">
            <button onclick="editRegulasi()" id="editButton"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors hidden">
                <i class="fas fa-edit mr-2"></i> Edit
            </button>
        </div>

        <div class="p-6 space-y-6">
            <div id="detailContent">
                <div class="text-center py-12">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                        <i class="fas fa-spinner fa-spin text-2xl text-gray-500 dark:text-gray-400"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400">Memuat data regulasi</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 
            bg-gray-50 dark:bg-gray-700/50 sticky bottom-0">
            <div class="flex justify-end">
                <button onclick="closeModal('modalDetail')"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 
                        rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Tutup
                </button>
            </div>
        </div>

    </div>
</div>