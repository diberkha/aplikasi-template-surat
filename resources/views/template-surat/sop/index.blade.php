<x-template-header title="Template Standar Operasional Prosedur (SOP)"
    subtitle="Pilih dan gunakan template Standar Operasional Prosedur (SOP) yang tersedia" tableTitle="Daftar Template Standar Operasional Prosedur (SOP)"
    searchPlaceholder="Cari template Standar Operasional Prosedur (SOP)...">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 dark:text-green-400 mr-2"></i>
                <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <x-template-table :templates="$templates" :columns="['no', 'template', 'actions']">
        @forelse($templates as $index => $template)
            <x-template-row :templates="$template" :index="$loop->iteration" :actionButtons="['create', 'delete']"
                createAction="openModal('modalCreateSOP', 'Standar Operasional Prosedur (SOP)', {{ $template->id_template_surat }})"
                deleteAction="openDeleteModal({{ $template->id_template_surat }}, '{!! addslashes($template->nama_template_surat ?? 'Template Standar Operasional Prosedur (SOP)') !!}')" />
        @empty
            <tr>
                <td colspan="3" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                    Belum ada template Standar Operasional Prosedur (SOP).
                </td>
            </tr>
        @endforelse
    </x-template-table>
</x-template-header>

@include('template-surat.sop.partials.modal-create')
@include('template-surat.sop.partials.modal-delete')
@include('template-surat.sop.partials.modal-preview-pdf')

<script>
    function openModal(id, templateName = null, templateId = null) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            if (templateId) {
                const tplInput = document.getElementById('template_surat_sop');
                if (tplInput) tplInput.value = templateId;
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
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('hidden');
    }

    function openDeleteModal(templateId, templateName) {
        const modal = document.getElementById('modalDeleteSOP');
        const nameField = document.getElementById('delete-sop-template-name');
        const form = document.getElementById('formDeleteTemplateSOP');
        if (nameField) nameField.textContent = templateName || '-';
        if (form) {
            const deleteUrlTemplate = '{{ route('template-surat.sop.destroy', ['template_surat' => '__ID__']) }}';
            form.action = deleteUrlTemplate.replace('__ID__', templateId);
        }
        if (modal) {
            const alpineData = Alpine?.$data ? Alpine.$data(modal) : null;
            if (alpineData) { alpineData.isOpen = true; }
            else { modal.classList.remove('hidden'); }
        }
    }
</script>
