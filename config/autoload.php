<?php

/**
 * Autoload Configuration
 * 
 * Specify which helpers, libraries, and models to autoload
 */

return [
    // Helpers to autoload
    'helpers' => [
        'url',         // Will load UrlHelper.php
        'html',        // Will load HtmlHelper.php
        'form',        // Will load FormHelper.php
        'angka',       // Will load AngkaHelper.php
        'debug',       // Will load DebugHelper.php
        'tanggalan'    // Will load TanggalanHelper.php
    ],

    // Libraries to autoload
    'libraries' => [
        'session',
        'database',
        'security'
    ],

    // Models to autoload
    'models' => [
        'user',
        'pengaturan'
    ]
]; 