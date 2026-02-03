<div id="modalEditUnit" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full relative overflow-hidden">
        <button type="button" onclick="closeModal('modalEditUnit')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 z-10 transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Unit</h3>
        </div>

        <div class="p-6">
            <form id="formEditUnit" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id_unit" name="id_unit">

                <div class="space-y-6">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Unit <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="edit_nama_unit" name="nama_unit" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition-all">
                    </div>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700">
            <div class="flex justify-end space-x-3">
                <button type="button" @click="resetEditUnit()"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white transition-colors">
                    Reset
                </button>
                <button type="submit" form="formEditUnit" id="btnSubmitEditUnit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Perbarui
                </button>
            </div>
        </div>
    </div>
</div>