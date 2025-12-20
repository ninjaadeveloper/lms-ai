<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\AIController;
use App\Http\Controllers\Admin\FeedbackController;



// Home → Dashboard
Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');
// Trainers
Route::get('/users/trainers', [UserController::class, 'trainers'])->name('users.trainers');

//Students
Route::get('/users/students', [UserController::class, 'students'])->name('users.students');

// Users
Route::resource('/users', UserController::class);


// Courses
Route::resource('/courses', CourseController::class);

// Course Enrollment
Route::post('/courses/{course}/enroll', [CourseController::class, 'enrollStudent'])
    ->name('courses.enroll');

Route::delete('/courses/{course}/remove/{student}', [CourseController::class, 'removeStudent'])
    ->name('courses.removeStudent');

// AI Course Description
Route::post('/courses/{course}/ai-description', [CourseController::class, 'generateAiDescription'])
    ->name('courses.aiDescription');

// Quizzes
Route::resource('/quizzes', QuizController::class);

// Quiz Results
Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])
    ->name('quizzes.results');

// AI Summaries
Route::get('/ai/student-performance', [AIController::class, 'studentPerformanceSummary'])
    ->name('ai.studentPerformance');

Route::get('/ai/feedback-summary', [AIController::class, 'feedbackSummary'])
    ->name('ai.feedbackSummary');

// Feedback
Route::get('/feedback', [FeedbackController::class, 'index'])
    ->name('feedback.index');

Route::post('/feedback', [FeedbackController::class, 'store'])
    ->name('feedback.store');
