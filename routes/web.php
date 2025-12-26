<?php

use App\Http\Controllers\Admin\V2\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Domestic\FlightController as DomesticFlightController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Models\User;
use App\Service\AirIq\AirIqService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);


Route::get('/home', function () {
    return redirect()->route('frontend.index');
});

Route::get('/review', function () {
    return view('front.review');
});

Route::get('/makeadmin', function () {
    $user = User::where('email', 'info@flightsgyani.com')->first();
    $user->user_type = 'ADMIN';
    $user->save();
    return $user;
});

//test mail
//Route::get('/mailable', function () {
//    $invoice = \App\Models\InternationalFlight\FlightBooking::find(1);
//
//    return new App\Mail\YourFlightBooking($invoice);
//});



Route::post('/stripe/payment', [PaymentController::class, 'stripePayment'])
    ->name('stripe.payment');
Route::get('/connectips/fail', [PaymentController::class, 'getIpsFailureResponse']);
Route::get('/connectips/success', [PaymentController::class, 'getIpsSuccessResponse']);
//onepg routes
Route::get('/onepg-payment-methods', [PaymentController::class, 'getNPSOnePGGateways']);
Route::get('/onepg-payment-forms/{booking}/{bankcode}/', [PaymentController::class, 'genereaterNPSForm']);
Route::get('/onepg-payment-response', [PaymentController::class, 'getNPSResponse']);
Route::get('/onepg-payment-notification', [PaymentController::class, 'getNPSNotification']);
Route::get('/onepg-payment-cancel', [PaymentController::class, 'getNPSCancel']);

//flight routes
Route::group(['prefix' => 'flight'], function () {
    Route::get('/autocomplete/airport', [FlightController::class, 'airportSearch'])
        ->name('autocomplete.airport');
    Route::get('/autocomplete/airline', [FlightController::class, 'airlineSearch'])
        ->name('autocomplete.airline');
    Route::post('/search', [FlightController::class, 'searchFlight'])
        ->name('flight.search');
    Route::get('/result', [FlightController::class, 'showFlightResult'])
        ->name('search.result');
    Route::get('/search-next-day', [FlightController::class, 'nextDaySearch'])
        ->name('flight.nextday');
    Route::get('/search-prev-day', [FlightController::class, 'prevDaySearch'])
        ->name('flight.prevday');
    Route::post('/book', [FlightController::class, 'bookFlight'])
        ->name('flight.book');

    Route::get('/passenger-details', [FlightController::class, 'showPassengerForm'])
        ->name('passenger.form');

    Route::post('/passengers', [FlightController::class, 'passengerDetails'])
        ->name('passengers');

    Route::post('/connectips', [PaymentController::class, 'ipsPayment']);

    Route::post('/khalti/init', [PaymentController::class, 'initKhaltiPayment'])->name("khalti.init");
    Route::get('/khalti-payment', [PaymentController::class, 'khaltiPayment'])->name("khalti.payment");

    Route::get('/generate-pnr/{code}', [FlightController::class, 'generatePnr'])
        ->name('generate.pnr');

    Route::get('/pnr/{code}', [FlightController::class, 'showPNR'])
        ->name('show.pnr');

    Route::get('/generate-ticket/{code}', [FlightController::class, 'getFlightTickets'])
        ->name('issue.ticket');

    Route::post('/sort-airline', [FlightController::class, 'sortFlights'])
        ->name('sortflightairline');

    Route::get('/token-time', [FlightController::class, 'getSabreTokenTime'])
        ->name('get.sabre.time');

    Route::get('/view-ticket/{code}', [FlightController::class, 'showTicket'])
        ->name('show.ticket');
    Route::get('/download-ticket/{code}', [FlightController::class, 'downloadTicket'])
        ->name('download.ticket');

    Route::post('/fare-rule', [FlightController::class, 'getFareRule'])
        ->name('getfarerule');

    Route::get('/payment/{code}', [FlightController::class, 'payment'])
        ->name('flight.payment');

    Route::get('/print-ticket/{code}', [FlightController::class, 'createTicketPdf'])
        ->name('print.ticket');

    Route::get('/booking/{code}', [FlightController::class, 'viewFlightBooking'])
        ->name('view.flight.booking')->middleware(['auth', 'verified']);

    Route::get('/booking-cancel/{code}', [FlightController::class, 'requestVoidFlightBooking'])
        ->name('request.void.flight.booking')->middleware(['auth', 'verified']);

    Route::post('/request-cancel', [FlightController::class, 'sendVoidRequest'])
        ->name('send.flight.cancel.request');
});


Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');

