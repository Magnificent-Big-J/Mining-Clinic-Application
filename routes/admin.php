<?php
Route::name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('historic-appointment', 'HistoricAppointment');
    Route::resource('province', 'ProvinceController');
    Route::resource('consultation-fee', 'ConsultationFeeController')->except('index');
    Route::get('consultation/{doctor}/fee', 'ConsultationFeeController@index')->name('consultation.fee.index');
    Route::resource('patients','PatientController');
    Route::resource('medical','MedicalAidController');
    Route::resource('consultation','ConsultationController');
    Route::resource('specialists','SpecialistController');
    Route::resource('doctors','DoctorController');
    Route::resource('appointments','AppointmentController');
    Route::resource('consultation-category','ConsultationCategoryController');
    Route::resource('question','ScreeningQuestionnaireController');
    Route::get('medical-questions','ScreeningQuestionnaireController@medical')->name('medical.question');
    Route::post('booking', 'BookingController@booking')->name('booking');
    Route::get('reschedule-booking/{appointment}', 'BookingController@reschedule')->name('reschedule.booking');
    Route::put('reschedule-update/{appointment}', 'BookingController@update')->name('reschedule.update');
    Route::get('doctor-unbooked-slots', 'BookingController@doctorUnbookedSlots')->name('doctor.unbooked.slots');
    Route::post('store-booking', 'BookingController@store')->name('store.booking');
    Route::get('covid/{appointment}/screening/{patient}', 'AppointmentScreening@covidScreening')->name('covid.screening');
    Route::get('medical/{appointment}/screening/{patient}', 'AppointmentScreening@medicalScreening')->name('medical.screening');
    Route::post('covid-screening}', 'AppointmentScreening@store')->name('covid.screening.store');
});
