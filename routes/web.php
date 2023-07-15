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
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\UserController;
use App\Models\Penjualan;
use App\Models\Project;
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
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class);
    Route::resource('/satuan', SatuanController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/supplier', SupplierController::class);
    Route::resource('/customer', CustomerController::class);
    Route::resource('/driver', DriverController::class);
    Route::resource('/truck', TruckController::class);
    Route::resource('/bahanbaku', BahanBakuController::class);
    Route::resource('/product', ProductController::class);
    Route::resource('/project', ProjectController::class);
    Route::patch('/projects/{project}/updateStatus', [ProjectController::class, 'updateStatus'])->name('projects.updateStatus');
    Route::get('get-target', [ProjectController::class, 'target'])->name('getTarget');
    Route::get('get-capaian', [ProjectController::class, 'capaian'])->name('getCapaian');
    Route::get('/project-export', [ProjectController::class, 'projectExport'])->name('project.export');
    Route::resource('/entry', ProjectEntryController::class);
    Route::resource('/pembelian', PembelianController::class);
    Route::patch('/pembelians/{pembelian}/updateStatus', [PembelianController::class, 'updateStatus'])->name('pembelians.updateStatus');
    Route::get('/pembelian-export', [PembelianController::class, 'pembelianExport'])->name('pembelian.export');
    Route::get('/pembelian-export-filter', [PembelianController::class, 'pembelianExportFilter'])->name('pembelian.exportFilter');
    Route::resource('/penjualan', PenjualanController::class);
    Route::resource('/pengiriman', PengirimanController::class);
    Route::get('/pengiriman-export', [PengirimanController::class, 'pengirimanExport'])->name('pengiriman.export');
    Route::get('/pengiriman-inout', [PengirimanController::class, 'pengirimaninout'])->name('pengiriman.inout');
    Route::get('/pengiriman-daily', [PengirimanController::class, 'pengirimanDaily'])->name('pengiriman.daily');
    Route::get('/pengiriman-nota', [PengirimanController::class, 'pengirimanNota'])->name('pengiriman.nota');
    Route::get('/pengiriman-solar', [PengirimanController::class, 'solar'])->name('pengiriman.solar');
    Route::put('/pengiriman-solar-update/{pengiriman}', [PengirimanController::class, 'solarUpdate'])->name('pengiriman.solar.update');
    Route::resource('/stock', StockController::class);

    Route::get('/pembelianexport', [PembelianController::class, 'indexReport'])->name('pembelian.exp');
    Route::get('/projectexport', [ProjectController::class, 'indexReport'])->name('project.exp');
    Route::get('/pengirimanexport', [PengirimanController::class, 'indexReport'])->name('pengiriman.exp');

    Route::get('/projects/{project}/data', function (Project $project) {
        return [
            'name' => $project->customer->name,
            'harga' => $project->product->harga,
            'capaian' => $project->entries->sum('capaian'),
        ];
    });

    Route::get('/penjualans/{penjualan}/data', function (Penjualan $penjualan) {
        return [
            'total_barang' => $penjualan->total_barang,
        ];
    });
});

require __DIR__.'/auth.php';

Route::get('/optimize', function () {
    Artisan::call('optimize:clear');

    return redirect('/login')->with(['success' => 'Optimization Berhasil']);
});
