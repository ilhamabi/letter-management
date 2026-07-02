<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard-dosen', function () {
    return view('dosen.dashboard');
});

Route::get('/persetujuan-dokumen', function(){
    return view('dosen.pengajuan-surat');
});

Route::get('/persetujuan-dokumen/detail', function(){
    return view('dosen.detail-pengajuan');
});

Route::get('/riwayat-persetujuan', function(){
    return view('dosen.approval-history');
});

Route::get('/dashboard-mahasiswa', function(){
    return view('mahasiswa.dashboard');
});

Route::get('/pengajuan', function(){
    return view('mahasiswa.pengajuan');
});

Route::get('/riwayat-pengajuan', function(){
    return view('mahasiswa.riwayat-pengajuan');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
