<?php

use App\Http\Controllers\AuthController;
use App\Livewire\OcrRequestForm;
use App\Livewire\RequestsList;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');

Route::middleware('page.password')->group(function () {
    Route::get('/', OcrRequestForm::class)->name('home');
    Route::get('/requests', RequestsList::class)->name('requests.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('/api')->middleware('authorisation')->group(function () {
    Route::get('/requests', [\App\Http\Controllers\APIController::class, 'getRequestsToImport']);
    Route::get('/requests/{request:id}/imported', [\App\Http\Controllers\APIController::class, 'markRequestAsImported']);
});
