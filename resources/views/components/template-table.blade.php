@props([
    'templates' => [],
    'columns' => ['no', 'template', 'actions'],
    'showFooter' => true,
    'footerText' => null
])

<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                @if(in_array('no', $columns))
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                @endif

                @if(in_array('template', $columns))
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Template Surat</th>
                @endif

                @if(in_array('category', $columns))
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipe Surat</th>
                @endif

                @if(in_array('updated', $columns))
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diperbarui</th>
                @endif

                @if(in_array('actions', $columns))
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                @endif
            </tr>
        </thead>

        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            {{ $slot }}
        </tbody>
    </table>
</div>

@if($showFooter)
    <x-template-pagination :templates="$templates" />
@endif
