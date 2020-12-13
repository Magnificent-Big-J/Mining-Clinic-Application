<?php
Route::name('doctor.')->middleware(['auth'])->group(function () {
    Route::resource('appointment','AppointmentController');
    Route::get('appointment-details/{appointment}','Doctor\DoctorAppointmentController@show')->name('appointment.details');
    Route::get('doctor-profile-settings','Doctor\DoctorProfileController@show')->name('profile.settings');
    Route::put('doctor-profile-settings/{user}','Doctor\DoctorProfileController@update')->name('profile.settings.save');
});
