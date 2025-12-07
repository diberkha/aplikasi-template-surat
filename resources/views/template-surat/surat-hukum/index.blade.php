<x-template-header title="Template Surat Hukum & Kerja Sama"
    subtitle="Pilih dan gunakan template surat hukum dan kerja sama yang tersedia" tableTitle="Daftar Template"
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
            <x-template-row :template="$template" :index="$loop->iteration" :actionButtons="['create']"
                createAction="openModal('modalCreateSK')" />
        @endforeach
    </x-template-table>
</x-template-header>

@include('template-surat.surat-hukum.sk-direktur.modal-create')

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
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