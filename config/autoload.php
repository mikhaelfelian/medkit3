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
        'Paginate',
        
        // App Helpers
        'AngkaHelper',  // This will autoload AngkaHelper.php
        'Tanggalan',
        'Debug',
        'View'
    ],

    // Libraries to autoload
    'libraries' => [
        'Input',
        'Logger',
        'Database',
        'Security'
    ]
];