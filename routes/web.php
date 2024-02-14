<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::any('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/advanced-search', [HomeController::class, 'search']);
    Route::get('/article', [ArticleController::class, 'index'])->name('article');
});

Auth::routes();


// Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::post('/advanced-search', [HomeController::class, 'search']);


// Auth::routes();

// Route::get('/article', [ArticleController::class, 'index'])->name('article');


