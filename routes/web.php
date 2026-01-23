<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});




Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    

    Route::controller(UsersController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/list', 'index')->name('list');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::put('/update', 'update')->name('update');
    });


    Route::controller(DoctorController::class)->prefix('doctors')->name('doctor.')->group(function () {
        Route::get('/list', 'index')->name('list')->middleware('permission:view doctors');
        Route::get('/create', 'create')->name('create')->middleware('permission:manage doctors');
        Route::post('/storeStep1', 'storeStep1')->name('storeStep1')->middleware('permission:manage doctors');
        Route::post('/storeStep2', 'storeStep2')->name('storeStep2')->middleware('permission:manage doctors');
        Route::post('/storeStep3', 'storeStep3')->name('storeStep3')->middleware('permission:manage doctors');
        Route::get('/show/{doctor}', 'show')->name('show')->middleware('permission:view doctors');
        Route::get('/edit/{doctor}', 'edit')->name('edit')->middleware('permission:manage doctors');
        Route::put('/update/{id}', 'update')->name('update')->middleware('permission:manage doctors');

        Route::get('/schedule/{id}', 'schedule')->name('schedule')->middleware('permission:view schedule');
        Route::get('/schedule/create/{doctor}', 'scheduleCreate')->name('schedule.create')->middleware('permission:manage schedule');
        Route::post('/schedule/store', 'scheduleStore')->name('schedule.store')->middleware('permission:manage schedule');
        Route::get('/schedule/edit/{schedule}', 'scheduleEdit')->name('schedule.edit')->middleware('permission:manage schedule');
        Route::put('/schedule/update/{id}', 'scheduleUpdate')->name('schedule.update')->middleware('permission:manage schedule');
        Route::delete('/schedule/delete/{schedule}', 'scheduleDelete')->name('schedule.delete')->middleware('permission:manage schedule');
    });


    Route::controller(PatientController::class)->prefix('patient')->name('patient.')->group(function () {
        Route::get('/list', 'index')->name('list')->middleware('permission:view patients');
        Route::get('/create', 'create')->name('create')->middleware('permission:view patients');
        Route::post('/storeStep1', 'storeStep1')->name('storeStep1')->middleware('permission:manage patients');
        Route::post('/storeStep2', 'storeStep2')->name('storeStep2')->middleware('permission:manage patients');
        Route::post('/storeStep3', 'storeStep3')->name('storeStep3')->middleware('permission:manage patients');
        Route::post('/storeStep4', 'storeStep4')->name('storeStep4')->middleware('permission:manage patients');
        Route::get('/show/{patient}', 'show')->name('show')->middleware('permission:view patients');
        Route::get('/edit/{patient}', 'edit')->name('edit')->middleware('permission:manage patients');
        Route::put('/update/{id}', 'update')->name('update')->middleware('permission:manage patients');
    });



    Route::controller(AppointmentController::class)->prefix('appointment')->name('appointment.')->group(function () {
        Route::get('/list', 'index')->name('list')->middleware('permission:view appointments');
        Route::get('/create', 'create')->name('create')->middleware('permission:manage appointments');
        Route::post('/store', 'store')->name('store')->middleware('permission:manage appointments');
        Route::get('/show/{appointment}', 'show')->name('show')->middleware('permission:view appointments');
        Route::get('/getDoctorBySpec/{id}', 'getDoctorBySpec')->name('getDoctorBySpec')->middleware('permission:view appointments');
        Route::get('/booked/{doctorId}', 'getBookedSlots')->name('booked')->middleware('permission:view appointments');
        
        Route::post('/confirmAppointment/{appointment}', 'confirmAppointment')->name('confirm');
        Route::post('/cancelAppointment/{appointment}', 'cancelAppointment')->name('cancel');
        Route::post('/progressAppointment/{appointment}', 'progressAppointment')->name('progress');
        Route::post('/completeAppointment/{appointment}', 'completeAppointment')->name('complete');
    });



    Route::controller(PrescriptionController::class)->prefix('prescription')->name('prescription.')->group(function () {
        Route::get('/list', 'list')->name('list')->middleware('permission:view appointments');
        Route::get('/show/{prescription}', 'show')->name('show')->middleware('permission:view appointments');
    });


    Route::controller(PharmacyController::class)->prefix('pharmacy')->name('pharmacy.')->group(function () {
        Route::get('/list', 'list')->name('list')->middleware('permission:view pharmacy');
        Route::get('/create', 'create')->name('create')->middleware('permission:manage pharmacy');
        Route::get('/show/{pharmacy}', 'show')->name('show')->middleware('permission:view pharmacy');
        Route::post('/storeStep1', 'storeStep1')->name('storeStep1')->middleware('permission:manage pharmacy');
        Route::post('/storeStep2', 'storeStep2')->name('storeStep2')->middleware('permission:manage pharmacy');
        Route::post('/storeStep3', 'storeStep3')->name('storeStep3')->middleware('permission:manage pharmacy');
    });
    


    Route::controller(RoleController::class)->prefix('role')->name('role.')->group(function () {
        Route::get('/list', 'list')->name('list')->middleware('permission:view roles');
        Route::get('/create', 'create')->name('create')->middleware('permission:manage roles');
        Route::get('/store', 'store')->name('store')->middleware('permission:manage roles');
        Route::get('/edit/{role}', 'edit')->name('edit')->middleware('permission:manage roles');
        Route::put('/update/{id}', 'update')->name('update')->middleware('permission:manage roles');
        Route::delete('/delete/{role}', 'delete')->name('delete')->middleware('permission:manage roles');
    });



    // Route::controller(RoleController::class)->prefix('roles')->name('role.')->group(function () {
    //     Route::get('/list', 'list')->name('list');
    //     Route::get('/create', 'create')->name('create');
    //     Route::post('/store', 'store')->name('store');
    //     Route::get('edit/{role}', 'edit')->name('edit');
    //     Route::put('/update/{id}', 'update')->name('update');
    // });



    // Route::controller(ReportController::class)->prefix('report')->name('report.')->group(function () {
    //     Route::post('/courses', 'pdfCourses')->name('courses');
    //     Route::post('/instructors', 'pdfInstructors')->name('instructors');
    //     Route::post('/assignments', 'pdfAssignments')->name('assignments');
    // });

});





require __DIR__.'/auth.php';
