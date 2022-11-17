<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
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

    Route::get('/view-product', [ProductController::class, 'index'])->name('product.view');
    Route::get('/create-product', [ProductController::class, 'create'])->name('product.create');
    Route::get('/update-product/{productid}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/store-product', [ProductController::class, 'store'])->name('product.store');
    Route::put('/update-product/{productid}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/delete-product/{productid}', [ProductController::class, 'destroy'])->name('product.delete');

});



require __DIR__.'/auth.php';
