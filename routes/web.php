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
Route::get('hello', function (){
    return view('admin.patients.index');
});
Route::get('test', function (){

    return view('doctor.appointments.index');
});


    Route::get('getProvince','Datatable\DataTableController@province')->name('get.province');
    Route::get('patient','Datatable\DataTableController@patients')->name('patient.index');
