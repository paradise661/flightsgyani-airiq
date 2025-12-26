<?php

//general
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminFlightController;
use App\Http\Controllers\Admin\AirlineController;
use App\Http\Controllers\Admin\AirportController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BSPCommissionController;
use App\Http\Controllers\Admin\CategoryControllor;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\InqueryController;
use App\Http\Controllers\Admin\MarkupController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TermConditionsController;
use App\Http\Controllers\Admin\TravelAgencyController;
use App\Http\Controllers\Admin\WhatwedoController;
use App\Http\Controllers\Domestic\Admin\DomesticFlightController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard/detail', [DashboardController::class, 'index'])
    ->name('admin.dashboard');
Route::get('/notification', [AdminController::class, 'markNotificationRead'])
    ->name('notification.read');
Route::get('/notification-delete', [AdminController::class, 'deleteNotification'])
    ->name('notification.delete');
Route::get('/notif-delete-all', [AdminController::class, 'deleteAllNotifications'])
    ->name('delete.all.notif');
Route::get('/notif-read-all', [AdminController::class, 'readAllNotifications'])
    ->name('read.all.notif');


//flights
Route::prefix('flights')->group(function () {
    Route::get('/sabre/details', [AdminController::class, 'editSabreDetails'])
        ->name('sabre.details');
    Route::post('/sabre/update/', [AdminController::class, 'updateSabreDetails'])
        ->name('sabre.details.update');
    Route::get('/search-log', [AdminFlightController::class, 'flightSearchLog'])
        ->name('admin.flight.searchlog');
    Route::get('/get-search-data', [AdminFlightController::class, 'getSearchData'])
        ->name('get.search.data');
    Route::get('/clear-search', [AdminFlightController::class, 'clearSearchLog'])
        ->name('admin.clear.flight.search');
    Route::get('/delete-search/{id}', [AdminFlightController::class, 'deleteSearch'])
        ->name('admin.delete.flight.search');
    Route::get('/view/files/{id}', [AdminFlightController::class, 'viewLogFiles'])
        ->name('admin.view.files');
    Route::get('/bookings', [AdminFlightController::class, 'flightBookings'])
        ->name('admin.flight.bookings');
    Route::get('/get-booking-data', [AdminFlightController::class, 'getFlightBookingData'])
        ->name('get.bookings.data');
    Route::get('/booking/view/{code}', [AdminFlightController::class, 'viewFlightBooking'])
        ->name('admin.view.flight.booking');
    Route::get('/booking/delete/{code}', [AdminFlightController::class, 'deleteFlightBooking'])
        ->name('admin.delete.flight.booking');
    Route::get('/generate/pnr/{code}', [AdminFlightController::class, 'generatePnr'])
        ->name('admin.flight.generate.pnr');
    Route::get('/void/pnr/{pnr}', [AdminFlightController::class, 'voidPNR'])
        ->name('admin.flight.void.pnr');
    Route::get('/issue/ticket/{code}', [AdminFlightController::class, 'getFlightTickets'])
        ->name('admin.flight.issue.ticket');

    Route::get('/void/single-ticket/{data}', [AdminFlightController::class, 'voidSingleTicket'])
        ->name('admin.flight.void.single.ticket');

    Route::get('/void/ticket/{code}', [AdminFlightController::class, 'voidTicket'])
        ->name('admin.flight.void.ticket');
    Route::get('/group-booking-requests', [AdminFlightController::class, 'groupBookings'])
        ->name('admin.group.bookings');
    Route::get('/group-booking-request/{data}', [AdminController::class, 'viewGroupBookingRequest'])
        ->name('admin.view.group.booking');
    Route::get('/group-booking-request/delete/{data}', [AdminController::class, 'deleteGroupBookingRequest'])
        ->name('admin.delete.group.booking');
    Route::get('/{action}/group-booking/{data}', [AdminController::class, 'updateGroupBookingRequest'])
        ->name('admin.update.group.booking');
    Route::get('/check/pnr/', [AdminController::class, 'checkPnrDetails'])
        ->name('admin.check.pnr');
    Route::get('/pnr-details/', [AdminFlightController::class, 'getPnrDetails'])
        ->name('admin.pnr.details');
    Route::get('/sales-report', [AdminFlightController::class, 'dailySalesReport'])
        ->name('admin.flight.sales.report');
    Route::get('/view-report', [AdminFlightController::class, 'getSalesReport'])
        ->name('admin.get.sales.report');

    Route::get('/save/report/', [AdminFlightController::class, 'saveSalesReport'])
        ->name('admin.save.dailyflightreport');
});

