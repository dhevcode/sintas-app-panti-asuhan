<?php
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\InventoriController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnakAsuhController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth.custom');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Proteksi Halaman Dashboard dengan Middleware sederhana
Route::middleware(['auth.custom'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/anak', function () { return view('admin.anak.index'); })->name('anak.index');

    // CRUD Anak Asuh
    Route::get('/anak', [AnakAsuhController::class, 'index'])->name('anak.index');
    Route::post('/anak', [AnakAsuhController::class, 'store'])->name('anak.store');
    Route::delete('/anak/{id}', [AnakAsuhController::class, 'destroy'])->name('anak.destroy');
    Route::get('/anak/{id}/edit', [AnakAsuhController::class, 'edit'])->name('anak.edit');
    Route::put('/anak/{id}', [AnakAsuhController::class, 'update'])->name('anak.update');

    //CRUD Keuangan
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::post('/keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');
    
    //CRUD Inventori
    Route::get('/inventori', [InventoriController::class, 'index'])->name('inventori.index');
    Route::post('/inventori', [InventoriController::class, 'store'])->name('inventori.store');
    Route::get('/inventori/{id}/edit', [InventoriController::class, 'edit'])->name('inventori.edit');
    Route::put('/inventori/{id}', [InventoriController::class, 'update'])->name('inventori.update'); 
    Route::delete('/inventori/{id}', [InventoriController::class, 'destroy'])->name('inventori.destroy');

    // CRUD Artikel
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit'); 
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update'); 
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');

});
