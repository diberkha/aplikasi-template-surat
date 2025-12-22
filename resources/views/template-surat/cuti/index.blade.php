<x-template-header title="Template Surat Izin Cuti"
    subtitle="Pilih dan gunakan template surat izin cuti yang tersedia" tableTitle="Daftar Template Surat Izin Cuti"
    searchPlaceholder="Cari template cuti...">

    <x-template-table :templates="$templates" :columns="['no','template','actions']">
        @forelse($templates as $index => $template)
            @php
                $kategori = strtoupper(str_replace('Surat Izin Cuti ','',$template->nama_template_surat));
                if ($kategori === 'PPPK') {
                    $modalId = 'modalCreateCutiPPPK';
                    $functionName = 'openCutiModalPPPK';
                } elseif ($kategori === 'NON ASN') {
                    $modalId = 'modalCreateCutiNonASN';
                    $functionName = 'openCutiModalNonASN';
                } else {
                    $modalId = 'modalCreateCuti';
                    $functionName = 'openCutiModal';
                }
            @endphp
            <x-template-row :templates="$template" :index="$loop->iteration" :actionButtons="['create','delete']"
                createAction="{{ $functionName }}('{{ $modalId }}', '{{ $kategori }}', {{ $template->id_template_surat }})"
                deleteAction="openDeleteModal({{ $template->id_template_surat }}, '{!! addslashes($template->nama_template_surat) !!}')" />
        @empty
            <tr>
                <td colspan="3" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">Belum ada template cuti.</td>
            </tr>
        @endforelse
    </x-template-table>
</x-template-header>

@include('template-surat.cuti.partials.modal-create-pns')
@include('template-surat.cuti.partials.modal-create-pppk')
@include('template-surat.cuti.partials.modal-create-nonasn')
@include('template-surat.sop.partials.modal-delete')
@include('template-surat.sop.partials.modal-preview-pdf')

<script>
    function openCutiModal(id, kategori, templateId) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('hidden');
        const tplInput = document.getElementById('template_surat_cuti');
        const kategoriInput = document.getElementById('kategori_cuti');
        if (tplInput) tplInput.value = templateId;
        if (kategoriInput) kategoriInput.value = kategori;
        const titleElement = modal.querySelector('#modalTitle');
        if (titleElement) titleElement.textContent = 'Buat Surat Izin Cuti ' + kategori;
    }

    function openCutiModalPPPK(id, kategori, templateId) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('hidden');
        const tplInput = document.getElementById('template_surat_cuti_pppk');
        if (tplInput) tplInput.value = templateId;
    }

    function openCutiModalNonASN(id, kategori, templateId) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('hidden');
        const tplInput = document.getElementById('template_surat_cuti_nonasn');
        if (tplInput) tplInput.value = templateId;
    }

    function closeModal(id) { const m = document.getElementById(id); if (m) m.classList.add('hidden'); }
</script>
