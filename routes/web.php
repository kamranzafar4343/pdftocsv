<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;




Route::get('/', function () {
    return view('pdf');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::get('/pdf', fn() => view('pdf'));
Route::post('/convert', [PdfController::class, 'convert'])->name('pdf.convert');


