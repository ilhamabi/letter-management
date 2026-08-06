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

                Route::view(
                    '/letters',
                    'admin.letters'
                )->name('admin.letters');
                Route::view(
                    '/letters/create',
                    'admin.letters-edit'
                )->name('admin.letters.create');
                Route::view(
                    '/letters/edit',
                    'admin.letters-edit'
                )->name('admin.letters.edit');

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

                Route::get(
                    '/submissions',
                    [StudentSubmissionController::class, 'index']
                )->name('student.submissions.history');

                Route::get(
                    '/submissions/create',
                    [StudentSubmissionController::class, 'create']
                )->name('student.submissions.create');

                Route::post(
                    '/submissions',
                    [StudentSubmissionController::class, 'store']
                )->name('student.submissions.store');

                Route::get(
                    '/submissions/{submission}',
                    [StudentSubmissionController::class, 'detail']
                )->name('student.submissions.detail');

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

                Route::get(
                    '/submissions',
                    [LecturerSubmissionController::class, 'index']
                )->name('lecturer.submissions.index');

                Route::view(
                    '/approval',
                    'lecturer.approval'
                )->name('lecturer.approval');

                Route::view(
                    '/approval/detail',
                    'lecturer.approval-detail'
                )->name('lecturer.approval-detail');

                Route::view(
                    '/approval-history',
                    'lecturer.approval-history'
                )->name('lecturer.approval-history');

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
