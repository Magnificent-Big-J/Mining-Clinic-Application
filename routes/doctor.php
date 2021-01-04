<?php
Route::name('doctor.')->middleware(['auth'])->group(function () {
    Route::resource('appointment','AppointmentController');
    Route::resource('prescriptions','PrescriptionController')->except('index');
    Route::get('patient/{appointment}/prescription', 'Doctor\DoctorAppointmentController@patientPrescription')->name('patient.prescription');
    Route::get('prescriptions/{appointment}/appointment','PrescriptionController@index')->name('prescriptions.appointment.index');
    Route::get('appointment-details/{appointment}','Doctor\DoctorAppointmentController@show')->name('appointment.details');
    Route::get('all-appointments','Doctor\DoctorAppointmentController@doctorAppointments')->name('all.appointments');
    Route::get('doctor-profile-settings','Doctor\DoctorProfileController@show')->name('profile.settings');
    Route::get('doctor-new-appointments','Doctor\DoctorAppointmentController@index')->name('new.appointments');
    Route::put('doctor-profile-settings/{user}','Doctor\DoctorProfileController@update')->name('profile.settings.save');
});
