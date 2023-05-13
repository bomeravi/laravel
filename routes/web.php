<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','check_admin'])->group(function () {
    Route::get('/admin/dashboard',[\App\Http\Controllers\Admin\DashboardController::class,'index'])->name('admin.dashboard');
    Route::get('/admin/messages',[\App\Http\Controllers\Admin\MessagesController::class,'index'])->name('admin.messages.index');
    Route::get('/admin/messages/create',[\App\Http\Controllers\Admin\MessagesController::class,'create'])->name('admin.messages.create');
    Route::post('/admin/messages',[\App\Http\Controllers\Admin\MessagesController::class,'store'])->name('admin.messages.store');
    Route::get('/admin/users',[\App\Http\Controllers\Admin\UsersController::class,'index'])->name('admin.users');
    Route::get('/admin/ajax_users',[\App\Http\Controllers\Admin\UsersController::class,'ajax_users'])->name('admin.ajax_users');
});


require __DIR__.'/auth.php';
