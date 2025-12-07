<div id="modalCreateSK" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-3xl w-full">

        <!-- HEADER -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Buat Surat Hukum</h3>
            <button onclick="closeModal('modalCreateSK')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- FORM -->
        <form action="{{ route('template-surat.hukum.store') }}" method="POST" id="skDirekturForm">
            @csrf

            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">

                <!-- TEMPLATE SURAT -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Template Surat <span
                            class="text-red-500">*</span></label>
                    <select name="template_id" id="template_surat_sk" required onchange="getSuratByTemplateSK()"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">-- Pilih Template Surat --</option>
                        @foreach ($templates as $template)
                            <option value="{{ $template->id_template_surat }}">{{ $template->nama_template_surat }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- NAMA SURAT -->
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

                <!-- NOMOR SURAT -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Nomor Surat <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nomor_surat" required placeholder="Contoh: 006/SHKS/VI/2024"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>

                <!-- JUDUL SURAT -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Judul Surat <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="judul_surat" required
                        placeholder="Contoh: KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM..."
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>

                <!-- TENTANG -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Tentang <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="tentang" required placeholder="Contoh: Pembentukan Tim Kendali Mutu..."
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>

                <!-- IDENTITAS PENETAP -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Identitas Penetap <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="identitas_penetap" required
                        placeholder="Contoh: DIREKTUR RSUD dr. SOERATNO GEMOLONG"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>

                <!-- MENIMBANG -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Menimbang <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <textarea name="menimbang" id="menimbangSK" rows="4" required
                            placeholder="Contoh: a. bahwa dalam rangka..."
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        <div id="counterMenimbangSK" class="absolute bottom-2 right-2 text-xs text-gray-500">0 karakter
                        </div>
                    </div>
                </div>

                <!-- MENGINGAT -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Mengingat <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <textarea name="mengingat" id="mengingatSK" rows="4" required
                            placeholder="Contoh: 1. Undang-Undang..."
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        <div id="counterMengingatSK" class="absolute bottom-2 right-2 text-xs text-gray-500">0 karakter
                        </div>
                    </div>
                </div>

                <!-- MEMUTUSKAN -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Memutuskan <span
                            class="text-red-500">*</span></label>
                    <textarea name="memutuskan" rows="3" required placeholder="Contoh: Menetapkan..."
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                </div>

                <!-- MENETAPKAN -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Menetapkan</label>
                    <textarea name="menetapkan" rows="3" placeholder="Isi ketetapan SK..."
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                </div>

                <!-- TEMPAT & TANGGAL -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Tempat Dibuat <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="tempat_dibuat" required placeholder="Gemolong"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Dibuat <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_dibuat" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-3">
                <button type="button" onclick="closeModal('modalCreateSK')"
                    class="px-5 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function getSuratByTemplateSK() {
        const templateId = document.getElementById('template_surat_sk').value;
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

    function updateCharCount(textarea, counterId) {
        const counter = document.getElementById(counterId);
        counter.textContent = textarea.value.length + ' karakter';
    }

    document.addEventListener('DOMContentLoaded', () => {
        const menimbangSK = document.getElementById('menimbangSK');
        const mengingatSK = document.getElementById('mengingatSK');

        menimbangSK.addEventListener('input', () => updateCharCount(menimbangSK, 'counterMenimbangSK'));
        mengingatSK.addEventListener('input', () => updateCharCount(mengingatSK, 'counterMengingatSK'));
    });
</script>