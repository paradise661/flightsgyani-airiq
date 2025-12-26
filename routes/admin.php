<?php

use App\Http\Controllers\Admin\V2\AboutUsController;
use App\Http\Controllers\Admin\V2\ActivityLogController;
use App\Http\Controllers\Admin\V2\AdminController;
use App\Http\Controllers\Admin\V2\AdminFlightController;
use App\Http\Controllers\Admin\V2\AirlineController;
use App\Http\Controllers\Admin\V2\AirportController;
use App\Http\Controllers\Admin\V2\BlogController;
use App\Http\Controllers\Admin\V2\BranchController;
use App\Http\Controllers\Admin\V2\BSPCommissionController;
use App\Http\Controllers\Admin\V2\CompanyTicketController;
use App\Http\Controllers\Admin\V2\DashboardController;
use App\Http\Controllers\Admin\V2\DomesticAirlineController;
use App\Http\Controllers\Admin\V2\DomesticFlightCommissionController;
use App\Http\Controllers\Admin\V2\DomesticFlightController;
use App\Http\Controllers\Admin\V2\DomesticSectorController;
use App\Http\Controllers\Admin\V2\FaqsController;
use App\Http\Controllers\Admin\V2\InqueryController;
use App\Http\Controllers\Admin\V2\InternationalFlightComissionController;
use App\Http\Controllers\Admin\V2\MarkupController;
use App\Http\Controllers\Admin\V2\PageController;
use App\Http\Controllers\Admin\V2\PlasmaController;
use App\Http\Controllers\Admin\V2\PaymentGatewayController;
use App\Http\Controllers\Admin\V2\PermissionController;
use App\Http\Controllers\Admin\V2\RoleController;
use App\Http\Controllers\Admin\V2\SliderController;
use App\Http\Controllers\Admin\V2\TeamController;
use App\Http\Controllers\Admin\V2\UserController;
use App\Http\Controllers\Admin\V2\WhatwedoController;
use App\Http\Controllers\B2b\AgentController;
use App\Http\Controllers\B2b\AgentGroupController;
use App\Http\Controllers\B2b\MarkupController as B2bMarkupController;
use App\Http\Controllers\B2b\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('dashboard/detail', [DashboardController::class, 'index'])->name('dashboard');

//flights
Route::prefix('flights')->group(function () {
    Route::get('sabre/details', [AdminController::class, 'editSabreDetails'])
        ->name('sabre.details');
    Route::post('sabre/update/', [AdminController::class, 'updateSabreDetails'])
        ->name('sabre.details.update');
    Route::get('search-log', [AdminFlightController::class, 'flightSearchLog'])
        ->name('flight.searchlog');
    // Route::get('get-search-data', [AdminFlightController::class, 'getSearchData'])
    //     ->name('get.search.data');
    Route::get('clear-search', [AdminFlightController::class, 'clearSearchLog'])
        ->name('clear.flight.search');
    Route::get('delete-search/{id}', [AdminFlightController::class, 'deleteSearch'])
        ->name('delete.flight.search');
    Route::get('view/files/{id}', [AdminFlightController::class, 'viewLogFiles'])
        ->name('view.files');
    Route::get('bookings', [AdminFlightController::class, 'flightBookings'])
        ->name('flight.bookings');
    // Route::get('get-booking-data', [AdminFlightController::class, 'getFlightBookingData'])
    //     ->name('get.bookings.data');
    Route::get('booking/view/{code}', [AdminFlightController::class, 'viewFlightBooking'])
        ->name('view.flight.booking');
    // Route::get('booking/delete/{code}', [AdminFlightController::class, 'deleteFlightBooking'])
    //     ->name('admin.delete.flight.booking');
    // Route::get('generate/pnr/{code}', [AdminFlightController::class, 'generatePnr'])
    //     ->name('admin.flight.generate.pnr');
    // Route::get('void/pnr/{pnr}', [AdminFlightController::class, 'voidPNR'])
    //     ->name('admin.flight.void.pnr');
    // Route::get('issue/ticket/{code}', [AdminFlightController::class, 'getFlightTickets'])
    //     ->name('admin.flight.issue.ticket');

    // Route::get('void/single-ticket/{data}', [AdminFlightController::class, 'voidSingleTicket'])
    //     ->name('admin.flight.void.single.ticket');

    // Route::get('void/ticket/{code}', [AdminFlightController::class, 'voidTicket'])
    //     ->name('admin.flight.void.ticket');
    // Route::get('group-booking-requests', [AdminFlightController::class, 'groupBookings'])
    //     ->name('admin.group.bookings');
    // Route::get('group-booking-request/{data}', [AdminController::class, 'viewGroupBookingRequest'])
    //     ->name('admin.view.group.booking');
    // Route::get('group-booking-request/delete/{data}', [AdminController::class, 'deleteGroupBookingRequest'])
    //     ->name('admin.delete.group.booking');
    // Route::get('{action}/group-booking/{data}', [AdminController::class, 'updateGroupBookingRequest'])
    //     ->name('admin.update.group.booking');
    // Route::get('check/pnr/', [AdminController::class, 'checkPnrDetails'])
    //     ->name('admin.check.pnr');
    // Route::get('pnr-details/', [AdminFlightController::class, 'getPnrDetails'])
    //     ->name('admin.pnr.details');
    // Route::get('sales-report', [AdminFlightController::class, 'dailySalesReport'])
    //     ->name('admin.flight.sales.report');
    // Route::get('view-report', [AdminFlightController::class, 'getSalesReport'])
    //     ->name('admin.get.sales.report');

    // Route::get('save/report/', [AdminFlightController::class, 'saveSalesReport'])
    //     ->name('admin.save.dailyflightreport');
});

