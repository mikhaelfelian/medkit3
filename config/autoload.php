<?php

/**

 * Autoload Configuration

 * 

 * Specify which models, helpers, and libraries should be loaded automatically

 */

return [

    // Core libraries to autoload

    'core' => [

        'Input',

        'Database',

        'BaseSecurity'

    ],

    

    // Models to autoload

    'models' => [

        'pengaturan',  // Will load PengaturanModel

        'pasien',      // Will load PasienModel

        'obat'

    ],

    

    // Helpers to autoload

    'helpers' => [

        'asset',       // Will load AssetHelper.php

        'view',        // Will load ViewHelper.php

        'notification', // Will load NotificationHelper.php

        'angka',        // Will load AngkaHelper.php

        'generateNoRM'

    ],

    

    // Libraries to autoload

    'libraries' => [

        'session',     // Will load Session.php

        'security',    // Will load Security.php

        'form'         // Will load Form.php

    ]

]; 