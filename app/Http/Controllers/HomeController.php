<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Comment;

class HomeController extends Controller
{
    public function getTrendData(Request $request) {
    // 与 index 方法类似的逻辑
    // return response()->json($this->analyticsService->getTrendData(...));
}
// 其他方法类似
// HomeController.php
public function getUserComments($authorId)
{
    $comments = Comment::where('author_id', $authorId)
        ->select( 'comment', 'state')
        ->get();

    return response()->json($comments);
}

    public function __construct(
        public AnalyticsService $analyticsService
    )
    {

    }

    public function index(Request $request): View
    {
        // 從請求中獲取參數
        $selectedIndustry = $request->input('selected_industry');
        $selectedWord = $request->input('selected_word');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedClass = $request->input('selected_class');
        $selectedSentiments = $request->input('selected_sentiment');
        
        // 呼叫服務層以獲取數據
        $trendData = $this->analyticsService->getTrendData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);
        $columnData = $this->analyticsService->getColumnData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);
        $bubbleData = $this->analyticsService->getBubbleData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);
        $packedbubbleData = $this->analyticsService->getPackedBubbleData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);
        
        // 設定中心性閾值，或從請求中取得
        $centralityThreshold = 3;
        $networkData = $this->analyticsService->getNetworkData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments, $centralityThreshold);
        
        // 獲取政治人物數據
        $politicianData = $this->analyticsService->getPoliticianData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);
    
        // 獲取排行榜數據
        $rankingData = $this->analyticsService->getRankingData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);
    
        // 傳遞數據到視圖
        return view('home', [
            'trend_data' => $trendData,
            'column_data' => $columnData,
            'bubble_data' => $bubbleData,
            'packedbubble_data' => $packedbubbleData,
            'network_data' => $networkData, 
            'politician_data' => $politicianData, 
            'ranking_data' => $rankingData, // 確保這裡添加了 ranking_data
        ]);
    }
    

}
