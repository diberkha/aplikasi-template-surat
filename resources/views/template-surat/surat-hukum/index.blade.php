<x-template-header title="Template Surat Hukum & Kerja Sama"
    subtitle="Pilih dan gunakan template surat hukum & kerja sama yang tersedia" tableTitle="Daftar Template"
    searchPlaceholder="Cari template...">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 dark:text-green-400 mr-2"></i>
                <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <x-template-table :templates="$templates" :columns="['no', 'template', 'actions']">
        @foreach($templates as $index => $template)
            <x-template-row :templates="$template" :index="$loop->iteration" :actionButtons="['create', 'delete']"
                createAction="openModal('modalCreateSK', 'Surat Keputusan Direktur', {{ $template->id_template_surat }})"
                deleteAction="openDeleteModal('{!! addslashes($template->nama_template_surat ?? 'Template') !!}')" />
        @endforeach
    </x-template-table>
</x-template-header>

@include('template-surat.surat-hukum.sk-direktur.modal-create')
@include('template-surat.surat-hukum.sk-direktur.modal-delete')
@include('template-surat.surat-hukum.sk-direktur.modal-preview-pdf')

<script>
    function openModal(id, templateName = null, templateId = null) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            
            if (templateId) {
                document.getElementById('template_surat_sk').value = templateId;
            }
            
            if (templateName) {
                const titleElement = modal.querySelector('#modalTitle');
                if (titleElement) {
                    const textarea = document.createElement('textarea');
                    textarea.innerHTML = templateName;
                    const decodedName = textarea.value;
                    titleElement.textContent = 'Buat ' + decodedName;
                }
            }
        }
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function openDeleteModal(templateName) {
        const modal = document.getElementById('modalDeleteTemplate');
        const nameField = document.getElementById('delete-template-name');
        if (nameField) {
            nameField.textContent = templateName || '-';
        }
        if (modal) {
            const alpineData = Alpine.$data(modal);
            if (alpineData) {
                alpineData.isOpen = true;
            } else {
                modal.classList.remove('hidden');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const menimbangSK = document.getElementById('menimbangSK');
        const mengingatSK = document.getElementById('mengingatSK');
        const counterMenimbang = document.getElementById('counterMenimbangSK');
        const counterMengingat = document.getElementById('counterMengingatSK');

        if (menimbangSK && counterMenimbang) {
            menimbangSK.addEventListener('input', function () {
                counterMenimbang.textContent = this.value.length + ' karakter';
            });
        }

        if (mengingatSK && counterMengingat) {
            mengingatSK.addEventListener('input', function () {
                counterMengingat.textContent = this.value.length + ' karakter';
            });
        }
    });
</script>
