<div id="modalCreatePegawai"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full relative flex flex-col max-h-[90vh]">
        <button type="button" onclick="closeModal('modalCreatePegawai')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 z-10 transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div
            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex-none bg-gray-50 dark:bg-gray-700/50 rounded-t-xl">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Pegawai</h3>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form id="formCreatePegawai" action="{{ route('master-data.pegawai.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                    <div class="lg:col-span-1">
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Jenis Pegawai <span
                                class="text-red-500">*</span></label>
                        <div class="relative" x-data="{
                            open: false, selected: 'PNS', options: ['PNS', 'NON ASN', 'PPPK'],
                            init() {
                                this.$nextTick(() => {
                                    this.triggerChange();

                                    const form = this.$el.closest('form');
                                    if (form) {
                                        form.addEventListener('reset', () => {
                                            setTimeout(() => {
                                                this.selected = 'PNS';
                                                this.triggerChange();
                                            }, 50);
                                        });
                                    }
                                });
                            },
                            select(opt) {
                                this.selected = opt;
                                this.open = false;
                                this.triggerChange();
                            },
                            triggerChange() {
                                if (typeof toggleNIPField === 'function') toggleNIPField(this.selected, 'create');
                                if (typeof updateMasaKerjaLabel === 'function') updateMasaKerjaLabel(this.selected, 'create');
                                if (typeof toggleLeaveFields === 'function') toggleLeaveFields(this.selected, 'create');
                            }
                        }" @click.outside="open = false">
                            <input type="hidden" name="jenis_pegawai" id="jenis_pegawai_create" :value="selected">

                            <button type="button" @click="open = !open"
                                class="w-full px-4 py-2 text-left border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white flex justify-between items-center transition-all focus:ring-2 focus:ring-green-500 outline-none">
                                <span x-text="selected" class="font-normal text-gray-700 dark:text-gray-300"></span>
                                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                                    :class="open && 'rotate-180'"></i>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                class="absolute z-[9999] mt-1 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-2xl overflow-hidden"
                                style="display: none;">
                                <ul class="py-1">
                                    <template x-for="opt in options" :key="opt">
                                        <li>
                                            <button type="button" @click="select(opt)"
                                                class="w-full text-left px-4 py-2 text-sm hover:bg-green-50 dark:hover:bg-green-900/30 text-gray-700 dark:text-gray-300 transition-colors"
                                                :class="selected === opt && 'bg-green-50 dark:bg-green-900/40 text-green-600 dark:text-green-400 font-medium'">
                                                <span x-text="opt"></span>
                                            </button>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Nama Pegawai <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition-all">
                    </div>

                    <div class="lg:col-span-1" id="nip_field_create">
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">NIP <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nip" id="nip_input_create" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition-all">
                    </div>

                    <div class="lg:col-span-1">
                        <div class="relative" x-data="{
                            open: false,  search: '', selected: '', options: jabatanOptions,
                            init() {
                                this.$nextTick(() => {
                                    const form = this.$el.closest('form');
                                    if (form) {
                                        form.addEventListener('reset', () => {
                                            setTimeout(() => {
                                                this.selected = '';
                                                this.search = '';
                                            }, 50);
                                        });
                                    }
                                });
                            }
                        }" @click.outside="open = false">
                            <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Jabatan <span
                                    class="text-red-500">*</span></label>
                            <input type="hidden" name="jabatan" :value="selected" required>

                            <div class="relative">
                                <button type="button" @click="open = !open"
                                    class="w-full px-4 py-2 text-left border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white flex justify-between items-center transition-all focus:ring-2 focus:ring-green-500 outline-none">
                                    <span x-text="selected || 'Pilih Jabatan...'"
                                        :class="!selected && 'text-gray-400 font-normal'"></span>
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
                                            <input type="text" x-model="search" placeholder="Cari jabatan..."
                                                class="w-full pl-9 pr-8 py-1.5 text-sm border border-gray-200 dark:border-gray-600 rounded-md dark:bg-gray-700 focus:ring-1 focus:ring-green-500 outline-none transition-all">
                                            <button type="button" x-show="search" @click="search = ''"
                                                class="absolute inset-y-0 right-0 pr-2 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                                                <i class="fas fa-times-circle text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <ul class="max-h-56 overflow-y-auto py-1 custom-scrollbar">
                                        <template
                                            x-for="opt in options.filter(o => o.toLowerCase().includes(search.toLowerCase()))"
                                            :key="opt">
                                            <li>
                                                <button type="button" @click="selected = opt; open = false; search = ''"
                                                    class="w-full text-left px-4 py-2 text-sm hover:bg-green-50 dark:hover:bg-green-900/30 text-gray-700 dark:text-gray-300 transition-colors"
                                                    :class="selected === opt && 'bg-green-50 dark:bg-green-900/40 text-green-600 dark:text-green-400 font-medium'">
                                                    <span x-text="opt"></span>
                                                </button>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <label class="block mb-2 text-sm text-gray-700 dark:text-gray-300"
                            id="label_masa_kerja_create">TMT CPNS <span class="text-red-500">*</span></label>
                        <input type="date" name="masa_kerja" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition-all">
                    </div>

                    <div class="lg:col-span-2">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                            Sisa Cuti Tahunan <span class="ml-1 text-gray-500 text-xs">(Opsional)</span>
                        </h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3" id="cuti_total_msg_create">
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label
                                    class="block mb-1 text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400">Tahun
                                    N</label>
                                <input type="number" name="sisa_cuti_n" id="sisa_cuti_n_create" placeholder="12" min="0"
                                    value="12"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm focus:ring-2 focus:ring-green-500 transition-all outline-none">
                            </div>

                            <div id="cuti_n1_container_create">
                                <label
                                    class="block mb-1 text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400">Tahun
                                    N-1</label>
                                <input type="number" name="sisa_cuti_n1" id="sisa_cuti_n1_create" placeholder="0"
                                    min="0" value="0"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm focus:ring-2 focus:ring-green-500 transition-all outline-none">
                            </div>

                            <div id="cuti_n2_container_create">
                                <label
                                    class="block mb-1 text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400">Tahun
                                    N-2</label>
                                <input type="number" name="sisa_cuti_n2" id="sisa_cuti_n2_create" placeholder="0"
                                    min="0" value="0"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm focus:ring-2 focus:ring-green-500 transition-all outline-none">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div
            class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex-none rounded-b-xl">
            <div class="flex justify-end space-x-3">
                <button type="button"
                    @click="document.getElementById('formCreatePegawai').reset(); toggleNIPField('PNS', 'create'); updateMasaKerjaLabel('PNS', 'create'); toggleLeaveFields('PNS', 'create')"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white transition-colors">
                    Reset
                </button>
                <button type="submit" form="formCreatePegawai"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
