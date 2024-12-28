<?php

// Initialize routing with base URL

BaseRouting::init(BASE_URL);



// Set default controller and method

BaseRouting::setDefaults('Pasien', 'index');



// Define CRUD routes for Pasien

BaseRouting::get('', 'Pasien@index');

BaseRouting::get('index', 'Pasien@index');

BaseRouting::get('pasien', 'Pasien@index');

BaseRouting::get('pasien/create', 'Pasien@create');

BaseRouting::post('pasien/store', 'Pasien@store');

BaseRouting::get('pasien/edit/{id}', 'Pasien@edit');

BaseRouting::post('pasien/update/{id}', 'Pasien@update');

BaseRouting::get('pasien/delete/{id}', 'Pasien@delete');

BaseRouting::get('pasien/show/{id}', 'Pasien@show');



// Add these routes

BaseRouting::get('pengaturan', 'Pengaturan@index');

BaseRouting::post('pengaturan/update', 'Pengaturan@update');



// Add these routes (only in development)

if (ENVIRONMENT === 'development') {

    BaseRouting::get('migration/create/{name}', 'Migration@create');

    BaseRouting::get('migration/run', 'Migration@run');

    BaseRouting::get('docs', 'Documentation@index');

}



// 404 handler

BaseRouting::notFound(function() {

    require_once ROOT_PATH . '/app/views/errors/404.php';

});



// Add these routes for trash management

BaseRouting::get('obat/trash', 'Obat@trash');

BaseRouting::get('obat/restore/{id}', 'Obat@restore');

BaseRouting::get('obat/permanent-delete/{id}', 'Obat@permanentDelete');



// Add these routes for supplier trash management

BaseRouting::get('supplier/trash', 'Supplier@trash');

BaseRouting::get('supplier/restore/{id}', 'Supplier@restore');

BaseRouting::get('supplier/permanent-delete/{id}', 'Supplier@permanentDelete');



// Add these routes for Tindakan

BaseRouting::get('tindakan', 'Tindakan@index');

BaseRouting::get('tindakan/create', 'Tindakan@create');

BaseRouting::post('tindakan/create', 'Tindakan@create');

BaseRouting::get('tindakan/edit/{id}', 'Tindakan@edit');

BaseRouting::post('tindakan/update/{id}', 'Tindakan@update');

BaseRouting::get('tindakan/delete/{id}', 'Tindakan@delete');

BaseRouting::get('tindakan/trash', 'Tindakan@trash');

?> 