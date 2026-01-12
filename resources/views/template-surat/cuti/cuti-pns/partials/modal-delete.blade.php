<div id="modalDeleteCutiPNS" x-data="{ isOpen: false }" x-show="isOpen" x-cloak
    class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full relative">
        <button type="button" @click="isOpen = false"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-green-600 dark:text-green-400">Konfirmasi Hapus</h3>
        </div>
        <div class="p-6">
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Apakah Anda yakin ingin menghapus template ini? Data yang dihapus tidak dapat dikembalikan.
            </p>
            <div
                class="mt-4 bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                <p class="text-sm mb-2">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Nama Template:</span>
                    <span id="delete-cuti-pns-template-name" class="text-gray-800 dark:text-gray-200">-</span>
                </p>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
            <button type="button" @click="isOpen = false"
                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">
                Batal
            </button>
            <form id="formDeleteTemplateCutiPNS" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Hapus Template
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModalPNS(id, name) {
        const modalEl = document.getElementById('modalDeleteCutiPNS');
        if (!modalEl) return;

        const nameEl = modalEl.querySelector('#delete-cuti-pns-template-name');
        if (nameEl) nameEl.textContent = name;

        const form = modalEl.querySelector('#formDeleteTemplateCutiPNS');
        if (form) {
            form.action = "{{ route('template-surat.cuti.destroy', '') }}/" + id;
        }

        const alpineData = Alpine.$data(modalEl);
        if (alpineData) alpineData.isOpen = true;
    }
</script>