//airports

Route::prefix('airport')->group(function () {
    Route::get('/', [AirportController::class, 'index'])
        ->name('airport.index');
    Route::post('/store', [AirportController::class, 'store'])
        ->name('airport.store');
    Route::get('/edit/{code}', [AirportController::class, 'edit'])
        ->name('airport.edit');
    Route::post('/update', [AirportController::class, 'update'])
        ->name('airport.update');
    Route::get('/delete/{code}', [AirportController::class, 'destroy'])
        ->name('airport.delete');
    Route::get('/get-airports', [AirportController::class, 'getAirports'])
        ->name('getairports');
});

//airlines

Route::prefix('airline')->group(function () {
    Route::get('/', [AirlineController::class, 'index'])
        ->name('airline.index');
    Route::post('/store', [AirlineController::class, 'store'])
        ->name('airline.store');
    Route::get('/edit/{code}', [AirlineController::class, 'edit'])
        ->name('airline.edit');
    Route::post('/update', [AirlineController::class, 'update'])
        ->name('airline.update');
    Route::get('/delete/{code}', [AirlineController::class, 'destroy'])
        ->name('airline.delete');
});

//bspcommissions
Route::prefix('bspcommission')->group(function () {
    Route::get('/', [BSPCommissionController::class, 'index'])
        ->name('bspcommission.index');
    Route::post('/save', [BSPCommissionController::class, 'store'])
        ->name('bspcommission.store');
    Route::get('/edit/{slug}', [BSPCommissionController::class, 'edit'])
        ->name('bspcommission.edit');
    Route::post('/update/{slug}', [BSPCommissionController::class, 'update'])
        ->name('bspcommission.update');
    Route::delete('/delete/{slug}', [BSPCommissionController::class, 'destroy'])
        ->name('bspcommission.destroy');
});
//Route::resource('bspcommission', BSPCommissionController::class);
//markups
Route::prefix('markups')->group(function () {
    Route::get('/', [MarkupController::class, 'index'])
        ->name('markup.index');
    Route::post('/save', [MarkupController::class, 'store'])
        ->name('markup.store');
    Route::get('/edit/{slug}', [MarkupController::class, 'edit'])
        ->name('markup.edit');
    Route::post('/update', [MarkupController::class, 'update'])
        ->name('markup.update');
    Route::get('/delete/{slug}', [MarkupController::class, 'destroy'])
        ->name('markup.destroy');
});

//payment ips

Route::get('/ips-payment', [PaymentGateWayController::class, 'ipsConnect'])
    ->name('ips.connect');
Route::post('/update-ips', [PaymentGateWayController::class, 'updateConnectIps'])
    ->name('ips.connect.update');

Route::get('/khalti-payment', [PaymentGateWayController::class, 'khalti'])
    ->name('khalti');
Route::post('/update-khalti', [PaymentGateWayController::class, 'updateKhalti'])
    ->name('khalti.update');

Route::get('/npsonepg-payment', [PaymentGateWayController::class, 'NPSOnePG'])
    ->name('NPSOnePG');
Route::post('/update-NPSOnePG', [PaymentGateWayController::class, 'updateNPSOnePG'])
    ->name('NPSOnePG.update');

Route::get('/site-settings', [AdminController::class, 'siteSettings'])
    ->name('site');
Route::post('/update-site-settings', [AdminController::class, 'updateSiteSettings'])
    ->name('site.update');

Route::get('/terms-conditions', [TermConditionsController::class, 'index'])
    ->name('terms.index');
Route::post('/update-terms-conditions', [TermConditionsController::class, 'update'])
    ->name('terms.update');
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index'])
    ->name('policy.index');
Route::post('/update-privacy-policy', [PrivacyPolicyController::class, 'update'])
    ->name('policy.update');
Route::get('/faq', [FAQController::class, 'index'])
    ->name('faq.index');
Route::post('/update-faq', [FAQController::class, 'update'])
    ->name('faq.update');

