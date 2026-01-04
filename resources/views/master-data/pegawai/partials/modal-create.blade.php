<div id="modalCreatePegawai" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full relative flex flex-col max-h-[90vh]">
        <button type="button" onclick="closeModal('modalCreatePegawai')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 z-10">
            <i class="fas fa-times"></i>
        </button>

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex-none">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Pegawai</h3>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form id="formCreatePegawai" action="{{ route('master-data.pegawai.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Jenis Pegawai <span
                                class="text-red-500">*</span></label>
                        <select name="jenis_pegawai" id="jenis_pegawai_create" required onchange="toggleNIPField(this.value, 'create'); updateMasaKerjaLabel(this.value, 'create')"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            <option value="PNS">PNS</option>
                            <option value="NON ASN">NON ASN</option>
                            <option value="PPPK">PPPK</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Pegawai <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                            placeholder="Masukkan nama lengkap...">
                    </div>
                    <div id="nip_field_create">
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">NIP <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nip" id="nip_input_create" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                            placeholder="Masukkan NIP...">
                    </div>
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Jabatan</label>
                        <input type="text" name="jabatan"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                            placeholder="Masukkan jabatan...">
                    </div>
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300" id="label_masa_kerja_create">Masa Kerja (TMT) <span
                            class="text-red-500">*</span></label>
                        <input type="date" name="masa_kerja" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>

                    <div class="border-t pt-4 mt-4 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Sisa Cuti Tahunan (Opsional)</h4>
                        
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-600 dark:text-gray-400">Tahun N (Saat Ini)</label>
                                <input type="number" name="sisa_cuti_n" placeholder="12" min="0" value="12"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                            </div>
                            
                            <div id="cuti_n1_container_create">
                                <label class="block mb-1 text-xs text-gray-600 dark:text-gray-400">Tahun N-1</label>
                                <input type="number" name="sisa_cuti_n1" placeholder="0" min="0" value="0"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                            </div>
                            
                            <div id="cuti_n2_container_create">
                                <label class="block mb-1 text-xs text-gray-600 dark:text-gray-400">Tahun N-2</label>
                                <input type="number" name="sisa_cuti_n2" placeholder="0" min="0" value="0"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                function toggleNIPField(jenisValue, context) {
                    const nipField = document.getElementById(`nip_field_${context}`);
                    const nipInput = document.getElementById(`nip_input_${context}`);
                    const cutiN1 = document.getElementById(`cuti_n1_container_${context}`);
                    const cutiN2 = document.getElementById(`cuti_n2_container_${context}`);
                    
                    if (jenisValue === 'NON ASN') {
                        if (nipField) nipField.style.display = 'none';
                        if (nipInput) {
                            nipInput.required = false;
                            nipInput.value = ''; 
                        }
                        if (cutiN1) cutiN1.style.display = 'none';
                        if (cutiN2) cutiN2.style.display = 'none';

                    } else if (jenisValue === 'PPPK') {
                        if (nipField) nipField.style.display = 'block';
                        if (nipInput) nipInput.required = true;
                        
                        if (cutiN1) cutiN1.style.display = 'none';
                        if (cutiN2) cutiN2.style.display = 'none';

                    } else { // PNS
                        if (nipField) nipField.style.display = 'block';
                        if (nipInput) nipInput.required = true;
                        
                        if (cutiN1) cutiN1.style.display = 'block';
                        if (cutiN2) cutiN2.style.display = 'block';
                    }
                }
                </script>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="document.getElementById('formCreatePegawai').reset()"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white text-sm">
                        Reset
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
