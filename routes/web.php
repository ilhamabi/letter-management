<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')
    ->group(function () {

Route::get('/lecturer', function () {
    return view('lecturer.dashboard');
});

Route::get('/lecturer/approval', function(){
    return view('lecturer.approval');
});

Route::get('/lecturer/approval/detail', function(){
    return view('lecturer.approval-detail');
});

Route::get('/letter/{filename}', function ($filename) {
    $path = resource_path('views/letter/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    
    $mimeType = match(pathinfo($filename, PATHINFO_EXTENSION)) {
        'css' => 'text/css',
        'png' => 'image/png',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        'html' => 'text/html',
        default => 'text/plain',
    };
    
    return response(file_get_contents($path))
        ->header('Content-Type', $mimeType);
});

Route::get('/lecturer/approval-history', function(){
    return view('lecturer.approval-history');
});

Route::get('/lecturer/settings', function(){
    return view('lecturer.settings');
});


Route::get('/student', function(){
    return view('student.dashboard');
});

Route::get('/student/submission', function(){
    return view('student.submission');
});

Route::get('/student/submission-history', function(){
    return view('student.submission-history');
});

Route::get('/student/settings', function(){
    return view('student.settings');
});
        Route::prefix('admin')
            ->middleware('role:ADMIN')
            ->group(function () {

                Route::view(
                    '/dashboard',
                    'admin.dashboard'
                )->name('admin.dashboard');
            });

        Route::prefix('student')
            ->middleware('role:STUDENT')
            ->group(function () {

                Route::view(
                    '/dashboard',
                    'student.dashboard'
                )->name('student.dashboard');
            });

        Route::prefix('lecturer')
            ->middleware('role:LECTURER')
            ->group(function () {

                Route::view(
                    '/dashboard',
                    'lecturer.dashboard'
                )->name('lecturer.dashboard');
            });
    });


// Route::get('/lecturer', function () {
//     return view('dosen.dashboard');
// });

// Route::get('/lecturer/approval', function(){
//     return view('dosen.approval');
// });

// Route::get('/lecturer/approval/detail', function(){
//     return view('dosen.approval-detail');
// });

// Route::get('/lecturer/approval-history', function(){
//     return view('dosen.approval-history');
// });

// Route::get('/lecturer/settings', function(){
//     return view('dosen.settings');
// });


// Route::get('/student', function(){
//     return view('mahasiswa.dashboard');
// });

// Route::get('/student/submission', function(){
//     return view('mahasiswa.submission');
// });

// Route::get('/student/submission-history', function(){
//     return view('mahasiswa.submission-history');
// });

// Route::get('/student/settings', function(){
//     return view('mahasiswa.settings');
// });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
