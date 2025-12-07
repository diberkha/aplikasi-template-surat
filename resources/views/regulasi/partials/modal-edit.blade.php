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
                        Template Surat <span class="text-red-500">*</span>
                    </label>
                    <select name="id_template_surat" id="editTemplateSurat" required onchange="getSuratForEdit()"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                                   dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Template Surat --</option>
                        @foreach($templates as $template)
                            <option value="{{ $template->id_template_surat }}">{{ $template->nama_template_surat }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Surat <span class="text-red-500">*</span>
                    </label>
                    <select name="id_surat" id="editSurat" required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                                   dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Surat --</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Menimbang <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <textarea name="menimbang" id="editMenimbang" rows="5" required
                            placeholder="Contoh: a. bahwa dalam rangka..."
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                                       dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-y"></textarea>
                        <div id="editMenimbangCounter" class="absolute bottom-2 right-2 text-xs text-gray-500">
                            0 karakter
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Mengingat <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <textarea name="mengingat" id="editMengingat" rows="5" required
                            placeholder="Contoh: 1. Undang-Undang..."
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                                       dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-y"></textarea>
                        <div id="editMengingatCounter" class="absolute bottom-2 right-2 text-xs text-gray-500">
                            0 karakter
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="resetEditRegulasi()"
                        class="px-5 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">
                        Reset
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        Perbarui
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>