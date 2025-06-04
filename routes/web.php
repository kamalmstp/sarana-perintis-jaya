<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicePrintController;

Route::get('/invoice/{invoice}/pdf', [InvoicePrintController::class, 'download'])->name('invoice.pdf');

// Route::get('/', function () {
//     return view('welcome');
// });
