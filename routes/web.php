<?php

use App\Http\Controllers\SylabusController;
use App\Http\Controllers\UniversityController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('sylabus', function () {
    return Inertia::render('Sylabus');
})->middleware(['auth', 'verified'])->name('sylabus');

Route::get('/uczelnie', [UniversityController::class, 'index'])->name('uczelnie');
Route::post('/uczelnie', [UniversityController::class, 'store'])->name('uczelnie.store');
Route::delete('/universities/{university}', [UniversityController::class, 'destroy'])->name('uczelnie.destroy');

Route::get('/sylabus', [SylabusController::class, 'index'])->name('sylabus');
Route::get('/sylabus/dodaj', [SylabusController::class, 'create'])->name('sylabus.create');
Route::post('/sylabus', [SylabusController::class, 'store'])->name('sylabus.store');

Route::get('/sylabus/{courseId}/history', [SylabusController::class, 'history'])->name('sylabus.history');
Route::get('/sylabus/{courseId}/version/{versionNumber}', [SylabusController::class, 'showVersion'])->name('sylabus.version');
Route::get('/sylabus/{courseId}', [SylabusController::class, 'show'])->name('sylabus.show');
Route::get('/sylabus/{courseId}/diff/{versionNumber}', [SylabusController::class, 'diff'])->name('syllabus.diff');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
