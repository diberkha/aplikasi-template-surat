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
        <form action="{{ route('template-surat.hukum.store') }}" method="POST" id="skDirekturForm" onsubmit="submitFormAJAX(event)">
            @csrf

            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">

                <!-- JUDUL SURAT -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Judul Surat <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="judul_surat" required
                        placeholder="Contoh: KEPUTUSAN DIREKTUR RUMAH SAKIT UMUM..."
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>

                <!-- NOMOR SURAT -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Nomor Surat <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nomor_surat" required placeholder="Contoh: 006/SHKS/VI/2024"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Nomor surat tidak boleh sama dengan surat yang sudah ada
                    </p>
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

                <!-- TEMPLATE SURAT (Hidden) -->
                <input type="hidden" name="template_id" id="template_surat_sk">

                <!-- KEPUTUSAN -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Keputusan <span class="text-red-500">*</span>
                    </label>
                    <select name="id_regulasi" id="keputusan_regulasi" required onchange="loadRegulasiData()"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                               dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Keputusan --</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        <i class="fas fa-info-circle mr-1"></i>
                        Data Menimbang dan Mengingat akan otomatis terisi berdasarkan keputusan yang dipilih
                    </p>
                </div>

                <!-- MENIMBANG (Auto-filled) -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Menimbang <span class="text-red-500">*</span>
                        <span class="text-xs font-normal text-blue-600 dark:text-blue-400 ml-2">
                            <i class="fas fa-robot mr-1"></i>Otomatis dari Regulasi
                        </span>
                    </label>
                    <div class="relative">
                        <textarea name="menimbang" id="menimbangSK" rows="5" required readonly
                            placeholder="Pilih keputusan untuk mengisi data menimbang otomatis..."
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y bg-gray-50 dark:bg-gray-900"></textarea>
                        <div id="counterMenimbangSK" class="absolute bottom-2 right-2 text-xs text-gray-500">0 karakter
                        </div>
                    </div>
                </div>

                <!-- MENGINGAT (Auto-filled) -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Mengingat <span class="text-red-500">*</span>
                        <span class="text-xs font-normal text-blue-600 dark:text-blue-400 ml-2">
                            <i class="fas fa-robot mr-1"></i>Otomatis dari Regulasi
                        </span>
                    </label>
                    <div class="relative">
                        <textarea name="mengingat" id="mengingatSK" rows="5" required readonly
                            placeholder="Pilih keputusan untuk mengisi data mengingat otomatis..."
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y bg-gray-50 dark:bg-gray-900"></textarea>
                        <div id="counterMengingatSK" class="absolute bottom-2 right-2 text-xs text-gray-500">0 karakter
                        </div>
                    </div>
                </div>

                <!-- MEMUTUSKAN (Dynamic Fields) -->
                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Memutuskan <span class="text-red-500">*</span>
                    </label>
                    <div id="memutuskanContainer" class="space-y-3">
                        <div class="memutuskan-item">
                            <label class="block mb-1 text-sm text-gray-600 dark:text-gray-400">Kesatu</label>
                            <textarea name="memutuskan[]" rows="2" required
                                placeholder="Isi keputusan kesatu..."
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        </div>
                        <div class="memutuskan-item">
                            <label class="block mb-1 text-sm text-gray-600 dark:text-gray-400">Kedua</label>
                            <textarea name="memutuskan[]" rows="2" required
                                placeholder="Isi keputusan kedua..."
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        </div>
                        <div class="memutuskan-item">
                            <label class="block mb-1 text-sm text-gray-600 dark:text-gray-400">Ketiga</label>
                            <textarea name="memutuskan[]" rows="2" required
                                placeholder="Isi keputusan ketiga..."
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        </div>
                    </div>
                    <button type="button" onclick="addMemutuskanField()" 
                        class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Keputusan
                    </button>
                </div>

                <!-- TEMPAT & TANGGAL -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Lokasi Dibuat <span
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

                <!-- JABATAN & NAMA PEMBUAT -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Jabatan Pembuat <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="jabatan_pembuat" required placeholder="Direktur RSUD"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Nama Pembuat <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_pembuat" required placeholder="Dr. Nama Lengkap, Sp.X"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-3">
                <button type="button" onclick="resetFormSK()"
                    class="px-5 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    Reset
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
    let memutuskanCounter = 3;

    // Load regulasi data when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadKeputusanOptions();
        
        const menimbangSK = document.getElementById('menimbangSK');
        const mengingatSK = document.getElementById('mengingatSK');

        menimbangSK.addEventListener('input', () => updateCharCount(menimbangSK, 'counterMenimbangSK'));
        mengingatSK.addEventListener('input', () => updateCharCount(mengingatSK, 'counterMengingatSK'));

        // Form validation on submit
        document.getElementById('skDirekturForm').addEventListener('submit', function(e) {
            const templateId = document.getElementById('template_surat_sk').value;
            const regulasiId = document.getElementById('keputusan_regulasi').value;
            
            if (!templateId || !regulasiId) {
                e.preventDefault();
                alert('Silakan pilih keputusan terlebih dahulu untuk mengisi template dan data regulasi');
                return false;
            }
        });
    });

    // Load keputusan options from regulasi
    async function loadKeputusanOptions() {
        try {
            const response = await fetch('/api/regulasi/keputusan-list');
            const data = await response.json();
            
            const select = document.getElementById('keputusan_regulasi');
            select.innerHTML = '<option value="">-- Pilih Keputusan --</option>';
            
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id_regulasi;
                option.textContent = item.keputusan_label;
                option.dataset.templateId = item.id_template_surat;
                select.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading keputusan:', error);
        }
    }

    // Load regulasi data when keputusan is selected
    async function loadRegulasiData() {
        const select = document.getElementById('keputusan_regulasi');
        const regulasiId = select.value;
        
        if (!regulasiId) {
            document.getElementById('menimbangSK').value = '';
            document.getElementById('mengingatSK').value = '';
            document.getElementById('template_surat_sk').value = '';
            updateCharCount(document.getElementById('menimbangSK'), 'counterMenimbangSK');
            updateCharCount(document.getElementById('mengingatSK'), 'counterMengingatSK');
            return;
        }

        try {
            const response = await fetch(`/api/regulasi/${regulasiId}/data`);
            const data = await response.json();
            
            // Fill in the form fields
            document.getElementById('menimbangSK').value = data.menimbang;
            document.getElementById('mengingatSK').value = data.mengingat;
            document.getElementById('template_surat_sk').value = data.id_template_surat;
            
            // Update character counters
            updateCharCount(document.getElementById('menimbangSK'), 'counterMenimbangSK');
            updateCharCount(document.getElementById('mengingatSK'), 'counterMengingatSK');
            
        } catch (error) {
            console.error('Error loading regulasi data:', error);
            alert('Gagal memuat data regulasi. Silakan coba lagi.');
        }
    }

    // Add new memutuskan field
    function addMemutuskanField() {
        memutuskanCounter++;
        const container = document.getElementById('memutuskanContainer');
        
        const labels = ['Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam', 'Ketujuh', 'Kedelapan', 'Kesembilan', 'Kesepuluh'];
        const label = labels[memutuskanCounter - 1] || `Ke-${memutuskanCounter}`;
        
        const newField = document.createElement('div');
        newField.className = 'memutuskan-item flex gap-2';
        newField.innerHTML = `
            <div class="flex-1">
                <label class="block mb-1 text-sm text-gray-600 dark:text-gray-400">${label}</label>
                <textarea name="memutuskan[]" rows="2" required
                    placeholder="Isi keputusan ${label.toLowerCase()}..."
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
            </div>
            <button type="button" onclick="removeMemutuskanField(this)" 
                class="mt-6 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
        `;
        
        container.appendChild(newField);
    }

    // Remove memutuskan field
    function removeMemutuskanField(button) {
        const item = button.closest('.memutuskan-item');
        item.remove();
        memutuskanCounter--;
    }

    // Reset form
    function resetFormSK() {
        const form = document.getElementById('skDirekturForm');
        form.reset();
        
        // Reset memutuskan fields to initial 3 fields
        const container = document.getElementById('memutuskanContainer');
        container.innerHTML = `
            <div class="memutuskan-item">
                <label class="block mb-1 text-sm text-gray-600 dark:text-gray-400">Kesatu</label>
                <textarea name="memutuskan[]" rows="2" required
                    placeholder="Isi keputusan kesatu..."
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
            </div>
            <div class="memutuskan-item">
                <label class="block mb-1 text-sm text-gray-600 dark:text-gray-400">Kedua</label>
                <textarea name="memutuskan[]" rows="2" required
                    placeholder="Isi keputusan kedua..."
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
            </div>
            <div class="memutuskan-item">
                <label class="block mb-1 text-sm text-gray-600 dark:text-gray-400">Ketiga</label>
                <textarea name="memutuskan[]" rows="2" required
                    placeholder="Isi keputusan ketiga..."
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
            </div>
        `;
        memutuskanCounter = 3;
        
        // Reset character counters
        document.getElementById('counterMenimbangSK').textContent = '0 karakter';
        document.getElementById('counterMengingatSK').textContent = '0 karakter';
        
        // Reset border colors if any field was marked as error
        const allInputs = form.querySelectorAll('input, textarea, select');
        allInputs.forEach(input => {
            input.style.borderColor = '';
            input.style.borderWidth = '';
        });
    }

    function updateCharCount(textarea, counterId) {
        const counter = document.getElementById(counterId);
        if (counter) {
            counter.textContent = textarea.value.length + ' karakter';
        }
    }

    // Submit form via AJAX
    function submitFormAJAX(event) {
        event.preventDefault();
        
        const form = document.getElementById('skDirekturForm');
        
        // Validate memutuskan fields
        const memutuskanFields = document.querySelectorAll('textarea[name="memutuskan[]"]');
        let hasEmptyMemutuskan = false;
        memutuskanFields.forEach((field, index) => {
            if (!field.value.trim()) {
                field.style.borderColor = 'red';
                hasEmptyMemutuskan = true;
            } else {
                field.style.borderColor = '';
            }
        });
        
        if (hasEmptyMemutuskan) {
            alert('Semua field Memutuskan harus diisi!');
            return;
        }
        
        const formData = new FormData(form);
        
        // Debug: Log all form data
        console.log('Form data entries:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }
        
        // Disable submit button
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            // Try to parse as JSON first
            return response.json().then(data => ({
                status: response.status,
                ok: response.ok,
                data: data
            })).catch(err => {
                // If JSON parsing fails, return text response
                return response.text().then(text => ({
                    status: response.status,
                    ok: response.ok,
                    text: text,
                    parseError: true
                }));
            });
        })
        .then(result => {
            console.log('Response result:', result);
            
            if (result.parseError) {
                console.error('Parse error - response text:', result.text);
                alert('Error: Response parsing failed. Check console.');
                return;
            }
            
            if (!result.ok) {
                console.error('Server error - Status:', result.status, 'Data:', result.data);
                
                // Display validation errors
                if (result.data.errors) {
                    // Map technical field names to user-friendly names
                    const fieldLabels = {
                        'judul_surat': 'Judul Surat',
                        'nomor_surat': 'Nomor Surat',
                        'tentang': 'Tentang',
                        'identitas_penetap': 'Identitas Penetap',
                        'id_regulasi': 'Keputusan',
                        'menimbang': 'Menimbang',
                        'mengingat': 'Mengingat',
                        'memutuskan': 'Memutuskan',
                        'tempat_dibuat': 'Tempat Dibuat',
                        'tanggal_dibuat': 'Tanggal Dibuat',
                        'jabatan_pembuat': 'Jabatan Pembuat',
                        'nama_pembuat': 'Nama Pembuat'
                    };
                    
                    let errorMsg = 'Validasi Gagal:\n\n';
                    for (let [field, messages] of Object.entries(result.data.errors)) {
                        const fieldLabel = fieldLabels[field] || field;
                        const messageText = Array.isArray(messages) ? messages.join(', ') : messages;
                        errorMsg += `❌ ${fieldLabel}: ${messageText}\n`;
                        
                        // Highlight error field with red border
                        const inputField = form.querySelector(`[name="${field}"]`);
                        if (inputField) {
                            inputField.style.borderColor = 'red';
                            inputField.style.borderWidth = '2px';
                            // Reset border after 3 seconds
                            setTimeout(() => {
                                inputField.style.borderColor = '';
                                inputField.style.borderWidth = '';
                            }, 3000);
                        }
                    }
                    alert(errorMsg);
                } else {
                    alert('Error: ' + (result.data?.message || 'Server error: ' + result.status));
                }
                return;
            }
            
            if (result.data.success) {
                // Close create modal
                closeModal('modalCreateSK');
                
                // Reset form
                form.reset();
                memutuskanCounter = 3;
                
                // Show success message
                showSuccessMessage('Surat berhasil dibuat!');
                
                // Open preview modal after brief delay
                setTimeout(() => {
                    openPreviewPDF(result.data.file_url, result.data.nomor_surat);
                }, 500);
            } else {
                alert('Gagal membuat surat: ' + (result.data.message || 'Kesalahan tidak diketahui'));
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Terjadi kesalahan: ' + error.message);
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan';
        });
    }

    // Show success message
    function showSuccessMessage(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center animate-pulse';
        alertDiv.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }
</script>