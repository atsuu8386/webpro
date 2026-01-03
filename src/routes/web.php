<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\SiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes for public website
|
*/

Route::get('/', [SiteController::class, 'index'])->name('site.index');
Route::get('/index', [SiteController::class, 'index'])->name('site.index');
