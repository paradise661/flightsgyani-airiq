<?php

namespace App\Providers;


use App\Http\Services\HelperService;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Inquery;
use App\Models\Package;
use App\Models\Site;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // View::composer('layouts.back', function ($view) {
        //     $bookingCount = Inquery::whereType('booking')->whereStatus(0)->count();
        //     $inqueryCount = Inquery::whereType('inquery')->whereStatus(0)->count();
        //     $view->with([
        //         'bookingCount' => $bookingCount,
        //         'inqueryCount' => $inqueryCount
        //     ]);
        // });
        // View::composer('layouts.front', function ($view) {
        //     $keywords = HelperService::keywords();
        //     $site = Site::first();
        //     $categories = Category::whereNull('parent_id')->get();
        //     $blogsF = Blog::OrderBy('created_at', 'desc')->limit(3)->get();
        //     $pacakgesF = Package::where('status', 1)->orderBy('rank', 'asc')->limit(12)->get();
        //     $view->with([
        //         'categories' => $categories,
        //         'blogsF' => $blogsF,
        //         'packagesF' => $pacakgesF,
        //         'keywords' => $keywords,
        //         'site' => $site
        //     ]);
        // });
    }
}