// Gallery
Route::group(['prefix' => 'gallery'], function () {
    Route::get('list/', [GalleryController::class, 'index'])
        ->name('gallery.index');
    Route::get('/add', [GalleryController::class, 'add'])
        ->name('gallery.add');
    Route::post('/store', [GalleryController::class, 'store'])
        ->name('gallery.store');
    Route::get('/show', [GalleryController::class, 'show'])
        ->name('gallery.show');
    Route::get('/edit/{id}', [GalleryController::class, 'edit'])
        ->name('gallery.edit');
    Route::post('/update/{id}', [GalleryController::class, 'update'])
        ->name('gallery.update');
    Route::get('/delete', [GalleryController::class, 'delete'])
        ->name('gallery.delete');
});

// About
Route::group(['prefix' => 'about'], function () {
    Route::get('list/', [AboutUsController::class, 'index'])
        ->name('about.index');
    Route::get('/edit/{id}', [AboutUsController::class, 'edit'])
        ->name('about.edit');
    Route::post('/update/{id}', [AboutUsController::class, 'update'])
        ->name('about.update');
});
// Home
Route::group(['prefix' => 'home'], function () {
    Route::get('list/', [HomeController::class, 'index'])
        ->name('home.index');
    Route::get('/edit/{id}', [HomeController::class, 'edit'])
        ->name('home.edit');
    Route::post('/update/{id}', [HomeController::class, 'update'])
        ->name('home.update');
});


Route::group(['prefix' => 'contact-us'], function () {
    Route::get('list/', [ContactUsController::class, 'index'])
        ->name('contact-us.index');
    Route::post('/store', [ContactUsController::class, 'store'])
        ->name('contact-us.store');
    Route::post('/update/{id?}', [ContactUsController::class, 'update'])
        ->name('contact-us.update');
    Route::get('/delete', [ContactUsController::class, 'delete'])
        ->name('contact-us.delete');
});

Route::group(['prefix' => 'about-us'], function () {
    Route::get('list/', [AboutUsController::class, 'index'])
        ->name('about-us.index');
    Route::post('/store', [AboutUsController::class, 'store'])
        ->name('about-us.store');
    Route::post('/update/{id?}', [AboutUsController::class, 'update'])
        ->name('about-us.update');
    Route::get('/delete', [AboutUsController::class, 'delete'])
        ->name('about-us.delete');
});

Route::group(['prefix' => 'slider'], function () {
    Route::get('/', [SliderController::class, 'index'])
        ->name('slider.index');
    Route::get('/add', [SliderController::class, 'add'])
        ->name('slider.add');
    Route::post('/store', [SliderController::class, 'store'])
        ->name('slider.store');
    Route::get('/show', [SliderController::class, 'show'])
        ->name('slider.show');
    Route::get('/edit/{id}', [SliderController::class, 'edit'])
        ->name('slider.edit');
    Route::post('/update/{id}', [SliderController::class, 'update'])
        ->name('slider.update');
    Route::get('/delete', [SliderController::class, 'delete'])
        ->name('slider.delete');
});

Route::group(['prefix' => 'category'], function () {
    Route::get('list/', [CategoryControllor::class, 'index'])
        ->name('category.index');
    Route::get('/add', [CategoryControllor::class, 'add'])
        ->name('category.add');
    Route::post('/store', [CategoryControllor::class, 'store'])
        ->name('category.store');
    Route::get('/show/{id?}', [CategoryControllor::class, 'show'])
        ->name('category.show');
    Route::get('/edit/{id?}', [CategoryControllor::class, 'edit'])
        ->name('category.edit');
    Route::post('/update/{id?}', [CategoryControllor::class, 'update'])
        ->name('category.update');
    Route::get('/delete', [CategoryControllor::class, 'delete'])
        ->name('category.delete');
});

Route::group(['prefix' => 'package'], function () {
    Route::get('list/', [PackageController::class, 'index'])
        ->name('package.index');
    Route::get('/add', [PackageController::class, 'add'])
        ->name('package.add');
    Route::post('/store', [PackageController::class, 'store'])
        ->name('package.store');
    Route::get('/show/{id?}', [PackageController::class, 'show'])
        ->name('package.show');
    Route::get('/download/{id}', [PackageController::class, 'download'])
        ->name('admin.package.download');
    Route::get('/edit/{id}', [PackageController::class, 'edit'])
        ->name('package.edit');
    Route::post('/update/{id?}', [PackageController::class, 'update'])
        ->name('package.update');
    Route::get('/delete', [PackageController::class, 'delete'])
        ->name('package.delete');
});

