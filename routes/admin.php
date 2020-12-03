<?php
Route::name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('province', 'ProvinceController');
    Route::resource('patients','PatientController');
    Route::resource('medical','MedicalAidController');
    Route::resource('specialists','SpecialistController');
    Route::resource('doctors','DoctorController');
    Route::resource('appointments','AppointmentController');
    Route::post('booking', 'BookingController@booking')->name('booking');
    Route::get('reschedule-booking/{appointment}', 'BookingController@reschedule')->name('reschedule.booking');
    Route::put('reschedule-update/{appointment}', 'BookingController@update')->name('reschedule.update');
    Route::post('store-booking', 'BookingController@store')->name('store.booking');
});
