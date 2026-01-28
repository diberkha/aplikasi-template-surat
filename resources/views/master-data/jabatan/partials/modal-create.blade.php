<div id="modalCreateJabatan"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full relative">
        <button type="button" onclick="closeModal('modalCreateJabatan')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Jabatan</h3>
        </div>

        <div class="p-6">
            <form id="formCreateJabatan" action="{{ route('master-data.jabatan.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Jabatan <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_jabatan" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all">
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="document.getElementById('formCreateJabatan').reset()"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">
                        Reset
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>