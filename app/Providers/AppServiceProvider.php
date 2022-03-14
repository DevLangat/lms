<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use App\Models\CompanyParameters;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function getName(){
        $company=CompanyParameters::all();
        foreach($company ?? '' as $data){
            $web_name=$data->Name;
        }
        return $web_name;
    }
    public function boot()
    {  
        view()->composer('*', function ($view) {
            $view->with('CompanyName', $this->getName()
        );
        });
    }
}
