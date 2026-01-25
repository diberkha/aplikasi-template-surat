<?php

return [
    'pdf' => [
        'enabled' => true,
        'binary' => env('WKHTML_PDF_BINARY', env('WKHTMLTOPDF_BINARY', storage_path('app/bin/wkhtmltopdf.exe'))),
        'timeout' => false,
        'options' => [
            'encoding' => 'UTF-8',
            'enable-local-file-access' => true,
            'no-outline' => true,
            'margin-top' => '0mm',
            'margin-right' => '0mm',
            'margin-bottom' => '0mm',
            'margin-left' => '0mm',
            'dpi' => 96,
        ],
        'env' => [],
    ],
    'image' => [
        'enabled' => false,
        'binary' => env('WKHTML_IMG_BINARY', env('WKHTMLTOIMAGE_BINARY', storage_path('app/bin/wkhtmltoimage.exe'))),
        'timeout' => false,
        'options' => [],
        'env' => [],
    ],
];
