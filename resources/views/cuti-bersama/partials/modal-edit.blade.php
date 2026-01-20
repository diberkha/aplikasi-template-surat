<div id="modalEditCutiBersama"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-lg w-full relative flex flex-col max-h-[90vh]">
        <button type="button" onclick="closeModal('modalEditCutiBersama')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 z-10 transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div
            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex-none bg-gray-50 dark:bg-gray-700/50 rounded-t-xl">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Cuti Bersama</h3>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form id="formEditCutiBersama" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_id_cuti">

                <div class="space-y-5">
                    <div>
                        <label for="edit_nama_cuti" class="block mb-2 text-sm text-gray-700 dark:text-gray-300">
                            Jenis Cuti Bersama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="jenis_cuti_bersama" id="edit_nama_cuti" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-sm transition-all outline-none"
                            placeholder="Contoh: Cuti Bersama Idul Fitri">
                    </div>

                    <div>
                        <label for="edit_tahun" class="block mb-2 text-sm text-gray-700 dark:text-gray-300">
                            Tahun <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="tahun" id="edit_tahun" required min="2000" max="2100"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-sm transition-all outline-none">
                    </div>

                    <div>
                        <label for="edit_jumlah_hari" class="block mb-2 text-sm text-gray-700 dark:text-gray-300">
                            Lama Cuti (Hari) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="jumlah_hari" id="edit_jumlah_hari" required min="1"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-sm transition-all outline-none"
                            placeholder="Contoh: 1">
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="is_perhitungan_cuti_tahunan" id="edit_potong_jatah_tahunan"
                                value="1"
                                class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="edit_potong_jatah_tahunan"
                                class="font-medium text-gray-700 dark:text-gray-300">Diperhitungkan sebagai Cuti
                                Tahunan</label>
                            <SAME>
                                <p class="text-gray-500 dark:text-gray-400">Jika dicentang, akan mengurangi sisa cuti
                                    tahunan pegawai</p>
                        </div>
                    </div>

                    <div>
                        <label for="edit_catatan" class="block mb-2 text-sm text-gray-700 dark:text-gray-300">
                            Catatan <span class="text-gray-500 text-xs">(Opsional)</span>
                        </label>
                        <textarea name="catatan" id="edit_catatan" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-sm transition-all"></textarea>
                    </div>

                    <div
                        class="mt-8 flex justify-end space-x-3 sticky bottom-0 bg-white dark:bg-gray-800 py-4 rounded-b-xl">
                        <button type="button" onclick="closeModal('modalEditCutiBersama')"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all">
                            Perbarui
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
