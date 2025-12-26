<?php

use App\Http\Controllers\Domestic\FlightController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

//domestic
Route::post('flight/domestic', [FlightController::class, 'flightResult'])->name('domesticflights.result');
Route::post('flight/domestic/savedata', [FlightController::class, 'passengerDetails'])->name('domesticflights.passengerdetails');
Route::get('flight/domestic/passenger-details', [FlightController::class, 'passengerDetailsPage'])->name('domesticflights.passengerdetails.page');
Route::post('flight/domestic/passengerdetails/store', [FlightController::class, 'passengerDetailsStore'])->name('domesticflights.passengerdetails.store');
Route::get('flight/domestic/payment', [FlightController::class, 'payment'])->name('domesticflights.payment');
Route::get('flight/domestic/payment/store', [FlightController::class, 'paymentStore'])->name('domesticflights.payment.store');
Route::get('flight/domestic/payment/status', [FlightController::class, 'paymentStatus'])->name('domesticflights.payment.status');
Route::get('flight/domestic/success/{booking_code?}', [FlightController::class, 'bookingComplete'])->name('domesticflights.booking.complete');
Route::get('flight/domestic/ticket/download/{booking_code?}', [FlightController::class, 'ticketDownload'])->name('domesticflights.ticket.download');
Route::get('flight/domestic/error/{booking_code?}', [FlightController::class, 'error'])->name('domesticflights.ticket.error');
Route::get('findyourticket', [FrontendController::class, 'findYourTicket'])->name('findyourticket');
Route::get('viewyourticket/{booking_code}/{email}/{type}', [FrontendController::class, 'viewTicket'])->name('viewTicket');
