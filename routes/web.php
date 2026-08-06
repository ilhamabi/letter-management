<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Lecturer\DashboardController as LecturerDashboardController;
use App\Http\Controllers\Lecturer\SubmissionController as LecturerSubmissionController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\SubmissionController as StudentSubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')
    ->group(function () {

        Route::get('/letter/{filename}', function ($filename) {
            $path = resource_path('views/letter/' . $filename);
            if (!file_exists($path)) {
                abort(404);
            }

            $mimeType = match (pathinfo($filename, PATHINFO_EXTENSION)) {
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

        Route::prefix('admin')
            ->middleware('role:ADMIN')
            ->group(function () {

                Route::view(
                    '/dashboard',
                    'admin.dashboard'
                )->name('admin.dashboard');

                Route::prefix('letters')->group(function () {
                    Route::view(
                        '/',
                        'admin.letters.index'
                    )->name('admin.letters.index');

                    Route::view(
                        '/create',
                        'admin.letters.create'
                    )->name('admin.letters.create');

                    Route::view(
                        '/edit',
                        'admin.letters.edit'
                    )->name('admin.letters.edit');
                });

                // Legacy route name alias
                Route::view('/letters-legacy', 'admin.letters.index')->name('admin.letters');

                Route::view(
                    '/settings',
                    'admin.settings'
                )->name('admin.settings');
            });

        Route::prefix('student')
            ->middleware('role:STUDENT')
            ->group(function () {

                Route::get(
                    '/dashboard',
                    [StudentDashboardController::class, 'index']
                )->name('student.dashboard');

                Route::prefix('submissions')->group(function () {
                    Route::get(
                        '/',
                        [StudentSubmissionController::class, 'index']
                    )->name('student.submissions.history');

                    Route::get(
                        '/create',
                        [StudentSubmissionController::class, 'create']
                    )->name('student.submissions.create');

                    Route::post(
                        '/',
                        [StudentSubmissionController::class, 'store']
                    )->name('student.submissions.store');

                    Route::get(
                        '/{submission}',
                        [StudentSubmissionController::class, 'detail']
                    )->name('student.submissions.detail');
                });

                // Legacy aliases
                Route::get('/submission-history', [StudentSubmissionController::class, 'index'])->name('student.submission-history');
                Route::get('/submission', [StudentSubmissionController::class, 'create'])->name('student.submission');

                Route::view(
                    '/settings',
                    'student.settings'
                )->name('student.settings');
            });

        Route::prefix('lecturer')
            ->middleware('role:LECTURER')
            ->group(function () {

                Route::get(
                    '/dashboard',
                    [LecturerDashboardController::class, 'index']
                )->name('lecturer.dashboard');

                Route::prefix('submissions')->group(function () {
                    Route::get(
                        '/',
                        [LecturerSubmissionController::class, 'index']
                    )->name('lecturer.submissions.index');

                    Route::view(
                        '/detail',
                        'lecturer.submissions.detail'
                    )->name('lecturer.submissions.detail');

                    Route::view(
                        '/history',
                        'lecturer.submissions.history'
                    )->name('lecturer.submissions.history');
                });

                // Legacy approval aliases
                Route::get('/approval', [LecturerSubmissionController::class, 'index'])->name('lecturer.approval');
                Route::view('/approval/detail', 'lecturer.submissions.detail')->name('lecturer.approval-detail');
                Route::view('/approval-history', 'lecturer.submissions.history')->name('lecturer.approval-history');

                Route::view(
                    '/settings',
                    'lecturer.settings'
                )->name('lecturer.settings');
            });
    });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
