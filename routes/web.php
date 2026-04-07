<?php

use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\Counsellor\DashboardController as CounsellorDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestBookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Training\ProgrammeController as TrainingProgrammeController;
use App\Http\Controllers\Training\RegistrationController;
use App\Support\Roles;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/training', [TrainingProgrammeController::class, 'index'])->name('training.index');
Route::get('/training/{programme}', [TrainingProgrammeController::class, 'show'])->name('training.show');

// Guest booking (no auth required).
Route::post('/book', [GuestBookingController::class, 'store'])->name('book.store');
Route::post('/book/payment-callback', [PaymentCallbackController::class, 'store'])->name('book.payment.callback');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/training/{programme}/register', [RegistrationController::class, 'store'])
        ->name('training.register');

    Route::middleware('role:'.Roles::CLIENT)->prefix('client')->name('client.')->group(function () {
        Route::get('/bookings', [ClientBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/create', [ClientBookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings', [ClientBookingController::class, 'store'])->name('bookings.store');
    });

    Route::middleware('role:'.Roles::COUNSELLOR)->prefix('counsellor')->name('counsellor.')->group(function () {
        Route::get('/dashboard', [CounsellorDashboardController::class, 'index'])->name('dashboard');
        Route::post('/availability', [CounsellorDashboardController::class, 'storeAvailability'])->name('availability.store');
        Route::post('/attendance', [CounsellorDashboardController::class, 'storeAttendance'])->name('attendance.store');
    });

});

require __DIR__.'/auth.php';
