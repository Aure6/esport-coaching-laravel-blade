<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/legal-notice', function () {
    return view('legal-notice');
})->name('legal.notice');

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/show/{id}', [GameController::class, 'show'])->name('games.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/coaches/show/{id}', [CoachController::class, 'show'])->name('coaches.show');
    Route::post('/availabilities.update', [AvailabilityController::class, 'update'])->name('availabilities.update');
    Route::post('/user/update-game', [CoachController::class, 'updateGame'])->name('user.updateGame');

    Route::post('/{coach_id}/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store'); // The auth middleware in Laravel is designed to redirect unauthenticated users to the login page. Once the user is authenticated, Laravel will redirect the user back to the original destination. So the store method will not be executed.
    Route::delete('/appointments/destroy/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    Route::post('/user/updateRole', [DashboardController::class, 'updateRole'])->name('user.updateRole');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
});

require __DIR__ . '/auth.php';
