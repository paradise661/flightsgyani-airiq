<?php

use App\Http\Controllers\B2b\AgentController;
use App\Http\Controllers\B2b\BookingController;
use App\Http\Controllers\B2b\PaymentController;
use App\Http\Controllers\B2b\TicketDetailController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [AgentController::class, 'dashboard'])->name('dashboard');
Route::get('transactions', [PaymentController::class, 'transactions'])->name('transactions');
Route::get('domestic/bookings', [BookingController::class, 'domesticFlightBookings'])
    ->name('domestic.flight.bookings');
Route::get('bookings/view/{booking}', [BookingController::class, 'domesticFlightBookingsDetails'])
    ->name('domestic.flight.bookings.details');
Route::get('intl/bookings', [BookingController::class, 'flightBookings'])
    ->name('flight.bookings');
Route::get('booking/view/{code}', [BookingController::class, 'viewFlightBooking'])
    ->name('view.flight.booking');

//ticket
Route::get('ticket/details', [TicketDetailController::class, 'editTicket'])
    ->name('edit.ticket');

Route::post('ticket/update', [TicketDetailController::class, 'updateTicket'])
    ->name('update.ticket');
