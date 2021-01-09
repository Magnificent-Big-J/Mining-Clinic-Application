<?php
Route::name('doctor.')->middleware(['auth'])->group(function () {
    Route::resource('appointment','AppointmentController');
    Route::resource('patient-xray','XRayController')->except('create');
    Route::resource('referrals','ReferralController')->except('create');
    Route::get('my-referrals','ReferralController@myReferrals')->name('my.referrals');
    Route::get('refer/{appointment}/patient','ReferralController@create')->name('refer.patient');
    Route::resource('prescriptions','PrescriptionController')->except('index');
    Route::get('patient/{appointment}/xray','XRayController@create')->name('patient.xray.create');
    Route::get('patient/{appointment}/prescription-upload','Doctor\DoctorAppointmentController@uploadPrescription')->name('patient.prescription.upload');
    Route::post('patient/prescription-upload','Doctor\DoctorAppointmentController@storePrescription')->name('patient.prescription.upload.store');
    Route::get('patient/{appointment}/prescription', 'Doctor\DoctorAppointmentController@patientPrescription')->name('patient.prescription');
    Route::get('patient/{appointment}/showDocument', 'Doctor\DoctorAppointmentController@showDocument')->name('patient.show.document');
    Route::delete('patient/{appointment}/prescription/delete', 'Doctor\DoctorAppointmentController@destroy')->name('patient.prescription.delete');
    Route::get('prescriptions/{appointment}/appointment','PrescriptionController@index')->name('prescriptions.appointment.index');
    Route::get('appointment-details/{appointment}','Doctor\DoctorAppointmentController@show')->name('appointment.details');
    Route::get('all-appointments','Doctor\DoctorAppointmentController@doctorAppointments')->name('all.appointments');
    Route::get('doctor-profile-settings','Doctor\DoctorProfileController@show')->name('profile.settings');
    Route::get('doctor-new-appointments','Doctor\DoctorAppointmentController@index')->name('new.appointments');
    Route::put('doctor-profile-settings/{user}','Doctor\DoctorProfileController@update')->name('profile.settings.save');
});
