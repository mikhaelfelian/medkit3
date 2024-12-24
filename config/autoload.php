<?php
/**
 * Autoload Configuration
 * 
 * Specify which models, helpers, and libraries should be loaded automatically
 */
return [
    // Models to autoload
    'models' => [
        'pengaturan',  // Will load PengaturanModel
        'pasien',      // Will load PasienModel
    ],
    
    // Helpers to autoload
    'helpers' => [
        'url',         // Will load url_helper.php
        'form',        // Will load form_helper.php
        'asset',       // Will load asset_helper.php
    ],
    
    // Libraries to autoload
    'libraries' => [
        'session',     // Will load Session.php
        'security',    // Will load Security.php
    ]
]; 