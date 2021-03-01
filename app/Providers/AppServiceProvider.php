<?php

namespace App\Providers;


use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Consultation;
use App\Models\ConsultationCategory;
use App\Models\Doctor;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Province;
use App\Models\Specialist;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Service\Doctor\ConsultationFeeService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        View::composer(['admin.patients.create', 'admin.patients.edit'],function($view){
            $provinces = Province::all();
            $view->with(['provinces'=>$provinces]);
        });
        View::composer(['admin.clinic-stock.modals.add_clinic_product'],function($view){
            $products = Product::all();
            $view->with(['products'=>$products]);
        });
        View::composer(['admin.products.product.modals.product_modal','admin.products.product.modals.product_edit_modal','admin.products.product.edit'],function($view){
            $productCategories = ProductCategory::all();
            $view->with(['productCategories'=>$productCategories]);
        });
        View::composer(['admin.doctors.partials.personal','admin.doctors.partials.edit','doctor.profile.show', 'admin.questionnaires.partials.screeningWithSpecialities', 'admin.questionnaires.edit.editWithSpecialities'],function($view){
            $specialists = Specialist::all();
            $view->with(['specialists'=>$specialists]);
        });
        View::composer(['admin.booking.booking', 'admin.booking.reschedule'],function($view){
            $doctors = Doctor::all();
            $clinics = Clinic::all();
            $view->with(['doctors'=>$doctors, 'clinics'=> $clinics]);
        });
        View::composer(['admin.consultation.modals.consultation', 'admin.consultation.edit'],function($view){
            $consultationCategories = ConsultationCategory::all();
            $view->with(['consultationCategories'=>$consultationCategories]);
        });
        View::composer(['admin.doctors.modals.consultation_fee','admin.doctors.edit_consultation_fee'],function($view){
            $consultations = Consultation::all();
            $view->with(['consultations'=>$consultations]);
        });
        View::composer(['admin.clinic-stock.index'],function($view){
            $clinics = Clinic::all();
            $view->with(['clinics'=> $clinics]);
        });
        View::composer(['admin.appointments.index'],function($view){
            $clinics = Clinic::all();
            $doctors = Doctor::all();
            $statuses = Appointment::$texts;
            $view->with(['clinics'=> $clinics, 'doctors' => $doctors, 'statuses' => $statuses]);
        });
            View::composer(['admin.modals.login'],function($view){
                $clinics = Clinic::all();
                $view->with(['clinics'=> $clinics]);

            });
        View::composer(['doctor.modals.consultation'],function($view){
            if (auth()->user()->isDoctor()) {
                $service = new ConsultationFeeService();
                $doctor = Doctor::find(auth()->user()->doctor->id);
                $view->with(['consultationFees'=> $service->consultationFees($doctor)]);
            }
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
