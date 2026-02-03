<div id="modalCreateCutiBersama"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full relative overflow-hidden">
        <button type="button" onclick="closeModal('modalCreateCutiBersama')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Cuti Bersama</h3>
        </div>

        <div class="p-6">
            <form id="formCreateCutiBersama" action="{{ route('cuti-bersama.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="nama_cuti" class="block mb-2 text-gray-700 dark:text-gray-300">Jenis Cuti Bersama
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="jenis_cuti_bersama" id="nama_cuti" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                            placeholder="Contoh: Cuti Bersama Idul Fitri">
                    </div>

                    <div>
                        <label for="tahun" class="block mb-2 text-gray-700 dark:text-gray-300">Tahun <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="tahun" id="tahun" required min="2000" max="2100"
                            value="{{ date('Y') }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="jumlah_hari" class="block mb-2 text-gray-700 dark:text-gray-300">Lama Cuti (Hari)
                            <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah_hari" id="jumlah_hari" required min="1"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                            placeholder="Contoh: 1">
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="is_perhitungan_cuti_tahunan" id="potong_jatah_tahunan"
                                value="1" checked
                                class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="potong_jatah_tahunan"
                                class="font-medium text-gray-700 dark:text-gray-300">Diperhitungkan
                                sebagai Cuti Tahunan</label>
                            <p class="text-gray-500 dark:text-gray-400">Jika dicentang, akan mengurangi sisa cuti
                                tahunan
                                pegawai</p>
                        </div>
                    </div>

                    <div>
                        <label for="catatan" class="block mb-2 text-gray-700 dark:text-gray-300">Catatan <span
                                class="text-gray-500 text-xs">(Opsional)</span></label>
                        <textarea name="catatan" id="catatan" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white transition-all"></textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700">
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('formCreateCutiBersama').reset()"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">
                    Reset
                </button>
                <button type="submit" form="formCreateCutiBersama"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>