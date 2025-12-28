<div id="modalCreate" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full">

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Regulasi</h3>

            <button onclick="closeModal('modalCreate')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form action="{{ route('master-data.regulasi.store') }}" method="POST" id="regulasiForm">
            @csrf

            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Isi Regulasi <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <textarea name="isi_regulasi" id="isiRegulasiField" rows="10" required
                            placeholder="Contoh: Undang-undang Nomor 36 Tahun 2009 tentang Kesehatan"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                                   dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 resize-y">{{ old('isi_regulasi') }}</textarea>
                        <div id="isiRegulasiCounter" class="absolute bottom-2 right-2 text-xs text-gray-500">
                            0 karakter
                        </div>
                    </div>

                    @error('isi_regulasi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                <div class="text-sm text-gray-500"></div>

                <div class="flex space-x-3">
                    <button type="button" onclick="document.getElementById('regulasiForm').reset();"
                        class="px-5 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        Reset
                    </button>

                    <button type="submit"
                        class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                        Simpan
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
        const isiRegulasiField = document.getElementById('isiRegulasiField');
        const isiRegulasiCounter = document.getElementById('isiRegulasiCounter');

        if (isiRegulasiField && isiRegulasiCounter) {
            updateCounter(isiRegulasiField, isiRegulasiCounter);
            isiRegulasiField.addEventListener('input', () => updateCounter(isiRegulasiField, isiRegulasiCounter));
        }
        
        const modal = document.getElementById('modalCreate');
        if (modal) {
            modal.addEventListener('modal-closed', function() {
                if (isiRegulasiCounter) {
                    isiRegulasiCounter.textContent = '0 karakter';
                }
            });
        }
    });
</script>