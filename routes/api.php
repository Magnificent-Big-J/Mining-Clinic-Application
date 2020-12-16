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
Route::get('doctor-product/{doctorProduct}/show', 'Api\DoctorProductController@show');
Route::post('doctor-product-store', 'Api\DoctorProductController@storeDoctorProduct');
Route::get('doctor-product/{doctorProduct}/product', 'Api\DoctorProductController@getDoctorProduct');
Route::get('doctor-product/{doctorProduct}/product-name', 'Api\DoctorProductController@productName');
Route::put('doctor-product/{doctorProduct}/update', 'Api\DoctorProductController@updateDoctorProduct');
Route::put('consultation-category/{consultationCategory}/update', 'Api\ConsultationCategoryController@update');
Route::put('product-category/{productCategory}/update', 'Api\ProductController@updateCategory');
Route::get('product-category/{productCategory}', 'Api\ProductController@editCategory');
Route::post('product-category', 'Api\ProductController@productStore');

