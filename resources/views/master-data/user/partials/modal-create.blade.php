<div id="modalCreateUser" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full relative overflow-hidden">

        <button type="button" onclick="closeModal('modalCreateUser')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 z-10 transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah User</h3>
        </div>

        <div class="p-6">
            <form id="formCreateUser" action="{{ route('master-data.user.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="space-y-6">
                    <div class="relative" x-data="{
                        open: false,
                        search: '',
                        selectedId: '',
                        selectedName: '',
                        options: ruanganOptions,
                        init() {
                            this.$nextTick(() => {
                                const form = this.$el.closest('form');
                                if (form) {
                                    form.addEventListener('reset', () => {
                                        setTimeout(() => {
                                            this.selectedId = '';
                                            this.selectedName = '';
                                            this.search = '';
                                        }, 50);
                                    });
                                }
                            });
                        }
                    }" @click.outside="open = false">
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Ruangan <span
                                class="text-red-500">*</span></label>
                        <input type="hidden" name="id_ruangan" :value="selectedId" required>

                        <div class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full px-4 py-2 text-left border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white flex justify-between items-center bg-white transition-all focus:ring-2 focus:ring-green-500 outline-none">
                                <span x-text="selectedName || 'Pilih Ruangan...'"
                                    :class="!selectedName && 'text-gray-400 font-normal'"></span>
                                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                                    :class="open && 'rotate-180'"></i>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                class="absolute z-[9999] mt-1 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-2xl overflow-hidden"
                                style="display: none;">
                                <div
                                    class="p-2 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                    <div class="relative text-gray-400 focus-within:text-green-500">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-search text-xs"></i>
                                        </div>
                                        <input type="text" x-model="search" placeholder="Cari ruangan..."
                                            class="w-full pl-9 pr-3 py-1.5 text-sm border border-gray-200 dark:border-gray-600 rounded-md dark:bg-gray-700 focus:ring-1 focus:ring-green-500 outline-none bg-white">
                                    </div>
                                </div>
                                <ul class="max-h-56 overflow-y-auto py-1 custom-scrollbar">
                                    <template
                                        x-for="opt in options.filter(o => o.nama.toLowerCase().includes(search.toLowerCase()))"
                                        :key="opt.id">
                                        <li>
                                            <button type="button"
                                                @click="selectedId = opt.id; selectedName = opt.nama; open = false; search = ''"
                                                class="w-full text-left px-4 py-2.5 text-sm hover:bg-green-50 dark:hover:bg-green-900/30 text-gray-700 dark:text-gray-300 transition-colors"
                                                :class="selectedId === opt.id && 'bg-green-50 dark:bg-green-900/40 text-green-600 dark:text-green-400 font-medium'">
                                                <span x-text="opt.nama"></span>
                                            </button>
                                        </li>
                                    </template>
                                    <template
                                        x-if="options.filter(o => o.nama.toLowerCase().includes(search.toLowerCase())).length === 0">
                                        <li
                                            class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center italic">
                                            Data tidak ditemukan
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Username <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="username" required autocomplete="off"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" name="password" required autocomplete="off"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition-all">
                        <p class="mt-1 text-[11px] text-gray-500 dark:text-gray-400">
                            <i class="fas fa-info-circle mr-1"></i>
                            Minimal 8 karakter
                        </p>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Konfirmasi Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition-all">
                    </div>
                </div>

            </form>
        </div>

        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700">
            <div class="flex justify-end space-x-3">
                <button type="button" @click="document.getElementById('formCreateUser').reset()"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white transition-colors">
                    Reset
                </button>
                <button type="submit" form="formCreateUser"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
