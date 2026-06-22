<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ─── Public ────────────────────────────────────────────────────────────────
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// ─── Google OAuth ───────────────────────────────────────────────────────────
Route::get('/auth/google',          [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// ─── Admin ──────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Courses CRUD
    Route::resource('courses', AdminCourseController::class);

    // Lectures inside a course
    Route::post('courses/{course}/lectures',          [AdminCourseController::class, 'storeLecture'])->name('courses.lectures.store');
    Route::delete('courses/{course}/lectures/{lecture}', [AdminCourseController::class, 'destroyLecture'])->name('courses.lectures.destroy');
});

// ─── Student ─────────────────────────────────────────────────────────────────
Route::prefix('student')->name('student.')->middleware(['auth', 'role:student'])->group(function () {

    Route::get('/courses',                    [StudentCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}',           [StudentCourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{course}/enroll',   [StudentCourseController::class, 'enroll'])->name('courses.enroll');
    Route::delete('/courses/{course}/enroll', [StudentCourseController::class, 'unenroll'])->name('courses.unenroll');
    Route::get('/my-courses',                 [StudentCourseController::class, 'myCourses'])->name('my-courses');
});

// ─── Breeze Auth Routes ──────────────────────────────────────────────────────
require __DIR__ . '/auth.php';
