<?php

use App\Http\Controllers\BookMasterController;
use App\Http\Controllers\CategoryMasterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublisherMasterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WriterMasterController;
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



Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->to('book');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('user', UserController::class);
    Route::resource('category', CategoryMasterController::class);
    Route::resource('publisher', PublisherMasterController::class);
    Route::resource('writer', WriterMasterController::class);
    Route::resource('book', BookMasterController::class);

    Route::prefix('reports')->group(function () {
    Route::get('/book-category', [ReportController::class, 'reportByCategory'])->name('reports.category');
    Route::get('/book-publisher', [ReportController::class, 'reportByPublisher'])->name('reports.publisher');
    Route::get('/book-writer', [ReportController::class, 'reportByWriter'])->name('reports.writer');
    });

});

require __DIR__.'/auth.php';
