<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function getTrendData(Request $request)
    {
        $data = $this->analyticsService->getTrendData(
            $request->input('selectedIndustry'),
            $request->input('selectedWord'),
            $request->input('startDate'),
            $request->input('endDate'),
            $request->input('selectedClass'),
            $request->input('selectedSentiments')
        );
        return response()->json($data);
    }

    public function getColumnData(Request $request)
    {
        $data = $this->analyticsService->getColumnData(
            $request->input('selectedIndustry'),
            $request->input('selectedWord'),
            $request->input('startDate'),
            $request->input('endDate'),
            $request->input('selectedClass'),
            $request->input('selectedSentiments')
        );
        return response()->json($data);
    }

    public function getBubbleData(Request $request)
    {
        $data = $this->analyticsService->getBubbleData(
            $request->input('selectedIndustry'),
            $request->input('selectedWord'),
            $request->input('startDate'),
            $request->input('endDate'),
            $request->input('selectedClass'),
            $request->input('selectedSentiments')
        );
        return response()->json($data);
    }

    public function getPackedBubbleData(Request $request)
    {
        $data = $this->analyticsService->getPackedBubbleData(
            $request->input('selectedIndustry'),
            $request->input('selectedWord'),
            $request->input('startDate'),
            $request->input('endDate'),
            $request->input('selectedClass'),
            $request->input('selectedSentiments')
        );
        return response()->json($data);
    }


    public function getNetworkData(Request $request)
    {
        $data = $this->analyticsService->getNetworkData(
            $request->input('selectedIndustry'),
            $request->input('selectedWord'),
            $request->input('startDate'),
            $request->input('endDate'),
            $request->input('selectedClass'),
            $request->input('selectedSentiments')
        );
        return response()->json($data); 
    } 
    
    public function getRankingData(Request $request)
    {
        $data = $this->analyticsService->getRankingData(
            $request->input('selectedIndustry'),
            $request->input('selectedWord'),
            $request->input('startDate'),
            $request->input('endDate'),
            $request->input('selectedClass'),
            $request->input('selectedSentiments')
        );
        return response()->json($data); 
    }
    
    
        public function getPoliticianData(Request $request)
        {
            $data = $this->analyticsService->getPoliticianData(
                $request->input('selectedIndustry'),
                $request->input('selectedWord'),
                $request->input('startDate'),
                $request->input('endDate'),
                $request->input('selectedClass'),
                $request->input('selectedSentiments')
            );
            return response()->json($data);
        }
    }