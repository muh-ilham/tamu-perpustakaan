<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VisitorController;

Route::get('/', [VisitorController::class, 'index'])->name('visitor.index');
Route::post('/visitor', [VisitorController::class, 'store'])->name('visitor.store');

Route::get('/dashboard', function () {
    $stats = [
        'total' => \App\Models\Visitor::count(),
        'today' => \App\Models\Visitor::whereDate('created_at', now()->toDateString())->count(),
    ];
    return view('dashboard', compact('stats'));
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
    $results = [];
    
    try {
        // 1. Generate App Key if not exists
        if (!config('app.key')) {
            \Illuminate\Support\Facades\Artisan::call('key:generate', ['--force' => true]);
            $results[] = 'Key Generated';
        }
        
        // 2. Cache Configuration
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        $results[] = 'Cache Cleared';

        // 3. Migrate and seed
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $results[] = 'Database Migrated and Seeded';

        // 4. Virtual Storage Link Fallback (Since symlink() is disabled by host)
        $results[] = 'Host blocks symlink(). Virtual Storage Route activated.';
        
        // 5. Safe cleanup (Clear instead of Cache to avoid path issues)
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        
        // 6. Fix Permissions (For image readability)
        @chmod(storage_path('app/public'), 0775);
        @chmod(storage_path('app/public/visitors'), 0775);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Sistem berhasil diinstal! Foto akan dimuat via Virtual Route.',
            'steps' => $results,
            'details' => [
                'app_url' => config('app.url'),
                'storage_mode' => 'Virtual Route',
                'storage_readable' => is_readable(storage_path('app/public')),
                'artisan_output' => \Illuminate\Support\Facades\Artisan::output()
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            'completed_steps' => $results
        ], 500);
    }
});

// Virtual Storage Route for Restricted Hosting
Route::get('/storage/{path}', function ($path) {
    // 1. Try to find in public/storage first (if it's a real file)
    $publicPath = public_path('storage/' . $path);
    if (file_exists($publicPath) && !is_dir($publicPath)) {
        return response()->file($publicPath);
    }
    
    // 2. Try to find in storage/app/public
    $storagePath = storage_path("app/public/$path");
    if (file_exists($storagePath)) {
        return response()->file($storagePath);
    }

    // 3. Last resort: check storage/app
    $altPath = storage_path("app/$path");
    if (file_exists($altPath)) {
        return response()->file($altPath);
    }
    
    abort(404, "File not found at $storagePath");
})->where('path', '.*');
