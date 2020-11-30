<?php
Route::name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('province', 'ProvinceController');
    Route::resource('patients','PatientController');
});
