<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PasswordGate;
use App\Livewire\ReceiptForm;
use App\Livewire\RequestList;

Route::get('/login', PasswordGate::class)->name('login');

Route::middleware(['page.password'])->group(function () {
    Route::get('/', ReceiptForm::class)->name('home');
    Route::get('/requests', RequestList::class)->name('requests.index');
});
