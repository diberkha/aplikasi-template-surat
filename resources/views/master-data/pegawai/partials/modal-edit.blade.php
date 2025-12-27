<div id="modalEditPegawai" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full relative">
        <button type="button" @click="document.getElementById('modalEditPegawai').classList.add('hidden')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Pegawai</h3>
        </div>

        <div class="p-6">
            <form id="formEditPegawai" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id_pegawai">
                
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Pegawai <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="edit_nama_pegawai" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                            placeholder="Masukkan nama lengkap...">
                    </div>
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">NIP <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nip" id="edit_nip_pegawai" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                            placeholder="Masukkan NIP...">
                    </div>
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Masuk <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_masuk" id="edit_tanggal_masuk_pegawai" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="document.getElementById('modalEditPegawai').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white text-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
