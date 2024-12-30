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
        'url',
        'form',
        'html',
        'security',
        'paginate',
        'image'
    ],

    // Libraries to autoload
    'libraries' => [
        'session',     // Will load Session.php
        'security',    // Will load Security.php
        'form',         // Will load Form.php
        'paginate'
    ]
];