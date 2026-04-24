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

// Temporary route for setup on cPanel without Terminal
Route::get('/install', function () {
    try {
        // Generate App Key if not exists
        \Illuminate\Support\Facades\Artisan::call('key:generate', ['--force' => true]);
        
        // Cache Configuration
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        // Migrate and seed
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        
        // Storage link
        \Illuminate\Support\Facades\Artisan::call('storage:link');

        return response()->json([
            'status' => 'success',
            'message' => 'Database Migrated, Key Generated, and Storage Linked successfully!',
            'details' => \Illuminate\Support\Facades\Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});
