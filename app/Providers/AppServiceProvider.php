<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
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
        if(empty($company)){
            $web_alt="Loan Management System";
            return $web_alt;
        }
            
        else{  
            $web_name=$company->Name;
        
                 
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
