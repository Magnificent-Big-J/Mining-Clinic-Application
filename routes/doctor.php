<?php
Route::name('doctor.')->middleware(['auth'])->group(function () {
    Route::resource('appointments','AppointmentController');
});
