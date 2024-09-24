<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function analyze(Request $request)
    {
        $validatedData = $request->validate([
            'text' => 'required|string',
        ]);

        $text = escapeshellarg($validatedData['text']);  // 防止shell注入
        $pythonScript = base_path('app/Console/Commands/analyze_sentiment.py');  // Python腳本的路徑

        $command = "python3 $pythonScript $text";
        
        try {
            // 執行Python腳本並獲取結果
            $sentiment = shell_exec($command);
            if ($sentiment === null) {
                throw new \Exception("Error executing Python script");
            }

            // 假設主題識別結果從另一個服務中獲取
            $topic = "民眾黨"; // 示例結果

            $response = [
                'keyPeople' => [
                    ['name' => '柯文哲'],
                    ['name' => '高虹安'],
                ],
                'topic' => $topic,
                'sentiment' => trim($sentiment),  // 去掉可能的空格或換行符
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            // 捕獲錯誤並返回錯誤響應
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
