<?php
Route::name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('historic-appointment', 'HistoricAppointment');
    Route::resource('historic-doctor-stock', 'ProductStockController')->except('index');
    Route::get('historic-doctor/{doctor}/stock', 'ProductStockController@index')->name('historic.doctor.product.index');
    Route::resource('product-category', 'ProductCategoryController');
    Route::resource('product', 'ProductController');
    Route::resource('province', 'ProvinceController');
    Route::resource('consultation-fee', 'ConsultationFeeController')->except('index');
    Route::resource('doctor-product', 'DoctorProductController')->except('index');
    Route::get('doctor-product/{doctor}/stock', 'DoctorProductController@index')->name('doctor.product.index');
    Route::get('consultation/{doctor}/fee', 'ConsultationFeeController@index')->name('consultation.fee.index');
    Route::resource('patients','PatientController');
    Route::get('patient/{patient}/appointments','PatientController@appointmentHistory')->name('patient.appointments');
    Route::resource('medicalAid','MedicalAidController');
    Route::resource('consultation','ConsultationController');
    Route::resource('specialists','SpecialistController');
    Route::resource('doctors','DoctorController');
    Route::resource('appointments','AppointmentController');
    Route::resource('consultation-category','ConsultationCategoryController');
    Route::resource('screeningQuestionnaire','ScreeningQuestionnaireController');
    Route::get('medical-questions','ScreeningQuestionnaireController@medical')->name('medical.question');
    Route::put('medical-questions-update/{screeningQuestionnaire}','ScreeningQuestionnaireController@updateSpecialities')->name('medical.question.update');
    Route::get('medical-questions-specialities','ScreeningQuestionnaireController@medicalWithSpecialities')->name('medical.question.with.specialities');
    Route::post('booking', 'BookingController@booking')->name('booking');
    Route::get('reschedule-booking/{appointment}', 'BookingController@reschedule')->name('reschedule.booking');
    Route::put('reschedule-update/{appointment}', 'BookingController@update')->name('reschedule.update');
    Route::get('doctor-unbooked-slots', 'BookingController@doctorUnbookedSlots')->name('doctor.unbooked.slots');
    Route::post('store-booking', 'BookingController@store')->name('store.booking');
    Route::get('covid/{appointment}/screening/{patient}', 'AppointmentScreening@covidScreening')->name('covid.screening');
    Route::get('medical/{appointment}/screening/{patient}', 'AppointmentScreening@medicalScreening')->name('medical.screening');
    Route::post('covid-screening}', 'AppointmentScreening@store')->name('covid.screening.store');
    Route::get('user-profile','UserController@show')->name('user.profile');
    Route::put('user-profile/{user}','UserController@update')->name('user.profile.update');
    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('admin-users', 'UserController@createAdmins')->name('users.create.admins');
    Route::get('doctor-admin-users', 'UserController@create')->name('doctor.users.create.admins');
    Route::post('admin-users-save', 'UserController@storeAdmins')->name('users.create.admins.store');
    Route::get('dispense/{appointment}/medicine', 'DispenseMedicineController@create')->name('dispense.medicine');
    Route::get('medicine/{appointment}/dispensed', 'DispenseMedicineController@medicineDispensed')->name('medicine.dispensed');
    Route::post('dispense-patient/{appointment}/medicine', 'DispenseMedicineController@dispense')->name('dispense.patient.medicine');
    Route::get('patient/{patient}/medical-record', 'InternalController@medicalRecords')->name('patient.medical.record');
    Route::get('upload/{appointment}/xray', 'InternalController@xrayUpload')->name('patient.xray.upload');
    Route::get('doctor/{doctor}/stock-level', 'InternalController@stockLevel')->name('doctor.stock.level');
    Route::post('xray-upload', 'InternalController@xrayStore')->name('patient.xray.store');
    Route::get('patient/{appointment}/xray-view', 'InternalController@xrayShow')->name('patient.xray.show');
    Route::get('export-products', 'Exports\DoctorStockExportController@exportProducts')->name('product.export');
});
