<?php
Route::name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('province', 'ProvinceController');
    Route::resource('patients','PatientController');
    Route::resource('medical','MedicalAidController');
    Route::resource('specialists','SpecialistController');
    Route::resource('doctors','DoctorController');
});
