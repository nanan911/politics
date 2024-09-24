<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CrawlerController;
use App\Http\Controllers\ArticleTransferController;
use App\Http\Controllers\TfidfController;

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\TextAnalysisController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

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

// Route::get('/', function () {
//     return view('layouts.app'); // 返回主應用的 Blade 模板，React 應用會在這裡加載
// });

Route::get('/', function () {
    return view('app');
});

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/calculate-tfidf', [TfidfController::class, 'calculateTfidf']);


Route::middleware(['auth'])->group(function () {
    Route::any('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/advanced-search', [HomeController::class, 'search']);
    Route::get('/article', [ArticleController::class, 'index'])->name('article');
    Route::get('/article/{id}', [ArticleController::class, 'show'])->name('article.show');
    //爬蟲
    Route::get('/', [CrawlerController::class, 'index'])->name('index');
    Route::post('/scrape', [CrawlerController::class, 'scrape']);
    Route::get('/search', [CrawlerController::class, 'search']);
    Route::post('/delete_article', [CrawlerController::class, 'deleteArticle']);
    Route::get('/edit_article', [CrawlerController::class, 'editArticle']);
    Route::post('/save_article', [CrawlerController::class, 'saveArticle']);
    Route::get('/results', [CrawlerController::class, 'search'])->name('results');


});

Auth::routes();

// Catch-all route for React
Route::get('/{any}', function () {
    return view('layouts.app'); // 返回主應用的 Blade 模板，React 應用會在這裡加載
})->where('any', '.*');

// 在 routes/api.php 中
Route::post('/analyze', [AnalysisController::class, 'analyze']);
//process-keywordsArticleService
Route::get('/process-keywords/{id}', [ArticleController::class, 'processKeywords']);

//爬蟲

//臨時表單轉入正式表單
Route::get('/transfer', [ArticleTransferController::class, 'transfer'])->name('transfer');
//正式表單
Route::get('/articles', [ArticleTransferController::class, 'index'])->name('articles.index');
Route::get('/articles', [CrawlerController::class, 'index']);



Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
