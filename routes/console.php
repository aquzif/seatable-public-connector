<?php

use App\Schedules\OCRRequests;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(OCRRequests::class)
    ->name('OCR Schedule')
    ->everyMinute()
    ->withoutOverlapping();
