<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\AiAssistantController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Student\StudentQuizController;


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
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Users
        Route::get('/users/trainers', [UserController::class, 'trainers'])->name('users.trainers');
        Route::get('/users/students', [UserController::class, 'students'])->name('users.students');
        Route::resource('/users', UserController::class);

        // ✅ ADMIN ALL ENROLLMENTS (Sidebar page) - NO PARAM
        Route::get('/enrollments', [CourseController::class, 'allEnrollments'])->name('enrollments.index');

        // ✅ ADMIN PER-COURSE ENROLLMENTS
        Route::get('/courses/{course}/enrollments', [CourseController::class, 'enrollments'])->name('courses.enrollments');

        // enroll/remove
        Route::post('/courses/{course}/enroll', [CourseController::class, 'enrollStudent'])->name('courses.enroll');
        Route::delete('/courses/{course}/remove/{student}', [CourseController::class, 'removeStudent'])->name('courses.removeStudent');

        // Courses
        Route::resource('/courses', CourseController::class);

        // AI course description
        Route::post('/courses/{course}/ai-description', [CourseController::class, 'generateAiDescription'])->name('courses.aiDescription');

        // ✅ QUIZZES (ADMIN)
        Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');

        // ✅ Step-1: Select Course (no param)
        Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');

        // ✅ Step-2: Generator UI (course required)
        Route::get('/courses/{course}/quizzes/create', [QuizController::class, 'createForCourse'])
            ->name('courses.quizzes.create');

        // ✅ AI generate (AJAX)
        Route::post('/courses/{course}/quizzes/generate', [QuizController::class, 'generate'])
            ->name('courses.quizzes.generate');

        // ✅ Save selected (POST)
        Route::post('/courses/{course}/quizzes', [QuizController::class, 'store'])
            ->name('courses.quizzes.store');

        // optional view/delete
        Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
        Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');

        // (optional)
        Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');

        // AI Assistant
        Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai.index');
        Route::post('/ai-assistant/send', [AiAssistantController::class, 'send'])->name('ai.send');

        // Feedback (ADMIN)
        Route::get('/feedback-list', [FeedbackController::class, 'adminIndex'])->name('feedback.admin');
        Route::get('/feedback/{feedback}', [FeedbackController::class, 'adminShow'])->name('feedback.show');
        Route::patch('/feedback/{feedback}/status', [FeedbackController::class, 'updateStatus'])->name('feedback.status');
        Route::post('/feedback/{feedback}/status', [FeedbackController::class, 'updateStatus'])->name('feedback.status.post');
    });

// ---------------- TRAINER ----------------
Route::middleware(['auth', 'role:trainer'])
    ->prefix('trainer')
    ->name('trainer.')
    ->group(function () {

        Route::get('/dashboard', fn() => redirect()->route('dashboard'))->name('dashboard');

        // enrollments
        Route::get('/enrollments', [CourseController::class, 'trainerEnrollmentsIndex'])->name('enrollments.index');
        Route::get('/courses/{course}/enrollments', [CourseController::class, 'trainerEnrollments'])->name('courses.enrollments');

        // courses
        Route::resource('/courses', CourseController::class)
            ->only(['index', 'show', 'edit', 'update'])
            ->names('courses');

        // ✅ QUIZZES (TRAINER)
        Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');

        // ✅ Select Course
        Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');

        // ✅ Generator UI
        Route::get('/courses/{course}/quizzes/create', [QuizController::class, 'createForCourse'])
            ->name('courses.quizzes.create');

        Route::post('/courses/{course}/quizzes/generate', [QuizController::class, 'generate'])
            ->name('courses.quizzes.generate');

        Route::post('/courses/{course}/quizzes', [QuizController::class, 'store'])
            ->name('courses.quizzes.store');

        Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');

        Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');


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

        Route::post('/courses/{course}/enroll', [CourseController::class, 'studentEnroll'])->name('courses.enroll');

        // Feedback
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

        // AI Assistant
        Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai.index');
        Route::post('/ai-assistant/send', [AiAssistantController::class, 'send'])->name('ai.send');

        Route::get('/quizzes', [StudentQuizController::class, 'index'])
            ->name('quizzes.index');

        Route::get('/quizzes/{quiz}', [StudentQuizController::class, 'show'])
            ->name('quizzes.show');

        Route::post('/quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])
            ->name('quizzes.submit');

        Route::get('/quizzes/{quiz}/result', [StudentQuizController::class, 'result'])
            ->name('quizzes.result');

        // ✅ NEW: PDF Download
        Route::get('/quizzes/{quiz}/result/pdf', [StudentQuizController::class, 'downloadPdf'])
            ->name('quizzes.result.pdf');

        // ✅ (agar detail page already bana rahe ho)
        Route::get('/quizzes/{quiz}/result/detail', [StudentQuizController::class, 'resultDetail'])
            ->name('quizzes.result.detail');

    });

// ✅ (optional) route aliases (agar old blades use kar rahe ho)
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
