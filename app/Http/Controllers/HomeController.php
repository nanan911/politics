<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        public AnalyticsService $analyticsService
    ) {
    }

    public function index(Request $request): View
    {
        $selectedindustry = $request->input('selected_industry');
        $selectedword = $request->input('selected_word');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedClass = $request->input('selected_class');
        $selectedSentiments = $request->input('selected_sentiment');
        
        $trendData = $this->analyticsService->getTrendData($selectedindustry, $selectedword, $startDate, $endDate, $selectedClass, $selectedSentiments);
        $columnData = $this->analyticsService->getColumnData($selectedindustry, $selectedword, $startDate, $endDate, $selectedClass, $selectedSentiments);
        $bubbleData = $this->analyticsService->getBubbleData($selectedindustry, $selectedword, $startDate, $endDate, $selectedClass, $selectedSentiments);
        $packedbubbleData = $this->analyticsService->getPackedBubbleData($selectedindustry, $selectedword, $startDate, $endDate, $selectedClass, $selectedSentiments);
        // $networkData = $this->analyticsService->getNetworkData($selectedindustry, $selectedword, $startDate, $endDate, $selectedClass, $selectedSentiments);
        
        // dd($networkData);
        return view('home')->with('trend_data', $trendData)->with('column_data', $columnData)->with('bubble_data', $bubbleData)->with('packedbubble_data', $packedbubbleData);
        // ->with('network_data', $networkData)
        
    }
}
