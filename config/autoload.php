<?php
/**
 * Autoload Configuration
 * 
 * Specify which models, helpers, and libraries should be loaded automatically
 */

return [
    // Core libraries to autoload
    'core' => [
        'Database',
        'BaseModel',
        'BaseController',
        'BaseRouting',
        'BaseForm',
        'ViewHelper',
        'PaginateHelper'
    ],

    // Models to autoload
    'models' => [
        'pengaturan',  // Will load PengaturanModel
        'pasien',      // Will load PasienModel
        'obat'
    ],

    // Helpers to autoload
    'helpers' => [
        // System Helpers
        'Url',
        'Form',
        'Security',
        'Notification',
        'Paginate',      // This will load PaginateHelper from system
        
        // App Helpers
        'Angka',
        'Tanggalan',
        'Debug'
    ],

    // Libraries to autoload
    'libraries' => [
        'Input',
        'Logger'
    ]
];