<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;


class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/domestic.php'));
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware(['web', 'auth', 'admin'])
                ->prefix('v2/admin')
                ->name('v2.admin.')
                ->group(base_path('routes/admin.php'));

            Route::middleware(['web', 'auth', 'agent'])
                ->prefix('b2b/agent')
                ->name('b2b.agent.')
                ->group(base_path('routes/agent.php'));


            Route::middleware(['web', 'auth', 'admin'])
                ->prefix('admin')
                ->namespace($this->namespace . '\Admin')
                ->group(function () {
                    $files = File::allFiles(base_path('routes' . DIRECTORY_SEPARATOR . 'admin'));
                    foreach ($files as $file) {
                        require_once $file->getRealPath();
                    }
                });
            Route::middleware(['web', 'auth'])
                ->prefix('user')
                ->namespace($this->namespace . '\User')
                ->group(function () {
                    $files = File::allFiles(base_path('routes' . DIRECTORY_SEPARATOR . 'user'));
                    foreach ($files as $file) {
                        require_once $file->getRealPath();
                    }
                });
        });
        /* Route::
 //        middleware(['web', 'auth', 'role:admin|company'])
 //            ->prefix('user')
         namespace($this->namespace . '\Company')
             ->group(function () {
                 $files = File::allFiles(base_path('routes' . DIRECTORY_SEPARATOR . 'company'));
                 foreach ($files as $file) {
                     //dd($file->getRealPath());
                     require_once $file->getRealPath();
                 }
             });*/
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
