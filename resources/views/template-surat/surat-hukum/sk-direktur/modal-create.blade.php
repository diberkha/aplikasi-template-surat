<div id="modalCreateSK" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-3xl w-full">

        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modalTitle">Buat Surat Hukum</h3>
            <button @click="closeModal('modalCreateSK')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form action="{{ route('template-surat.hukum.store') }}" method="POST" id="skDirekturForm" onsubmit="submitFormAJAX(event)">
            @csrf

            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Judul Surat <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="judul_surat" required
                        placeholder="Contoh: Keputusan Direktur Rumah Sakit Umum"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>

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

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Tentang <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="tentang" required placeholder="Contoh: Pembentukan Tim Kendali Mutu Kendali Biaya (KMKB)"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                </div>

                <input type="hidden" name="template_id" id="template_surat_sk">

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">
                            Menimbang <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <textarea name="menimbang" id="menimbangSK" rows="5" required
                                placeholder="Contoh: a. bahwa dalam rangka mendukung program pemerintah di bidang pelayanan kesehatan melalui Jaminan Kesehatan Nasional yang dikelola oleh Badan Penyelenggara Jaminan Sosial (BPJS) bidang kesehatan, rumah sakit diminta untuk berperan serta dalam memberikan pelayanan kesehatan;&#10;b. bahwa untuk pemantauan mutu dan pengendalian biaya dalam pelaksanaan Program Jaminan Kesehatan Nasional, perlu dibentuk Tim Kendali Mutu Kendali Biaya JKN RSUD dr. Soeratno Gemolong;&#10;c. bahwa berdasarkan pertimbangan sebagaimana dimaksud huruf a dan b tersebut di atas maka perlu diatur dan ditetapkan dengan Surat Keputusan Direktur RSUD dr. Soeratno Gemolong."
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                            <div id="counterMenimbangSK" class="absolute bottom-2 right-2 text-xs text-gray-500">0 karakter
                            </div>
                        </div>
                    </div>

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Mengingat <span class="text-red-500">*</span>
                    </label>
                    <input type="hidden" name="mengingat_check" id="mengingat_check">
                    
                    <!-- Search Bar -->
                    <div class="mb-3">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="searchMengingat" placeholder="Cari regulasi..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                onkeyup="filterMengingat()">
                        </div>
                    </div>
                    
                    <div id="mengingatList" class="border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 bg-white max-h-64 overflow-y-auto">
                        <div class="text-sm text-gray-500 dark:text-gray-400 text-center py-8">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Memuat data
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        <i class="fas fa-info-circle mr-1"></i>
                        Pilih satu atau lebih regulasi
                    </p>
                </div>

                <div>
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Memutuskan <span class="text-red-500">*</span>
                    </label>
                    <div id="memutuskanContainer" class="space-y-3">
                        <div class="memutuskan-item flex gap-3">
                            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">Menetapkan :</label>
                            <textarea name="menetapkan" id="menetapkan_input" rows="2" required
                                class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        </div>
                        <div class="memutuskan-item flex gap-3">
                            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">Kesatu :</label>
                            <textarea name="memutuskan[]" rows="2" required
                                class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        </div>
                        <div class="memutuskan-item flex gap-3">
                            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">Kedua :</label>
                            <textarea name="memutuskan[]" rows="2" required
                                class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        </div>
                        <div class="memutuskan-item flex gap-3">
                            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">Ketiga :</label>
                            <textarea name="memutuskan[]" rows="2" required
                                class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                        </div>
                    </div>
                    <button type="button" onclick="addMemutuskanField()" 
                        class="mt-3 inline-flex items-center px-3 py-2 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Memutuskan
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Lokasi Surat Dibuat <span
                            class="text-red-500">*</span></label>
                        <input type="text" name="tempat_dibuat" required placeholder="Contoh: Gemolong"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>

                        <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Tanggal Surat Dibuat <span
                            class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_dibuat" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                </div>

            </div>

            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-3">
                <button type="button" onclick="resetFormSK()"
                    class="px-5 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    Reset
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let memutuskanCounter = 3;

    document.addEventListener('DOMContentLoaded', function() {
        loadRegulasiOptions();
        
        const menimbangSK = document.getElementById('menimbangSK');

        menimbangSK.addEventListener('input', () => updateCharCount(menimbangSK, 'counterMenimbangSK'));

        document.getElementById('skDirekturForm').addEventListener('submit', function(e) {
            const mengingatCheckboxes = document.querySelectorAll('input[name="mengingat[]"]:checked');
            
            if (mengingatCheckboxes.length === 0) {
                e.preventDefault();
                alert('Silakan pilih minimal satu Mengingat');
                return false;
            }
        });
    });

    async function loadRegulasiOptions() {
        try {
            const response = await fetch('/api/regulasi');
            let data = await response.json();
            
            if (data.data) {
                data = data.data;
            }
            
            const listContainer = document.getElementById('mengingatList');
            listContainer.innerHTML = ''; 
            
            if (!Array.isArray(data) || data.length === 0) {
                listContainer.innerHTML = '<div class="text-sm text-gray-500 dark:text-gray-400 text-center py-4"><i class="fas fa-exclamation-circle mr-2"></i>Tidak ada data regulasi</div>';
                return;
            }
            
            data.forEach((item, index) => {
                const checkboxItem = document.createElement('div');
                checkboxItem.className = 'mengingat-item flex items-start mb-2 pb-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0';
                checkboxItem.innerHTML = `
                    <input type="checkbox" name="mengingat[]" value="${item.id_regulasi}" 
                        id="mengingat_${index}" class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded cursor-pointer"
                        onchange="updateMengingatCheck()">
                    <label for="mengingat_${index}" class="ml-3 flex-1 cursor-pointer">
                        <span class="text-sm text-gray-700 dark:text-gray-300 font-medium block">${item.isi_regulasi}</span>
                    </label>
                `;
                listContainer.appendChild(checkboxItem);
            });
        } catch (error) {
            console.error('Error loading regulasi options:', error);
            const listContainer = document.getElementById('mengingatList');
            listContainer.innerHTML = '<div class="text-sm text-red-500 dark:text-red-400 text-center py-4"><i class="fas fa-exclamation-circle mr-2"></i>Gagal memuat data</div>';
        }
    }

    function updateMengingatCheck() {
        const checkboxes = document.querySelectorAll('input[name="mengingat[]"]:checked');
        document.getElementById('mengingat_check').value = checkboxes.length > 0 ? 'yes' : '';
    }

    function filterMengingat() {
        const searchValue = document.getElementById('searchMengingat').value.toLowerCase();
        const items = document.querySelectorAll('#mengingatList .mengingat-item');
        let visibleCount = 0;
        
        items.forEach(item => {
            const label = item.querySelector('label');
            if (label) {
                const text = label.textContent.toLowerCase();
                if (text.includes(searchValue)) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            }
        });

        // Show "no results" message if nothing found
        const noResultMsg = document.getElementById('noMengingatResult');
        if (visibleCount === 0 && items.length > 0) {
            if (!noResultMsg) {
                const msg = document.createElement('div');
                msg.id = 'noMengingatResult';
                msg.className = 'text-center text-gray-500 dark:text-gray-400 py-4';
                msg.innerHTML = '<i class="fas fa-search mr-2"></i>Tidak ada regulasi yang cocok';
                document.getElementById('mengingatList').appendChild(msg);
            }
        } else if (noResultMsg) {
            noResultMsg.remove();
        }
    }

    function addMemutuskanField() {
        memutuskanCounter++;
        const container = document.getElementById('memutuskanContainer');
        
        const labels = ['Kesatu', 'Kedua', 'Ketiga', 'Keempat', 'Kelima', 'Keenam', 'Ketujuh', 'Kedelapan', 'Kesembilan', 'Kesepuluh'];
        const label = labels[memutuskanCounter - 1] || `Ke-${memutuskanCounter}`;
        const labelUpper = label.toUpperCase();
        
        const newField = document.createElement('div');
        newField.className = 'memutuskan-item flex gap-3';
        newField.innerHTML = `
            <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">${labelUpper} :</label>
            <div class="flex-1 flex gap-2">
                <textarea name="memutuskan[]" rows="2" required
                    class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
                <button type="button" onclick="removeMemutuskanField(this)" 
                    class="mt-0 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                    title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        
        container.appendChild(newField);
    }

    function removeMemutuskanField(button) {
        const item = button.closest('.memutuskan-item');
        item.remove();
        memutuskanCounter--;
    }

    function resetFormSK() {
        const form = document.getElementById('skDirekturForm');
        form.reset();
        
        const container = document.getElementById('memutuskanContainer');
        container.innerHTML = `
            <div class="memutuskan-item flex gap-3">
                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">MENETAPKAN :</label>
                <textarea name="menetapkan" id="menetapkan_input" rows="2" required
                    class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
            </div>
            <div class="memutuskan-item flex gap-3">
                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">KESATU :</label>
                <textarea name="memutuskan[]" rows="2" required
                    class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
            </div>
            <div class="memutuskan-item flex gap-3">
                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">KEDUA :</label>
                <textarea name="memutuskan[]" rows="2" required
                    class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
            </div>
            <div class="memutuskan-item flex gap-3">
                <label class="mt-3 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap w-28 flex-shrink-0">KETIGA :</label>
                <textarea name="memutuskan[]" rows="2" required
                    class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white resize-y"></textarea>
            </div>
        `;
        memutuskanCounter = 3;
        
        document.getElementById('counterMenimbangSK').textContent = '0 karakter';
        
        const mengingatCheckboxes = document.querySelectorAll('input[name="mengingat[]"]');
        mengingatCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateMengingatCheck();
        
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

    function submitFormAJAX(event) {
        event.preventDefault();
        
        const form = document.getElementById('skDirekturForm');
        
        const allTextareas = document.querySelectorAll('#memutuskanContainer textarea');
        let hasEmptyField = false;
        allTextareas.forEach((field, index) => {
            if (!field.value.trim()) {
                field.style.borderColor = 'red';
                hasEmptyField = true;
            } else {
                field.style.borderColor = '';
            }
        });
        
        if (hasEmptyField) {
            alert('Semua field Memutuskan (termasuk Menetapkan) harus diisi!');
            return;
        }
        
        const formData = new FormData(form);
        
        console.log('Form data entries:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }
        
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan';
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            return response.json().then(data => ({
                status: response.status,
                ok: response.ok,
                data: data
            })).catch(err => {
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
                
                if (result.data.errors) {
                    const fieldLabels = {
                        'judul_surat': 'Judul Surat',
                        'nomor_surat': 'Nomor Surat',
                        'tentang': 'Tentang',
                        'menimbang': 'Menimbang',
                        'mengingat': 'Mengingat',
                        'menetapkan': 'Menetapkan',
                        'memutuskan': 'Memutuskan',
                        'tempat_dibuat': 'Tempat Surat Dibuat',
                        'tanggal_dibuat': 'Tanggal Surat Dibuat'
                    };
                    
                    let errorMsg = 'Validasi Gagal:\n\n';
                    for (let [field, messages] of Object.entries(result.data.errors)) {
                        const fieldLabel = fieldLabels[field] || field;
                        const messageText = Array.isArray(messages) ? messages.join(', ') : messages;
                        errorMsg += `❌ ${fieldLabel}: ${messageText}\n`;
                        
                        const inputField = form.querySelector(`[name="${field}"]`);
                        if (inputField) {
                            inputField.style.borderColor = 'red';
                            inputField.style.borderWidth = '2px';
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
                closeModal('modalCreateSK');
                
                form.reset();
                memutuskanCounter = 3;
                
                showSuccessMessage('Surat berhasil dibuat!');
                
                setTimeout(() => {
                    openPreviewPDF(result.data.file_url, result.data.nomor_surat, result.data.surat_id);
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
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan';
        });
    }

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