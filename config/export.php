<?php

return [
    'temporary_files_path' => storage_path('app'),
    'timeout' => 60 * 5,
    'csv' => [
        'delimiter' => ',',
        'enclosure' => '"',
        'escape_char' => '\\',
        'input_encoding' => 'UTF-8',
        'output_encoding' => 'UTF-8',
    ],
    'excel' => [
        'format' => 'xlsx',
        'extension' => 'xlsx',
        'macros' => [
            'r' => 'raw',
            'e' => 'escaped',
        ],
        'pre_calculate_formulas' => true,
    ],
    'cache' => [
        'enabled' => true,
        'driver' => 'default',
        'store_id' => null,
        'key' => null,
        'ttl' => 60,
    ],
    'view' => [
        'enable' => false,
        'driver' => 'phpoffice',
        'writer_type' => 'Xlsx',
    ],
    'queue' => [
        'queue' => true,
        'after_commit' => true,
    ],
    'sheets' => [
        'chunk_size' => 1000,
    ],
    'exports' => [
        // List of exports
    ],
    'import' => [
        'heading_row' => 1,
    ],
    'namespace' => 'App\\Exports',
    'style' => [
        'default' => [
            'font' => [
                'name' => 'Calibri',
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => 'left',
                'vertical' => 'center',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ],
    ],
    'disk' => 'public',
    'transaction' => [
        'enabled' => false,
        'handler' => \Maatwebsite\Excel\Transactions\Handlers\MemoryTransactionHandler::class,
    ],
    'cache-profiles' => [
        // List of cache profiles
    ],
    'temporary_files' => [
        'local_path' => storage_path('app'),
        'remote_disk' => 's3',
        'keep_alive' => false,
        'cleanup_on_cache_flush' => true,
    ],
    'filesystem' => [
        'default' => 'local',
        'disks' => [
            'local' => [
                'driver' => 'local',
                'root' => storage_path('app'),
            ],
            'public' => [
                'driver' => 'local',
                'root' => storage_path('app/public'),
                'url' => env('APP_URL').'/storage',
                'visibility' => 'public',
            ],
        ],
    ],
];
