<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\SportTypeController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Public event listing for all authenticated users
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
});

// Admin-only routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Admin Events Management
    Route::get('/events', [EventController::class, 'adminIndex'])->name('admin.events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('admin.events.create');
    Route::post('/events', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
    Route::patch('/events/{event}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');
    
    // Sport Types Management
    Route::get('/sport-types', [SportTypeController::class, 'index'])->name('admin.sport_types.index');
    Route::get('/sport-types/create', [SportTypeController::class, 'create'])->name('admin.sport_types.create');
    Route::post('/sport-types', [SportTypeController::class, 'store'])->name('admin.sport_types.store');
    Route::get('/sport-types/{sportType}/edit', [SportTypeController::class, 'edit'])->name('admin.sport_types.edit');
    Route::patch('/sport-types/{sportType}', [SportTypeController::class, 'update'])->name('admin.sport_types.update');
    Route::delete('/sport-types/{sportType}', [SportTypeController::class, 'destroy'])->name('admin.sport_types.destroy');
    
    // Organizers Management
    Route::get('/organizers', [OrganizerController::class, 'index'])->name('admin.organizers.index');
    Route::get('/organizers/create', [OrganizerController::class, 'create'])->name('admin.organizers.create');
    Route::post('/organizers', [OrganizerController::class, 'store'])->name('admin.organizers.store');
    Route::get('/organizers/{organizer}/edit', [OrganizerController::class, 'edit'])->name('admin.organizers.edit');
    Route::patch('/organizers/{organizer}', [OrganizerController::class, 'update'])->name('admin.organizers.update');
    Route::delete('/organizers/{organizer}', [OrganizerController::class, 'destroy'])->name('admin.organizers.destroy');
    
    // Users Management
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

require __DIR__.'/auth.php';