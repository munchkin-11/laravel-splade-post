<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;


Route::middleware('splade')->group(function () {
    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['verified'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::prefix('admin')->as('admin.')->group(function () {

            Route::resource('/posts', PostController::class)
                ->scoped(['post' => 'slug']);

            Route::resource('/categories', CategoryController::class)
                ->scoped(['category' => 'slug']);
            Route::post('/categories/{category}/restore', [CategoryController::class, 'restore'])
                ->name('categories.restore');
            Route::delete('/categories/{category}/force', [CategoryController::class, 'force_delete'])
                ->name('categories.force');
        });
    });

    require __DIR__ . '/auth.php';
});
