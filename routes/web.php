<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && (str_contains(strtolower($user->email), 'dosen') || str_contains(strtolower($user->email), 'lecturer') || str_contains(strtolower($user->email), 'test'))) {
        // Default to student but support lecturer redirect if dosen/lecturer is in the email/username.
        // For 'test@example.com', let's default to student.
        if (str_contains(strtolower($user->email), 'dosen') || str_contains(strtolower($user->email), 'lecturer')) {
            return redirect('/lecturer');
        }
    }
    return redirect('/student');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/lecturer', function () {
    return view('dosen.dashboard');
});

Route::get('/lecturer/approval', function(){
    return view('dosen.approval');
});

Route::get('/lecturer/approval/detail', function(){
    return view('dosen.approval-detail');
});

Route::get('/lecturer/approval-history', function(){
    return view('dosen.approval-history');
});

Route::get('/student', function(){
    return view('mahasiswa.dashboard');
});

Route::get('/student/submission', function(){
    return view('mahasiswa.submission');
});

Route::get('/student/submission-history', function(){
    return view('mahasiswa.submission-history');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
