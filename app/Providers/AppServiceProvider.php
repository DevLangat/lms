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
    public function getName()
    {
        $company = DB::table('company_parameters')->first();
      
        $web_name=$company->Name;
        
        $web_alt="Loan Management System";
        if (empty($web_name)) {
            return $web_alt;
        }
        else{            
            return $web_name;
        }
    }
    public function boot()
    {
       
        view()->composer('*', function ($view) {
            $view->with(
                'CompanyName',
                $this->getName()
            );
        });
    }
}
