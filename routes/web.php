<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => 'prevent-back-history'], function () {

    Auth::routes();
});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::group(['middleware' => 'prevent-back-history'], function () {
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'clientCount'])->name('home');
    Route::get('/client-list', [App\Http\Controllers\ClientListController::class, 'clientList'])->name('client-list');
    Route::get('/search', [App\Http\Controllers\ClientListController::class, 'search']);
    Route::get('/client-configuration', [App\Http\Controllers\ClientConfigurationController::class, 'clientConfiguration'])->name('client-configuration');
    Route::get('/client-management', [App\Http\Controllers\ClientManagementController::class, 'clientManagement'])->name('client-management');
    Route::get('/package-service-configuration', [App\Http\Controllers\PackageServiceController::class, 'packageServiceConfiguration'])->name('package-service-configuration');
    Route::any('/view-service-management', [App\Http\Controllers\ClientManagementController::class, 'viewManagement'])->name('view-service-management');
    Route::get('/service-name', [App\Http\Controllers\ServiceNameController::class, 'serviceName'])->name('service-name');
    Route::get('/invoice-generation', [App\Http\Controllers\InvoiceGenerationController::class, 'invoiceGeneration'])->name('invoice-generation');
    Route::get('/adhoc-invoice-generation', [App\Http\Controllers\AdhocInvoiceGenerationController::class, 'adhocInvoiceGeneration'])->name('adhoc-invoice-generation');
    Route::post('/getClient', [App\Http\Controllers\AdhocInvoiceGenerationController::class, 'getClient']);
    Route::post('/store-adhoc-invoice', [App\Http\Controllers\AdhocInvoiceGenerationController::class, 'storeAdhocInvoice']);
    Route::any('/invoice-index', [App\Http\Controllers\InvoiceIndexController::class, 'invoiceIndex'])->name('invoice-index');

    // Client Configuration
    Route::post('/store-data', [App\Http\Controllers\ClientConfigurationController::class, 'storeData']);
    Route::get('/edit-data/{id}', [App\Http\Controllers\ClientListController::class, 'editData']);
    Route::get('/edit-service/{id}', [App\Http\Controllers\ServiceNameController::class, 'editService']);
    Route::post('/update-data/{id}', [App\Http\Controllers\ClientListController::class, 'updateData']);
    Route::post('/update-service/{id}', [App\Http\Controllers\ServiceNameController::class, 'updateService']);
    Route::get('/delete-data/{id}', [App\Http\Controllers\ClientListController::class, 'deleteData']);

    Route::get('/delete-inv/{id}', [App\Http\Controllers\InvoiceIndexController::class, 'deleteInv']);

    Route::delete('/batch-invoice-details', [App\Http\Controllers\InvoiceIndexController::class, 'deleteCheckedInvoice'])->name('batch-invoice-details.deleteChecked');

    // Service Names
    Route::post('/store-service-info', [App\Http\Controllers\ServiceNameController::class, 'storeServiceInfo']);
    Route::get('/delete-service-info/{id}', [App\Http\Controllers\ServiceNameController::class, 'deleteServiceInfo']);

    // Service Management
    Route::post('/store-service-management', [App\Http\Controllers\ClientManagementController::class, 'storeServiceManagement']);

    Route::post('/store-package-service', [App\Http\Controllers\PackageServiceController::class, 'storePackageService']);

    // Invoice Generation
    Route::post('/store-invoice', [App\Http\Controllers\InvoiceGenerationController::class, 'storeInvoice']);

    // pdf
    Route::get('/pdf-invoice/{id}', [App\Http\Controllers\InvoiceIndexController::class, 'pdfInvoice'])->name('pdf-invoice');

    Route::get('/batch-invoice-details/{id}', [App\Http\Controllers\InvoiceIndexController::class, 'batchInvoiceDetails'])->name('batch-invoice-details');

    Route::get('/invoice-master/{id}', [App\Http\Controllers\InvoiceGenerationController::class, 'invoiceMaster']);

    // Route for adding Invoice For in the Client Configuration page

    Route::post('/store-invoice-for', [App\Http\Controllers\ClientConfigurationController::class, 'storeInvoiceFor']);

    // Route for edit service management

    Route::get('/edit-service-management/{id}', [App\Http\Controllers\ClientManagementController::class, 'editManagement']);
    Route::post('/update-service-management/{id}', [App\Http\Controllers\ClientManagementController::class, 'updateManagement']);

    Route::get('/invoice-details-mcloud', [App\Http\Controllers\InvoiceDetailsMcloudController::class, 'invoiceDetailsMcloud'])->name('invoice-details-mcloud');

    Route::get('/pdf-invoice-details/{id}', [App\Http\Controllers\InvoiceDetailsMcloudController::class, 'pdfInvoiceDetails'])->name('pdf-invoice-details');

    Route::post('/getClientForDetails', [App\Http\Controllers\InvoiceDetailsMcloudController::class, 'getClientForDetails']);
});
