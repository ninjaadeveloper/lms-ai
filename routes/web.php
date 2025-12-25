<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\AiAssistantController;
use App\Http\Controllers\Admin\FeedbackController;

use App\Http\Controllers\ProfileController;

// ---------------- AUTH ----------------
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------------- COMMON (ALL ROLES) ----------------
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');
});

// ---------------- ADMIN ----------------
// ---------------- ADMIN ----------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Users
        Route::get('/users/trainers', [UserController::class, 'trainers'])->name('users.trainers');
        Route::get('/users/students', [UserController::class, 'students'])->name('users.students');
        Route::resource('/users', UserController::class);

        // ✅ ADMIN ALL ENROLLMENTS (Sidebar page) - NO PARAM
        Route::get('/enrollments', [CourseController::class, 'allEnrollments'])
            ->name('enrollments.index');

        // ✅ ADMIN PER-COURSE ENROLLMENTS - requires {course}
        Route::get('/courses/{course}/enrollments', [CourseController::class, 'enrollments'])
            ->name('courses.enrollments');

        // Optional admin enroll/remove
        Route::post('/courses/{course}/enroll', [CourseController::class, 'enrollStudent'])
            ->name('courses.enroll');
        Route::delete('/courses/{course}/remove/{student}', [CourseController::class, 'removeStudent'])
            ->name('courses.removeStudent');

        // Courses resource
        Route::resource('/courses', CourseController::class);

        // AI course description (optional)
        Route::post('/courses/{course}/ai-description', [CourseController::class, 'generateAiDescription'])
            ->name('courses.aiDescription');

        // Quizzes
        Route::resource('/quizzes', QuizController::class);
        Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');

        // AI Assistant
        Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai.index');
        Route::post('/ai-assistant/send', [AiAssistantController::class, 'send'])->name('ai.send');

        // ✅ Feedback (ADMIN)
        Route::get('/feedback-list', [FeedbackController::class, 'adminIndex'])->name('feedback.admin');

        Route::get('/feedback/{feedback}', [FeedbackController::class, 'adminShow'])->name('feedback.show');
        Route::patch('/feedback/{feedback}/status', [FeedbackController::class, 'updateStatus'])->name('feedback.status');

        // ✅ Extra: if blade POST bhej rahi ho to 405 na aaye
        Route::post('/feedback/{feedback}/status', [FeedbackController::class, 'updateStatus'])->name('feedback.status.post');
    });


// ---------------- TRAINER ----------------
Route::middleware(['auth', 'role:trainer'])
    ->prefix('trainer')
    ->name('trainer.')
    ->group(function () {

        Route::get('/dashboard', fn() => redirect()->route('dashboard'))->name('dashboard');

        // ✅ TRAINER ALL ENROLLMENTS (Sidebar page) - NO PARAM
        Route::get('/enrollments', [CourseController::class, 'trainerEnrollmentsIndex'])
            ->name('enrollments.index');

        // ✅ TRAINER PER-COURSE ENROLLMENTS - requires {course}
        Route::get('/courses/{course}/enrollments', [CourseController::class, 'trainerEnrollments'])
            ->name('courses.enrollments');

        // Courses (trainer)
        Route::resource('/courses', CourseController::class)
            ->only(['index', 'show', 'edit', 'update'])
            ->names('courses');

        // Feedback
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

        // AI Assistant
        Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai.index');
        Route::post('/ai-assistant/send', [AiAssistantController::class, 'send'])->name('ai.send');
    });

// ---------------- STUDENT ----------------
Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        Route::get('/dashboard', fn() => redirect()->route('dashboard'))->name('dashboard');

        Route::resource('/courses', CourseController::class)
            ->only(['index', 'show'])
            ->names('courses');

        Route::post('/courses/{course}/enroll', [CourseController::class, 'studentEnroll'])
            ->name('courses.enroll');

        // Feedback
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

        // AI Assistant
        Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai.index');
        Route::post('/ai-assistant/send', [AiAssistantController::class, 'send'])->name('ai.send');
    });

// ---------------------------------------------------------------------
// ✅ ROUTE ALIASES (TEMP FIX) for old blades using route('courses.index')
// ---------------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/courses', fn() => redirect()->route('admin.courses.index'))->name('courses.index');
    Route::get('/courses/create', fn() => redirect()->route('admin.courses.create'))->name('courses.create');
    Route::get('/courses/{course}', fn($course) => redirect()->route('admin.courses.show', $course))->name('courses.show');
    Route::get('/courses/{course}/edit', fn($course) => redirect()->route('admin.courses.edit', $course))->name('courses.edit');

    Route::get('/users', fn() => redirect()->route('admin.users.index'))->name('users.index');
    Route::get('/users/create', fn() => redirect()->route('admin.users.create'))->name('users.create');
    Route::get('/users/{user}', fn($user) => redirect()->route('admin.users.show', $user))->name('users.show');
    Route::get('/users/{user}/edit', fn($user) => redirect()->route('admin.users.edit', $user))->name('users.edit');
});
