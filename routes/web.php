<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VisitorController;

Route::get('/', [VisitorController::class, 'index'])->name('visitor.index');
Route::post('/visitor', [VisitorController::class, 'store'])->name('visitor.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin Visitor Routes
    Route::get('/admin/visitors', [VisitorController::class, 'adminIndex'])->name('admin.visitors.index');

    // Settings Routes
    Route::get('/admin/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('admin.settings.update');
});

require __DIR__.'/auth.php';
