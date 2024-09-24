<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;
use Illuminate\Support\Facades\Log; // 正确导入 Log
use Illuminate\Routing\Controller;
class TfidfController extends Controller
{

    public function calculateTfidf()
    {
        // 初始化 Jieba 分詞
        Jieba::init();
        Finalseg::init();
    
        Log::info('Jieba initialized.');
    
        // 從資料庫中獲取所有文章
        $articles = Article::all();
        Log::info('Fetched articles from database.', ['count' => $articles->count()]);
    
        // 停用詞
        $stopWords = file('stopwords.txt', FILE_IGNORE_NEW_LINES);
        Log::info('Loaded stopwords.');
    
        // 初始化詞頻統計
        $wordCounts = [];
        $docCount = count($articles);
    
        Log::info('Starting word frequency calculation.');
    
        // 對每篇文章進行分詞並計算詞頻
        foreach ($articles as $article) {
            $content = $article->content;
            $words = Jieba::cut($content);
    
            // 去除停用詞
            $words = array_filter($words, function ($word) use ($stopWords) {
                return !in_array($word, $stopWords) && mb_strlen($word) > 1;
            });
    
            // 計算詞頻
            foreach ($words as $word) {
                if (!isset($wordCounts[$article->id][$word])) {
                    $wordCounts[$article->id][$word] = 0;
                }
                $wordCounts[$article->id][$word]++;
            }
        }
    
        Log::info('Completed word frequency calculation.');
    
        // 計算 IDF 和 TF-IDF
        $idf = [];
        $tfIdf = [];
    
        foreach ($wordCounts as $docId => $words) {
            foreach ($words as $word => $count) {
                // 計算 IDF
                if (!isset($idf[$word])) {
                    $idf[$word] = 0;
                }
    
                $idf[$word]++;
            }
        }
    
        Log::info('Calculated IDF values.');
    
        // 計算 TF-IDF
        foreach ($wordCounts as $docId => $words) {
            foreach ($words as $word => $count) {
                $tf = $count / array_sum($words); // 詞頻 TF
                $idfValue = log($docCount / ($idf[$word] + 1)); // 逆文檔頻率 IDF
                $tfIdf[$docId][$word] = $tf * $idfValue; // 計算 TF-IDF
            }
        }
    
        Log::info('Calculated TF-IDF values.');
    
        // 排序並返回最高的詞語
        $topWords = [];
        foreach ($tfIdf as $docId => $words) {
            arsort($words); // 按 TF-IDF 排序
            $topWords[$docId] = array_slice($words, 0, 20, true); // 取前 20 名
        }
    
        Log::info('Sorted top words.');
    
        // 構建返回給前端的資料結構
        $bubbleChartData = [];
        foreach ($topWords as $docId => $words) {
            foreach ($words as $word => $tfidfValue) {
                $bubbleChartData[] = [
                    'name' => $word,
                    'value' => $tfidfValue
                ];
            }
        }
    
        Log::info('Prepared bubble chart data.');
    
        return view('tfidf_results', ['packedbubble_data' => json_encode($bubbleChartData)]);
    }
    
}
