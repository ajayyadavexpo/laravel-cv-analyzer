<?php

use App\Http\Controllers\ResumeAnalyzerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ResumeAnalyzerController::class, 'index'])->name('resume.index');
Route::post('/analyze', [ResumeAnalyzerController::class, 'analyze'])->name('resume.analyze');

