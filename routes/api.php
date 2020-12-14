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
Route::put('consultation-category/{consultationCategory}/update', 'Api\ConsultationCategoryController@update');
Route::put('product-category/{productCategory}/update', 'Api\ProductController@updateCategory');
Route::get('product-category/{productCategory}', 'Api\ProductController@editCategory');

