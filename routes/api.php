<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('consultation-category/{consultationCategory}', 'Api\ConsultationCategoryController@edit');
Route::get('add-prescription/{clinic}/{count}', 'Api\PrescriptionController@addPrescription');
Route::get('questionnaire', 'Api\QuestionnaireController@questionnaire');
Route::get('specialities-form', 'Api\SpecialistController@specialityForm');
Route::get('questionnaire/{count}/specialities', 'Api\QuestionnaireController@questionnaireWithSpecialities');
Route::post('store-questions', 'Api\QuestionnaireController@storeGeneral');
Route::post('store-questions-with-specialities', 'Api\QuestionnaireController@storeWithSpecialities');
Route::post('store-specialities', 'Api\SpecialistController@store');
Route::post('store-prescription', 'Api\PrescriptionController@store');
Route::get('doctor-product/{doctorProduct}/show', 'Api\DoctorProductController@show');
Route::post('doctor-product-store', 'Api\DoctorProductController@storeDoctorProduct');
Route::post('doctor-product/{doctorProduct}/store', 'Api\DoctorProductController@storeStock');
Route::get('doctor-product/{doctorProduct}/product', 'Api\DoctorProductController@getDoctorProduct');
Route::get('doctor-product/{doctorProduct}/product-name', 'Api\DoctorProductController@productName');
Route::put('doctor-product/{doctorProduct}/update', 'Api\DoctorProductController@updateDoctorProduct');
Route::put('consultation-category/{consultationCategory}/update', 'Api\ConsultationCategoryController@update');
Route::put('product-category/{productCategory}/update', 'Api\ProductController@updateCategory');
Route::get('product-category/{productCategory}', 'Api\ProductController@editCategory');
Route::post('product-category', 'Api\ProductController@productStore');

Route::post('specialist', 'Api\SpecialistController@store');
Route::post('ajax-doctor-form', 'Api\DoctorController@store');
Route::post('patient-medical-aid-form', 'Api\MedicalAidController@store');
Route::get('patient-medical-aid/{medicalAid}', 'Api\MedicalAidController@getMedicalAid');
Route::post('patient-medical-aid/{medicalAid}/update', 'Api\MedicalAidController@update');
Route::get('medical/{medicalRecord}/record', 'Api\MedicalAidController@show');

//Clinic
Route::post('mining-clinic-form', 'Api\ClinicController@store');
Route::post('mining-clinic-form/{clinic}/update', 'Api\ClinicController@update');
Route::get('mining-clinic-form/{clinic}', 'Api\ClinicController@show');
//Clinic Product
Route::get('clinic-product/{clinicProduct}/product', 'Api\ClinicProductController@getClinicProduct');
Route::get('clinic-product/{clinicProduct}/product-name', 'Api\ClinicProductController@productName');
Route::post('clinic-product/{clinicProduct}/store', 'Api\ClinicProductController@storeStock');
Route::put('clinic-product/{clinicProduct}/update', 'Api\ClinicProductController@updateclinicProduct');
Route::get('clinic-product/{clinicProduct}/show', 'Api\ClinicProductController@show');
Route::post('click-product-store', 'Api\ClinicProductController@storeClinicProduct');
//Appointment Consultation
Route::post('appointment-consultation', 'Api\DoctorController@consultationStore');
//Filtered Appointments
Route::post('filtered-appointments/{doctor}', 'Doctor\DoctorAppointmentController@filteredAppointments');
Route::post('appointment/{appointment}/update','Api\AppointmentController@update');
//Product
Route::get('product/{product}', 'Api\ProductController@edit');
Route::put('product/{product}/update', 'Api\ProductController@update');
//Booking
Route::post('patient-booking-form', 'Api\BookingController@store');

//Stock Level
Route::get('stock/{clinic}/level-form/{user}', 'Api\InternalApiController@stockLevel');
