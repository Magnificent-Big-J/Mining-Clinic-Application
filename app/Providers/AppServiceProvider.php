<?php

namespace App\Providers;


use App\Models\Province;
use App\Models\Specialist;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        View::composer('admin.patients.create',function($view){
            $provinces = Province::all();
            $view->with(['provinces'=>$provinces]);
        });
        View::composer('admin.doctors.partials.entity',function($view){
            $specialists = Specialist::all();
            $view->with(['specialists'=>$specialists]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