Route::get('/package/{category}/{slug}', [FrontendController::class, 'list'])
    ->name('package.list');
Route::get('/download/pdf/itinerary/{id}', [FrontendController::class, 'download'])
    ->name('package.download');
Route::get('/download/pdf/download/cv', [FrontendController::class, 'cv']);
Route::get('/mail/pdf/mail', [FrontendController::class, 'mail'])
    ->name('package.mail');
Route::get('/children/category/list', [FrontendController::class, 'getchildrenCategory'])
    ->name('children.category');
Route::get('/children/category/search', [FrontendController::class, 'search'])
    ->name('package.search');
Route::post('/call/me/back', [FrontendController::class, 'callMeBack'])
    ->name('call.me.back');
Route::get('/about-us', [FrontendController::class, 'about'])
    ->name('frontend.about');
Route::get('/contact-us', [FrontendController::class, 'contact'])
    ->name('frontend.contact');
Route::get('/blogs', [BlogController::class, 'blog'])
    ->name('frontend.blog');
Route::post('/comment-store', [FrontendController::class, 'commentStore'])
    ->name('frontend.comment.store');
Route::get('/blog/{slug}', [BlogController::class, 'detail'])
    ->name('frontend.blog.detail');
Route::get('/flights/admin/login', function () {
    return view('auth.login');
});
Route::get('/terms-conditions', [FrontendController::class, 'termsConditions'])
    ->name('terms.conditions');
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])
    ->name('privacy.policy');
Route::get('/faq', [FrontendController::class, 'faq'])
    ->name('faq');
// Route::get('/{slug}', [FrontendController::class, 'detail'])
//     ->name('package.detail');


Route::withoutMiddleware(['verified'])->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/booking/{id}', [App\Http\Controllers\HomeController::class, 'bookingDetail'])
    ->name('home.booking.detail');

Route::middleware(['auth', 'verified'])->get("/user/change-password", [App\Http\Controllers\User\ProfileController::class, 'showChangePassword'])
    ->name('user.change.password');

Route::get("/auth/redirect", [LoginController::class, 'socialiteLoginWithGoogle'])->name("google.redirect");

Route::get("/auth/callback", [LoginController::class, 'socialiteLoginCallback'])->name("google.callback");

Route::post('inquiry/submit', [FrontendController::class, 'inquirySubmit'])
    ->name('inquiry.submit');

//permission
Route::get('insert/permission', [FrontendController::class, 'insertPermission']);
Route::get('insert/role', [FrontendController::class, 'insertRole']);

Route::get('/home/domesticbookings', [HomeController::class, 'domesticBookingDetail'])
    ->name('home.domesticbooking.detail')->withoutMiddleware(['verified']);

Route::get('user/email/verify/{id}/{hash}', [HomeController::class, 'verify'])
    ->name('user.verification.verify')->withoutMiddleware(['verified']);
Route::post('user/emailverify/resend', [HomeController::class, 'verifyResend'])
    ->name('user.verification.resend')->withoutMiddleware(['verified']);


Route::get('agent/login', [FrontendController::class, 'agentLogin'])
    ->name('agent.login');
Route::post('agent/login', [FrontendController::class, 'agentLoginCheck'])
    ->name('agent.login.check');
Route::get('agent/register', [FrontendController::class, 'agentRegister'])
    ->name('agent.register');
Route::post('agent/register', [FrontendController::class, 'agentRegisterStore'])
    ->name('agent.register.store');
Route::get('agent/balance/check', [DomesticFlightController::class, 'checkAgentBalance'])
    ->name('agent.check.balance');

Route::get('v2/user/change-password', [AdminController::class, 'changePassword'])
    ->name('v2.admin.change.password');
Route::post('v2/user/change-password', [AdminController::class, 'changePasswordStore'])
    ->name('v2.admin.change.password.store');

Route::get('agent/balance/check/international', [FlightController::class, 'checkAgentBalance'])
    ->name('agent.check.balance.international');

Route::get('check/airiq', function () {
    dd(AirIqService::checkLogin());
});
