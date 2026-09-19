<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * مسارات إدارة المهام السبعة وفق نمط RESTful.
 * ينشئ هذا التعريف صفحات القائمة والإنشاء والعرض والتعديل،
 * بالإضافة إلى عمليات الحفظ والتحديث والحذف.
 */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('tasks', TaskController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
