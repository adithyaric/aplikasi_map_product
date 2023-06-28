<?php

use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UserController;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class); //Users
    Route::resource('/satuan', SatuanController::class); //Satuan
    Route::resource('/category', CategoryController::class); //Kategori
    Route::resource('/customer', CustomerController::class); //Kustomer
    Route::resource('/driver', DriverController::class); //Driver
    Route::resource('/bahanbaku', BahanBakuController::class); //Bahan Baku
    Route::resource('/product', ProductController::class); //Product
    Route::resource('/project', ProjectController::class); //Project
    Route::get('get-targets', [ProjectController::class, 'target'])->name('getTarget');
    Route::resource('/pembelian', PembelianController::class); //Pembelian
    Route::resource('/penjualan', PenjualanController::class); //Penjualan
    Route::resource('/pengiriman', PengirimanController::class); //Pengiriman
});

require __DIR__.'/auth.php';
