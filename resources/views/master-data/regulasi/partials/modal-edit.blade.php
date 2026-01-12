<div id="modalEdit" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Regulasi</h3>
            <button onclick="closeModal('modalEdit')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form id="editRegulasiForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="editIdRegulasi" name="id_regulasi">

            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Isi Regulasi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <textarea name="isi_regulasi" id="editIsiRegulasiField" rows="10" required
                            placeholder="Contoh: Undang-undang Nomor 36 Tahun 2009 tentang Kesehatan"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                                   dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 resize-y"></textarea>
                        <div id="editIsiRegulasiCounter" class="absolute bottom-2 right-2 text-xs text-gray-500">
                            0 karakter
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('modalEdit')"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Perbarui
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function updateCounter(textarea, counter) {
        const len = textarea.value.length;
        if (counter) {
            counter.textContent = `${len} karakter`;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const editIsiRegulasiField = document.getElementById('editIsiRegulasiField');
        const editIsiRegulasiCounter = document.getElementById('editIsiRegulasiCounter');

        if (editIsiRegulasiField && editIsiRegulasiCounter) {
            editIsiRegulasiField.addEventListener('input', function () {
                updateCounter(this, editIsiRegulasiCounter);
            });
        }
    });
</script>