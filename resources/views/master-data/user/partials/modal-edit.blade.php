<div id="modalEditUser" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full relative">

        <button type="button" onclick="closeModal('modalEditUser')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit User</h3>
        </div>

        <div class="p-6">
            <form id="formEditUser" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">

                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Ruangan <span
                                class="text-red-500">*</span></label>
                        <select id="edit_id_ruangan" name="id_ruangan" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            @foreach($ruangan as $r)
                                <option value="{{ $r->id_ruangan }}">{{ $r->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Username <span
                                class="text-red-500">*</span></label>
                        <input id="edit_username" name="username" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Password Baru (Opsional)</label>
                        <input type="password" id="password_edit" name="password"
                            placeholder="Kosongkan jika tidak ingin mengubah"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            <i class="fas fa-info-circle mr-1"></i>
                            Minimal 8 karakter (jika diisi)
                        </p>
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation_edit" name="password_confirmation"
                            placeholder="Kosongkan jika tidak ingin mengubah"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="resetEditUser()"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">
                        Reset
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>