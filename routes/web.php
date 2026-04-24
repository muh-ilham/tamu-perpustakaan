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

        // 4. Fix Storage Link (Very important for images on live server)
        if (file_exists(public_path('storage'))) {
            @unlink(public_path('storage'));
        }
        
        try {
            \Illuminate\Support\Facades\Artisan::call('storage:link');
            $results[] = 'Storage link created successfully';
        } catch (\Exception $e) {
            $results[] = 'Artisan storage:link failed, attempting manual symlink...';
            $target = storage_path('app/public');
            $shortcut = public_path('storage');
            @symlink($target, $shortcut);
            $results[] = 'Manual symlink attempt completed';
        }

        // 5. Final optimization
        \Illuminate\Support\Facades\Artisan::call('config:cache');
        \Illuminate\Support\Facades\Artisan::call('route:cache');
        \Illuminate\Support\Facades\Artisan::call('view:cache');
        
        return response()->json([
            'status' => 'success',
            'message' => 'Sistem berhasil diinstal dan dioptimasi!',
            'steps' => $results,
            'details' => [
                'app_url' => config('app.url'),
                'storage_path_exists' => file_exists(storage_path('app/public')),
                'public_storage_exists' => file_exists(public_path('storage')),
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
