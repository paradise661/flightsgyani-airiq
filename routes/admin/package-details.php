<?php
// itinerary
use App\Http\Controllers\Admin\ExclusionController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\InclusionController;
use App\Http\Controllers\Admin\ItineraryController;
use App\Http\Controllers\Admin\OperationalTourController;
use App\Http\Controllers\Admin\PriceDetailsController;
use App\Http\Controllers\Admin\TermsAndConditionsController;
use App\Http\Controllers\Admin\VisaController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'itinerary'], function () {
    Route::post('/store', [ItineraryController::class, 'store'])
        ->name('itinerary.store');
    Route::post('/update/{id?}', [ItineraryController::class, 'update'])
        ->name('itinerary.update');
    Route::get('/delete', [ItineraryController::class, 'delete'])
        ->name('itinerary.delete');
});

// Price Detail
Route::group(['prefix' => 'price-details'], function () {
    Route::post('/store', [PriceDetailsController::class, 'store'])
        ->name('price-details.store');
    Route::post('/update/{id?}', [PriceDetailsController::class, 'update'])
        ->name('price-details.update');
    Route::get('/delete', [PriceDetailsController::class, 'delete'])
        ->name('price-details.delete');
});

// Exclusion
Route::group(['prefix' => 'exclusion'], function () {
    Route::post('/store', [ExclusionController::class, 'store'])
        ->name('exclusion.store');
    Route::post('/update/{id?}', [ExclusionController::class, 'update'])
        ->name('exclusion.update');
    Route::get('/delete', [ExclusionController::class, 'delete'])
        ->name('exclusion.delete');
});

// Inclusion
Route::group(['prefix' => 'inclusion'], function () {
    Route::post('/store', [InclusionController::class, 'store'])
        ->name('inclusion.store');
    Route::post('/update/{id?}', [InclusionController::class, 'update'])
        ->name('inclusion.update');
    Route::get('/delete', [InclusionController::class, 'delete'])
        ->name('inclusion.delete');
});

// Operational Tours
Route::group(['prefix' => 'operational-tour'], function () {
    Route::post('/store', [OperationalTourController::class, 'store'])
        ->name('operational-tour.store');
    Route::post('/update/{id?}', [OperationalTourController::class, 'update'])
        ->name('operational-tour.update');
    Route::get('/delete', [OperationalTourController::class, 'delete'])
        ->name('operational-tour.delete');
});

// Hotels
Route::group(['prefix' => 'hotels'], function () {
    Route::post('/store', [HotelController::class, 'store'])
        ->name('hotels.store');
    Route::post('/update/{id?}', [HotelController::class, 'update'])
        ->name('hotels.update');
    Route::get('/delete', [HotelController::class, 'delete'])
        ->name('hotels.delete');
});

// Visa
Route::group(['prefix' => 'visa'], function () {
    Route::post('/store', [VisaController::class, 'store'])
        ->name('visa.store');
    Route::post('/update/{id?}', [VisaController::class, 'update'])
        ->name('visa.update');
    Route::get('/delete', [VisaController::class, 'delete'])
        ->name('visa.delete');
});

// Visa
Route::group(['prefix' => 'terms-and-conditions'], function () {
    Route::post('/store', [TermsAndConditionsController::class, 'store'])
        ->name('terms-and-conditions.store');
    Route::post('/update/{id?}', [TermsAndConditionsController::class, 'update'])
        ->name('terms-and-conditions.update');
    Route::get('/delete', [TermsAndConditionsController::class, 'delete'])
        ->name('terms-and-conditions.delete');
});
