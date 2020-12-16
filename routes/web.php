<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/home');
Auth::routes();
Auth::routes(['register' => false]);
Route::get('/home', 'HomeController@index')->name('home');

Route::get('getProvince','Datatable\DataTableController@province')->name('get.province');
Route::get('product-categories','Datatable\ProductDatatableController@productCategories')->name('product.categories.index');
Route::get('doctor-products/{doctor}','Datatable\DoctorProductController@doctorProduct')->name('doctor.products.index');
Route::post('doctor-stock/{doctor}/data','Datatable\ProductStockController@doctorProduct')->name('doctor.stock.data.index');
Route::get('product-data','Datatable\ProductDatatableController@Product')->name('product.index');
Route::get('consultation-data','Datatable\ConsultationDatatableController@consultation')->name('consultation.consultation.index');
Route::get('consultation-fee-data/{doctor}','Datatable\ConsultationDatatableController@consultationFee')->name('consultation.fee.index');
Route::get('consultation-category-data','Datatable\ConsultationDatatableController@consultationCategories')->name('consultation.category.index');
Route::get('patient','Datatable\DataTableController@patients')->name('patient.index');
Route::get('specialist-data','Datatable\DataTableController@specialist')->name('specialist.index');
Route::get('doctors-data','Datatable\DataTableController@doctors')->name('doctor.index');
Route::get('appointments-data','Datatable\DataTableController@appointments')->name('appointments.index');
Route::get('questionnaires-data','Datatable\DataTableController@questionnaires')->name('questionnaires.index');
Route::get('historic-appointment-data','Datatable\ReportDatatables@historicAppointment')->name('historic.appointment.index');
Route::get('medical-examination-questions','Api\InternalApiController@getMedicalQuestions')->name('medical.examination.questions');
Route::post('medical-examination','Api\InternalApiController@save')->name('medical.examination.save');

