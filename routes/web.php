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
use App\Http\Controllers\ProjectEntryController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
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
    Route::get('get-target', [ProjectController::class, 'target'])->name('getTarget');
    Route::get('get-capaian', [ProjectController::class, 'capaian'])->name('getCapaian');
    Route::get('/project-export', [ProjectController::class, 'projectExport'])->name('project.export');
    Route::resource('/entry', ProjectEntryController::class); //Entry Project
    // Route::get('entry/create', [ProjectEntryController::class, 'create'])->name('entry.create');
    Route::resource('/pembelian', PembelianController::class); //Pembelian
    Route::get('/pembelian-export', [PembelianController::class, 'pembelianExport'])->name('pembelian.export');
    Route::resource('/penjualan', PenjualanController::class); //Penjualan
    Route::resource('/pengiriman', PengirimanController::class); //Pengiriman
    Route::get('/pengiriman-export', [PengirimanController::class, 'pengirimanExport'])->name('pengiriman.export');
    Route::get('/pengiriman-solar', [PengirimanController::class, 'solar'])->name('pengiriman.solar');
    Route::put('/pengiriman-solar-update/{pengiriman}', [PengirimanController::class, 'solarUpdate'])->name('pengiriman.solar.update');
    Route::resource('/stock', StockController::class); //Stock
});

require __DIR__.'/auth.php';

//* Artisan Commands
Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');

    return redirect('/login')->with(['success' => 'Optimization Berhasil']);
});
