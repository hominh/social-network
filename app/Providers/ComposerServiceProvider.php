<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Auth;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('profile/master', function ($view) {
            $view->with('notes', DB::table('users')
                                ->leftJoin('notifications','users.id','=','notifications.user_logged')
                                ->where('user_hero','=',Auth::user()->id)
                                ->orderBy('notifications.created_at', 'desc')
                                ->get());
        });
        view()->composer('profile/master', function ($view) {
            $view->with('countnotifications', DB::table('notifications')
                                ->where('user_hero','=',Auth::user()->id)
                                ->count());
        });

        /*view()->composer('fe/blocks/company-facality', function ($view) {
            $view->with('services', DB::table('services')
                            ->select('services.id','services.name','services.title','services.icon')
                            ->get());
        });

        view()->composer('fe/blocks/slide-home', function ($view) {
            $view->with('slides', DB::table('slides')
                            ->select('slides.id','slides.textlink','slides.title','slides.link','slides.image')
                            ->get());
        });

        view()->composer('fe/blocks/brand-client-area', function ($view) {
            $view->with('brands', DB::table('brands')
                            ->select('brands.id','brands.name','brands.image')
                            ->get());
        });*/

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
