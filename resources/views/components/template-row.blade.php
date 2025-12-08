@props([
    'templates' => [],
    'index' => 1,
    'showNumber' => true,
    'showDescription' => true,
    'showCategory' => false,
    'showUpdatedAt' => false,
    'actionButtons' => ['create', 'download'],
    'createAction' => null,
    'deleteAction' => null,
])

@php
    $templatesData = $templates;
    if (is_object($templates)) {
        $templatesData = method_exists($templates, 'toArray') ? $templates->toArray() : (array) $templates;
    } elseif (!is_array($templates)) {
        $templatesData = [];
    }

    $defaultTemplate = [
        'id' => null,
        'name' => 'Surat Keputusan Direktur',
        'description' => 'Template surat keputusan direktur',
        'icon' => 'file-alt',
        'iconColor' => 'blue',
        'iconBgColor' => 'blue-100',
        'iconDarkBgColor' => 'blue-900',
        'iconTextColor' => 'blue-600',
        'iconDarkTextColor' => 'blue-400',
        'category' => null,
        'updated_at' => null
    ];

    $template = array_merge($defaultTemplate, $templatesData);
@endphp

<tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
    @if ($showNumber)
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="text-sm text-gray-900 dark:text-white font-medium">{{ $index }}</span>
        </td>
    @endif

    <td class="px-6 py-4">
        <div class="flex items-center">
            <div class="p-2 bg-{{ $template['iconBgColor'] }} dark:bg-{{ $template['iconDarkBgColor'] }} rounded-lg mr-3">
                <i class="fas fa-{{ $template['icon'] }} text-{{ $template['iconTextColor'] }} dark:text-{{ $template['iconDarkTextColor'] }}"></i>
            </div>

            <div>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $template['name'] }}</span>

                @if ($showDescription && $template['description'])
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ $template['description'] }}
                    </p>
                @endif
            </div>
        </div>
    </td>

    @if ($showCategory && $template['category'])
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                {{ $template['category'] }}
            </span>
        </td>
    @endif

    @if ($showUpdatedAt && $template['updated_at'])
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ $template['updated_at'] }}
            </span>
        </td>
    @endif

    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center space-x-2">

            @if (in_array('create', $actionButtons))
                <button 
                    @if($createAction) onclick="{{ $createAction }}" @endif
                    class="inline-flex items-center p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                    title="Buat Surat">
                    <i class="fas fa-plus text-sm"></i>
                </button>
            @endif

            @if (in_array('delete', $actionButtons))
                <button 
                    @if($deleteAction) onclick="{{ $deleteAction }}" @endif
                    class="inline-flex items-center p-1.5 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                    title="Hapus Template">
                    <i class="fas fa-trash text-sm"></i>
                </button>
            @endif

            @if (in_array('download', $actionButtons))
                <button class="inline-flex items-center p-1.5 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors"
                        title="Download Template">
                    <i class="fas fa-download text-sm"></i>
                </button>
            @endif

            @if (in_array('preview', $actionButtons))
                <button class="inline-flex items-center p-1.5 text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 transition-colors"
                        title="Pratinjau">
                    <i class="fas fa-eye text-sm"></i>
                </button>
            @endif

            @if (in_array('edit', $actionButtons))
                <button class="inline-flex items-center p-1.5 text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors"
                        title="Edit">
                    <i class="fas fa-edit text-sm"></i>
                </button>
            @endif

        </div>
    </td>
</tr>
