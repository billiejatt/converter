<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConvertController;

Route::get('/welcom', function () {
    return view('welcome');
});

// use App\Http\Controllers\ConvertController;
// use App\Http\Controllers\ConvertController;

Route::view('/', 'converter');
Route::post('/convert/file', [ConvertController::class, 'convertFile'])->name('convert.file');
Route::post('/convert/text', [ConvertController::class, 'convertText'])->name('convert.text');
Route::get('/download/csv', [ConvertController::class, 'downloadCsv'])->name('download.csv');