Route::prefix('domestic/flights')->group(function () {
    Route::get('bookings', [DomesticFlightController::class, 'domesticFlightBookings'])
        ->name('domestic.flight.bookings');
    Route::get('bookings/view/{booking}', [DomesticFlightController::class, 'domesticFlightBookingsDetails'])
        ->name('domestic.flight.bookings.details');
    Route::get('search', [DomesticFlightController::class, 'domesticFlightSearch'])
        ->name('domestic.flight.search');
    Route::get('deletesearch/{search}', [DomesticFlightController::class, 'domesticFlightSearchDelete'])
        ->name('domestic.flight.deletesearch');
    Route::get('deleteallsearch', [DomesticFlightController::class, 'domesticFlightSearchDeleteAll'])
        ->name('domestic.flight.deleteallsearch');
});

Route::resource('airport', AirportController::class);
Route::resource('airline', AirlineController::class);
Route::resource('bspcommission', BSPCommissionController::class);
Route::resource('markups', MarkupController::class);
Route::resource('branches', BranchController::class);
Route::resource('aboutus', AboutUsController::class);
Route::resource('blog', BlogController::class);
Route::resource('pages', PageController::class);
Route::resource('faqs', FaqsController::class);
Route::resource('teams', TeamController::class);
Route::resource('whatwedo', WhatwedoController::class);

Route::prefix('domestic')->as('domestic.')->group(function () {
    Route::resource('airlines', DomesticAirlineController::class);
    Route::resource('sectors', DomesticSectorController::class);
    Route::resource('commissions', DomesticFlightCommissionController::class);
});

//plasma
Route::get('plasma', [PlasmaController::class, 'edit'])
    ->name('plasma');
Route::post('plasma/update', [PlasmaController::class, 'update'])
    ->name('plasma.update');

Route::resource('sliders', SliderController::class);
Route::get('inquery', [InqueryController::class, 'contact'])
    ->name('inquery.details');
Route::get('inquery/{inquery}', [InqueryController::class, 'viewInquery'])
    ->name('inquery.details.view');
Route::delete('inquery/delete/{inquery}', [InqueryController::class, 'deleteInquery'])
    ->name('inquery.delete');
Route::get('truncateinquery', [InqueryController::class, 'truncateInquery'])
    ->name('truncateinquery');
Route::get('khalti-payment', [PaymentGatewayController::class, 'khalti'])
    ->name('khalti');
Route::post('khalti-payment/store', [PaymentGatewayController::class, 'khaltiStore'])
    ->name('khalti.store');
Route::get('site-setting', [AdminController::class, 'siteSettings'])
    ->name('site.setting');
Route::post('site-setting/update', [AdminController::class, 'updateSiteSettings'])
    ->name('site.setting.update');
Route::get('site-setting/removefile/{filename}/{type}', [AdminController::class, 'removefileFromSite'])
    ->name('site.setting.remove.file');

Route::get('registered-users', [InqueryController::class, 'registeredUsers'])
    ->name('registered.users');
Route::get('registered-users/status/{user}', [InqueryController::class, 'registeredUserStatus'])
    ->name('registered.users.status');
Route::delete('registered-users/delete/{user}', [InqueryController::class, 'registeredUserDelete'])
    ->name('registered.users.delete');
Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);

Route::resource('agentgroups', AgentGroupController::class);
Route::resource('agents', AgentController::class);
Route::get('load-fund', [PaymentController::class, 'loadFund'])
    ->name('load.fund');
Route::post('load-fund', [PaymentController::class, 'loadFundStore'])
    ->name('load.fund.store');
Route::get('topup', [PaymentController::class, 'transactionsList'])
    ->name('transactions.list');
Route::get('topup/{transaction}', [PaymentController::class, 'transactionsShow'])
    ->name('transactions.show');
Route::put('topup/{transaction}', [PaymentController::class, 'transactionsupdate'])
    ->name('transactions.edit');

//logs
Route::get('activitylogs', [ActivityLogController::class, 'activityLogs'])
    ->name('activitylogs.index');
Route::delete('activitylogs/{log}', [ActivityLogController::class, 'activityLogDelete'])
    ->name('activitylogs.delete');
Route::get('truncateactivitylogs', [ActivityLogController::class, 'truncateActivityLog'])
    ->name('truncate.activitylog');


Route::get('transactions', [PaymentController::class, 'transactionsAll'])
    ->name('transactions.all');
Route::get('transaction/{transaction}', [PaymentController::class, 'transactionDetails'])
    ->name('transactions.details');

//ticket markup
Route::resource('tickets', CompanyTicketController::class);

Route::prefix('b2b')->as('b2b.')->group(function () {
    Route::resource('markups', B2bMarkupController::class);
});

Route::resource('international/commissions', InternationalFlightComissionController::class);