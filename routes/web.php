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
Route::get('/', fn () => redirect()->route('login'));

Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ---------------- COMMON (ALL ROLES) ----------------
Route::middleware(['auth'])->group(function () {

    // ONE ENTRY dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (ALL roles)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Change password (ALL roles)
    Route::get('/change-password',  [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');
});

// ---------------- ADMIN ----------------
Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Users
        Route::get('/users/trainers', [UserController::class, 'trainers'])->name('users.trainers');
        Route::get('/users/students', [UserController::class, 'students'])->name('users.students');
        Route::resource('/users', UserController::class);

        // Courses
        Route::resource('/courses', CourseController::class);

        Route::post('/courses/{course}/enroll', [CourseController::class, 'enrollStudent'])->name('courses.enroll');
        Route::delete('/courses/{course}/remove/{student}', [CourseController::class, 'removeStudent'])->name('courses.removeStudent');
        Route::post('/courses/{course}/ai-description', [CourseController::class, 'generateAiDescription'])->name('courses.aiDescription');

        // Quizzes
        Route::resource('/quizzes', QuizController::class);
        Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');

        // Feedback (admin list)
        Route::get('/feedback-list', [FeedbackController::class, 'adminIndex'])->name('feedback.admin');

        // AI Assistant
        Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai.index');
        Route::post('/ai-assistant/send', [AiAssistantController::class, 'send'])->name('ai.send');
    });

// ---------------- TRAINER ----------------
Route::middleware(['auth','role:trainer'])
    ->prefix('trainer')
    ->name('trainer.')
    ->group(function () {

        // (optional) if you want /trainer/dashboard url too
        Route::get('/dashboard', fn()=>redirect()->route('dashboard'))->name('dashboard');

        // Trainer courses (resource => calls index/show/edit/update ONLY)
        Route::resource('/courses', CourseController::class)
            ->only(['index','show','edit','update'])
            ->names('courses');

        // Feedback
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

        // AI Assistant
        Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai.index');
        Route::post('/ai-assistant/send', [AiAssistantController::class, 'send'])->name('ai.send');
    });

// ---------------- STUDENT ----------------
Route::middleware(['auth','role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        // (optional) if you want /student/dashboard url too
        Route::get('/dashboard', fn()=>redirect()->route('dashboard'))->name('dashboard');

        // Student courses
        Route::resource('/courses', CourseController::class)
            ->only(['index','show'])
            ->names('courses');

        Route::post('/courses/{course}/enroll', [CourseController::class, 'studentEnroll'])->name('courses.enroll');

        // Feedback
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

        // AI Assistant
        Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai.index');
        Route::post('/ai-assistant/send', [AiAssistantController::class, 'send'])->name('ai.send');
    });


// ---------------------------------------------------------------------
// ✅ ROUTE ALIASES (TEMP FIX) so old blades like route('admin.users.show') work
// ---------------------------------------------------------------------
Route::middleware(['auth','role:admin'])->group(function () {
    // Users alias
    Route::get('/users', fn()=>redirect()->route('admin.users.index'))->name('users.index');
    Route::get('/users/create', fn()=>redirect()->route('admin.users.create'))->name('users.create');
    Route::get('/users/{user}', fn($user)=>redirect()->route('admin.admin.users.show',$user))->name('admin.users.show');

    // Courses alias
    Route::get('/courses', fn()=>redirect()->route('admin.courses.index'))->name('courses.index');
    Route::get('/courses/create', fn()=>redirect()->route('admin.courses.create'))->name('courses.create');
    Route::get('/courses/{course}', fn($course)=>redirect()->route('admin.courses.show',$course))->name('courses.show');
});
