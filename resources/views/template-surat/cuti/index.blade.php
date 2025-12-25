<x-template-header title="Template Surat Izin Cuti"
    subtitle="Pilih dan gunakan template surat izin cuti yang tersedia" tableTitle="Daftar Template Surat Izin Cuti"
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
            @php
                $modalId = '';
                $deleteFunc = '';
                if (str_contains($template->nama_template_surat, 'PNS')) {
                    $modalId = 'modalCreateCuti';
                    $deleteFunc = 'openDeleteModalPNS';
                } elseif (str_contains($template->nama_template_surat, 'PPPK')) {
                    $modalId = 'modalCreateCutiPPPK';
                    $deleteFunc = 'openDeleteModalPPPK';
                } else {
                    $modalId = 'modalCreateCutiNonASN';
                    $deleteFunc = 'openDeleteModalNonASN';
                }
            @endphp
            <x-template-row :templates="$template" :index="$loop->iteration" :actionButtons="['create', 'delete']"
                createAction="openCutiModal('{{ $modalId }}', '{{ $template->nama_template_surat }}', {{ $template->id_template_surat }})"
                deleteAction="{{ $deleteFunc }}({{ $template->id_template_surat }}, '{{ addslashes($template->nama_template_surat) }}')" />
        @endforeach
    </x-template-table>
</x-template-header>

@include('template-surat.cuti.cuti-pns.partials.modal-create')
@include('template-surat.cuti.cuti-pns.partials.modal-delete')
@include('template-surat.cuti.cuti-pns.partials.modal-preview')

@include('template-surat.cuti.cuti-pppk.partials.modal-create')
@include('template-surat.cuti.cuti-pppk.partials.modal-delete')
@include('template-surat.cuti.cuti-pppk.partials.modal-preview')

@include('template-surat.cuti.cuti-nonasn.partials.modal-create')
@include('template-surat.cuti.cuti-nonasn.partials.modal-delete')
@include('template-surat.cuti.cuti-nonasn.partials.modal-preview')

<script>
    function openCutiModal(modalId, templateName, templateId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            
            // Set template ID based on modal type
            let inputId = 'template_surat_cuti';
            if (modalId === 'modalCreateCutiPPPK') inputId = 'template_surat_cuti_pppk';
            if (modalId === 'modalCreateCutiNonASN') inputId = 'template_surat_cuti_nonasn';
            
            const input = document.getElementById(inputId);
            if (input) input.value = templateId;
            
            // Set Title
            let titleId = 'modalTitle';
            if (modalId === 'modalCreateCutiPPPK') titleId = 'modalTitlePPPK';
            if (modalId === 'modalCreateCutiNonASN') titleId = 'modalTitleNonASN';
            
            const titleEl = document.getElementById(titleId);
            if (titleEl) titleEl.textContent = 'Buat ' + templateName;
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('hidden');
    }
</script>
