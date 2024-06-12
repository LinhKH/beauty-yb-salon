<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public $generalSetting;
    public $socialSetting;

    public function register()
    {
        //
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // if(file_exists(storage_path('installed'))){
            if (Schema::hasTable('general_settings')) {
                $siteInfo = DB::table('general_settings')->first();
            }

            if (Schema::hasTable('social-setting')) {
                $social = DB::table('social-setting')->get();
            }
            view()->share(['siteInfo'=> $siteInfo,'social_settings'=>$social]);
        // }
    }
}
