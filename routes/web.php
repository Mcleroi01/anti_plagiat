<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PlagiarismController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/plagiasme/{id}results', [DocumentController::class, 'showResults'])->name('document.results');
Route::get('/documents/upload', [DocumentController::class, 'create'])->name('documents.create');
Route::get('/documents/show', [DocumentController::class, 'show'])->name('documents.show');
Route::get('/documents/index', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/{document}/detect-plagiarism', [PlagiarismController::class, 'detect'])->name('documents.detect-plagiarism');
Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');




require __DIR__.'/auth.php';
