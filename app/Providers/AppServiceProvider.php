<?php

namespace App\Providers;


use App\Models\Consultation;
use App\Models\ConsultationCategory;
use App\Models\Doctor;
use App\Models\ProductCategory;
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
        View::composer(['admin.products.product.modals.product_modal','admin.products.product.modals.product_edit_modal','admin.products.product.edit'],function($view){
            $productCategories = ProductCategory::all();
            $view->with(['productCategories'=>$productCategories]);
        });
        View::composer(['admin.doctors.partials.entity','admin.doctors.partials.edit','doctor.profile.show'],function($view){
            $specialists = Specialist::all();
            $view->with(['specialists'=>$specialists]);
        });
        View::composer(['admin.booking.booking', 'admin.booking.reschedule'],function($view){
            $doctors = Doctor::all();
            $view->with(['doctors'=>$doctors]);
        });
        View::composer(['admin.consultation.modals.consultation', 'admin.consultation.edit'],function($view){
            $consultationCategories = ConsultationCategory::all();
            $view->with(['consultationCategories'=>$consultationCategories]);
        });
        View::composer(['admin.doctors.modals.consultation_fee','admin.doctors.edit_consultation_fee'],function($view){
            $consultations = Consultation::all();
            $view->with(['consultations'=>$consultations]);
        });

        View::composer('*', function ($view) {
            $view->with(['user' => \auth()->user()]);
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
