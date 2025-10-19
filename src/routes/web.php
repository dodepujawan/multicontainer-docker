<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::resource('posts', PostController::class);

Route::get('/print', [PostController::class, 'print'])->name('print');

// routes/web.php
Route::get('/print-raw', [PostController::class, 'getRawPrint'])->name('print.raw');


