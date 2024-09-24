<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\ArticleController;
use App\Models\TemporaryArticle;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    Route::get('/articles', [ArticleController::class, 'index']);
    // Route::get('/articles/{id}', [ArticleController::class, 'show']); // 添加此行

});


Route::get('/trend-data', [AnalyticsController::class, 'getTrendData']);
Route::get('/column-data', [AnalyticsController::class, 'getColumnData']);
Route::get('/bubble-data', [AnalyticsController::class, 'getBubbleData']);
Route::get('/packedbubble-data', [AnalyticsController::class, 'getPackedBubbleData']);
Route::get('/network-data', [AnalyticsController::class, 'getNetworkData']);
Route::get('/politician-data', [AnalyticsController::class, 'getPoliticianData']);
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('api.article.show');
Route::get('/comments/{authorId}', [HomeController::class, 'getUserComments']);
// Route::get('/ranking-data', [AnalyticsController::class, 'getRankingData']);
Route::get('/ranking-data', [AnalyticsController::class, 'getRankingData']);




// 文章分析
Route::post('/analyze', [AnalysisController::class, 'analyze']);

//爬蟲暫存表單
Route::post('/temporary-articles', function (Request $request) {
    $article = TemporaryArticle::create($request->all());
    return response()->json($article, 201);
});

// routes/api.php
Route::post('/login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('register', [AuthController::class, 'register']);
