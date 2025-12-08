<div id="modalCreate" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full">

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Regulasi</h3>

            <button onclick="closeModal('modalCreate')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form action="{{ route('regulasi.store') }}" method="POST" id="regulasiForm">
            @csrf

            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Template Surat <span class="text-red-500">*</span>
                    </label>

                    <select name="id_template_surat" id="template_surat" required onchange="getSuratByTemplate()"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                               dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500
                               appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236b7280\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3e%3cpolyline points=\'6 9 12 15 18 9\'%3e%3c/polyline%3e%3c/svg%3e')] bg-no-repeat bg-right-4 bg-contain">

                        <option value="">-- Pilih Template Surat --</option>

                        @foreach ($templates as $template)
                            <option value="{{ $template->id_template_surat }}"
                                @if(old('id_template_surat') == $template->id_template_surat) selected @endif>
                                {{ $template->nama_template_surat }}
                            </option>
                        @endforeach

                    </select>

                    @error('id_template_surat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Surat <span class="text-red-500">*</span>
                    </label>

                    <select name="id_surat" id="surat" required disabled
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                               dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500
                               appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236b7280\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3e%3cpolyline points=\'6 9 12 15 18 9\'%3e%3c/polyline%3e%3c/svg%3e')] bg-no-repeat bg-right-4 bg-contain">

                        <option value="">-- Pilih Template Surat terlebih dahulu --</option>
                    </select>

                    @error('id_surat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Keputusan
                    </label>

                    <div class="flex gap-3">
                        <select name="id_keputusan" id="keputusan"
                            class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                                   dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500
                                   appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236b7280\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3e%3cpolyline points=\'6 9 12 15 18 9\'%3e%3c/polyline%3e%3c/svg%3e')] bg-no-repeat bg-right-4 bg-contain"
                            onchange="handleKeputusanChange()">

                            <option value="">-- Pilih Keputusan --</option>

                            @foreach ($keputusans as $keputusan)
                                <option value="{{ $keputusan->id_keputusan }}">
                                    {{ $keputusan->nama_keputusan }}
                                </option>
                            @endforeach

                        </select>

                        <button type="button" onclick="toggleKeputusanInput()"
                            class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                                   hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            title="Tambah keputusan lain">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    @error('id_keputusan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="keputusanInputContainer" class="hidden">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Keputusan Lainnya
                    </label>

                    <div class="flex gap-3">
                        <input type="text" name="keputusan_lainnya" id="keputusanLainnya"
                            placeholder="Masukkan keputusan lain"
                            class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                                   dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500">

                        <button type="button" onclick="toggleKeputusanInput()"
                            class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                                   hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            title="Batal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    @error('keputusan_lainnya')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Menimbang <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <textarea name="menimbang" id="menimbang" rows="5" required
                            placeholder="Contoh: a. bahwa dalam rangka..."
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                                         dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 resize-y">{{ old('menimbang') }}</textarea>

                        <div id="menimbangCounter" class="absolute bottom-2 right-2 text-xs text-gray-500">
                            0 karakter
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Mengingat <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <textarea name="mengingat" id="mengingat" rows="5" required
                            placeholder="Contoh: 1. Undang-Undang..."
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                                         dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 resize-y">{{ old('mengingat') }}</textarea>

                        <div id="mengingatCounter" class="absolute bottom-2 right-2 text-xs text-gray-500">
                            0 karakter
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                <div class="text-sm text-gray-500"></div>

                <div class="flex space-x-3">
                    <button type="button" onclick="document.getElementById('regulasiForm').reset();"
                        class="px-5 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        Reset
                    </button>

                    <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function getSuratByTemplate() {
        const templateId = document.getElementById('template_surat').value;
        const suratSelect = document.getElementById('surat');

        suratSelect.disabled = true;
        suratSelect.innerHTML = '<option value="">Memuat data...</option>';

        if (!templateId) {
            suratSelect.innerHTML = '<option value="">-- Pilih Template Surat terlebih dahulu --</option>';
            return;
        }

        fetch(`/regulasi/get-surat/${templateId}`)
            .then(response => response.json())
            .then(data => {
                suratSelect.innerHTML = '';
                suratSelect.disabled = false;

                data.forEach(item => {
                    suratSelect.innerHTML += `<option value="${item.id_surat}">${item.nama_surat}</option>`;
                });
            })
            .catch(() => {
                suratSelect.innerHTML = '<option value="">Gagal memuat data</option>';
            });
    }

    function toggleKeputusanInput() {
        const keputusanSelect = document.getElementById('keputusan');
        const keputusanInputContainer = document.getElementById('keputusanInputContainer');

        if (keputusanInputContainer.classList.contains('hidden')) {
            keputusanInputContainer.classList.remove('hidden');
            keputusanSelect.value = '';
            document.getElementById('keputusanLainnya').focus();
        } else {
            keputusanInputContainer.classList.add('hidden');
            document.getElementById('keputusanLainnya').value = '';
        }
    }

    function handleKeputusanChange() {
        const keputusanSelect = document.getElementById('keputusan');
        const keputusanInputContainer = document.getElementById('keputusanInputContainer');

        if (keputusanSelect.value) {
            keputusanInputContainer.classList.add('hidden');
            document.getElementById('keputusanLainnya').value = '';
        }
    }

    function updateCounter(textarea, counter) {
        const len = textarea.value.length;
        counter.textContent = `${len} karakter`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const menimbang = document.getElementById('menimbang');
        const mengingat = document.getElementById('mengingat');

        updateCounter(menimbang, menimbangCounter);
        updateCounter(mengingat, mengingatCounter);

        menimbang.addEventListener('input', () => updateCounter(menimbang, menimbangCounter));
        mengingat.addEventListener('input', () => updateCounter(mengingat, mengingatCounter));

        @if(old('id_surat'))
            setTimeout(() => {
                getSuratByTemplate();
                setTimeout(() => {
                    document.getElementById('surat').value = '{{ old('id_surat') }}';
                }, 300);
            }, 300);
        @endif
});
</script>