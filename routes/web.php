<?php

use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BranchController as AdminBranchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\OfferController as AdminOfferController;
use App\Http\Controllers\Admin\PatientReportController as AdminPatientReportController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientPortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/doctors', [HomeController::class, 'doctors'])->name('doctors');
Route::get('/branches', [HomeController::class, 'branches'])->name('branches');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/book', [HomeController::class, 'book'])->name('book');
Route::get('/offers', [HomeController::class, 'offers'])->name('offers');
Route::post('/book', [AppointmentController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('appointments.store');

Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/', [PatientPortalController::class, 'showLoginForm'])->name('login');
    Route::post('/send-otp', [PatientPortalController::class, 'sendOtp'])
        ->middleware('throttle:3,5')->name('send-otp');
    Route::get('/verify', [PatientPortalController::class, 'showVerifyForm'])->name('verify');
    Route::post('/verify', [PatientPortalController::class, 'verifyOtp'])->name('verify.submit');
    Route::get('/list', [PatientPortalController::class, 'reports'])->name('list');
    Route::get('/{report}/download', [PatientPortalController::class, 'downloadReport'])->name('download');
});

Route::get('/api/branches/{branch}/doctors', [HomeController::class, 'branchDoctors'])->name('api.branch.doctors');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.submit');
        Route::get('forgot-password', [AdminAuthController::class, 'showForgotPassword'])->name('password.request');
        Route::post('forgot-password', [AdminAuthController::class, 'sendResetLink'])->name('password.email');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('doctors', AdminDoctorController::class);
        Route::resource('services', AdminServiceController::class);
        Route::resource('branches', AdminBranchController::class);
        Route::resource('offers', AdminOfferController::class);
        Route::resource('reports', AdminPatientReportController::class);
        Route::resource('appointments', AdminAppointmentController::class)->except(['create', 'store']);
        Route::patch('appointments/{appointment}/approve', [AdminAppointmentController::class, 'approve'])->name('appointments.approve');
        Route::patch('appointments/{appointment}/cancel', [AdminAppointmentController::class, 'cancel'])->name('appointments.cancel');

        Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
        Route::get('profile', [AdminAuthController::class, 'editProfile'])->name('profile.edit');
        Route::put('profile', [AdminAuthController::class, 'updateProfile'])->name('profile.update');
    });
});
