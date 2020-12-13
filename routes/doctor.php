<?php
Route::name('doctor.')->middleware(['auth'])->group(function () {
    Route::resource('appointment','AppointmentController');
    Route::get('appointment-details/{appointment}','Doctor\DoctorAppointmentController@show')->name('appointment.details');
});