Route::group(['prefix' => 'blog'], function () {
    Route::get('list/', [BlogController::class, 'index'])
        ->name('blog.index');
    Route::get('/add', [BlogController::class, 'add'])
        ->name('blog.add');
    Route::post('/store', [BlogController::class, 'store'])
        ->name('blog.store');
    Route::get('/show/{id?}', [BlogController::class, 'show'])
        ->name('blog.show');
    Route::get('/edit/{id?}', [BlogController::class, 'edit'])
        ->name('blog.edit');
    Route::post('/update/{id?}', [BlogController::class, 'update'])
        ->name('blog.update');
    Route::get('/delete', [BlogController::class, 'delete'])
        ->name('blog.delete');
});

Route::group(['prefix' => 'partner'], function () {
    Route::get('list/', [PartnerController::class, 'index'])
        ->name('partner.index');
    Route::post('/store', [PartnerController::class, 'store'])
        ->name('partner.store');
    Route::post('/update/{id?}', [PartnerController::class, 'update'])
        ->name('partner.update');
    Route::get('/delete', [PartnerController::class, 'delete'])
        ->name('partner.delete');
});

Route::group(['prefix' => 'travel-agency'], function () {
    Route::get('list/', [TravelAgencyController::class, 'index'])
        ->name('travel-agency.index');
    Route::post('/store', [TravelAgencyController::class, 'store'])
        ->name('travel-agency.store');
    Route::post('/update/{id?}', [TravelAgencyController::class, 'update'])
        ->name('travel-agency.update');
    Route::get('/delete', [TravelAgencyController::class, 'delete'])
        ->name('travel-agency.delete');
});

Route::group(['prefix' => 'slider'], function () {
    Route::get('list/', [SliderController::class, 'index'])
        ->name('slider.index');
    Route::post('/store', [SliderController::class, 'store'])
        ->name('slider.store');
    Route::post('/update/{id}', [SliderController::class, 'update'])
        ->name('slider.update');
    Route::get('/delete', [SliderController::class, 'delete'])
        ->name('slider.delete');
});

Route::group(['prefix' => 'inquery-detail'], function () {
    Route::get('inquery/', [InqueryController::class, 'inquery'])
        ->name('inquery.index');
    Route::get('emailed/', [InqueryController::class, 'emailed'])
        ->name('emailed.index');
    Route::get('downloaded/', [InqueryController::class, 'downloaded'])
        ->name('downloaded.index');
    Route::get('booking/', [InqueryController::class, 'booking'])
        ->name('booking.index');
    Route::get('update/{id?}', [InqueryController::class, 'update'])
        ->name('inquery.update');
    Route::get('/delete', [InqueryController::class, 'delete'])
        ->name('inquery.delete');
});

Route::group(['prefix' => 'team'], function () {
    Route::get('list/', [TeamController::class, 'index'])
        ->name('team.index');
    Route::post('/store', [TeamController::class, 'store'])
        ->name('team.store');
    Route::post('/update/{id?}', [TeamController::class, 'update'])
        ->name('team.update');
    Route::get('/delete', [TeamController::class, 'delete'])
        ->name('team.delete');
});

Route::group(['prefix' => 'what-we-do'], function () {
    Route::get('list/', [WhatwedoController::class, 'index'])
        ->name('whatwedo.index');
    Route::post('/store', [WhatwedoController::class, 'store'])
        ->name('whatwedo.store');
    Route::post('/update/{id?}', [WhatwedoController::class, 'update'])
        ->name('whatwedo.update');
    Route::get('/delete', [WhatwedoController::class, 'delete'])
        ->name('whatwedo.delete');
});
Route::group(['prefix' => 'comment'], function () {
    Route::get('list/', [CommentController::class, 'index'])
        ->name('comment.index');
    Route::get('/delete', [CommentController::class, 'delete'])
        ->name('comment.delete');
});
Route::group(['prefix' => 'author'], function () {
    Route::post('/store', [AuthorController::class, 'store'])
        ->name('author.store');
});

Route::get('/resources', [AdminController::class, 'filemanager'])
    ->name('filemanager');

//domestic flights cms
Route::prefix('domestic/flights')->group(function () {

    Route::get('/bookings', [DomesticFlightController::class, 'domesticFlightBookings'])
        ->name('admin.domestic.flight.bookings');
    Route::get('/bookings/view/{booking}', [DomesticFlightController::class, 'domesticFlightBookingsDetails'])
        ->name('admin.domestic.flight.bookings.details');

});

Route::group(['prefix' => 'filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
