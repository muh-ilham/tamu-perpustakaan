<?php

use Illuminate\Support\Facades\Route;

// Visitor Routes
Route::get('/', 'App\Http\Controllers\VisitorController@index')->name('visitor.index');
Route::post('/visitor/store', 'App\Http\Controllers\VisitorController@store')->name('visitor.store');

// Admin Dashboard
Route::get('/dashboard', 'App\Http\Controllers\VisitorController@adminIndex')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', 'App\Http\Controllers\ProfileController@edit')->name('profile.edit');
    Route::patch('/profile', 'App\Http\Controllers\ProfileController@update')->name('profile.update');
    Route::delete('/profile', 'App\Http\Controllers\ProfileController@destroy')->name('profile.destroy');

    // Visitor Management
    Route::get('/admin/visitors', 'App\Http\Controllers\VisitorController@adminIndex')->name('admin.visitors.index');
    Route::delete('/admin/visitors/{visitor}', 'App\Http\Controllers\VisitorController@destroy')->name('admin.visitors.destroy');
    Route::delete('/admin/visitors-clear', 'App\Http\Controllers\VisitorController@destroyAll')->name('admin.visitors.destroyAll');
    
    // Settings Management
    Route::get('/admin/settings', 'App\Http\Controllers\SettingController@index')->name('admin.settings.index');
    Route::post('/admin/settings', 'App\Http\Controllers\SettingController@update')->name('admin.settings.update');
});

require __DIR__.'/auth.php';

// Temporary route for setup on cPanel
Route::get('/install', function () {
    $results = [];
    try {
        if (!config('app.key')) {
            \Illuminate\Support\Facades\Artisan::call('key:generate', ['--force' => true]);
            $results[] = 'Key Generated';
        }
        
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        $results[] = 'Cache Cleared';

        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $results[] = 'Database Migrated and Seeded';

        @chmod(public_path('storage'), 0777);
        @chmod(public_path('storage/visitors'), 0777);
        $results[] = 'Permissions Updated';
        
        return response()->json(['status' => 'success', 'steps' => $results]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
});

// Virtual Storage Route Fallback
Route::get('/storage/{path}', function ($path) {
    $publicPath = public_path('storage/' . $path);
    if (file_exists($publicPath) && !is_dir($publicPath)) {
        return response()->file($publicPath);
    }
    $storagePath = storage_path("app/public/$path");
    if (file_exists($storagePath)) {
        return response()->file($storagePath);
    }
    abort(404);
})->where('path', '.*');
