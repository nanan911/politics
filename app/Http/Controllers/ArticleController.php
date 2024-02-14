<?php

namespace App\Http\Controllers;

use App\Models\ArticleKeyword;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request, int $perPage = 10)
    {
        // 檢查是否有查詢條件，如果有則導向 searchArticles 方法處理
        if ($request->hasAny(['selected_industry', 'selected_word', 'start_date', 'end_date', 'selected_class', 'selected_sentiment'])) {
            return $this->searchArticles($request);
        }

        // 如果沒有查詢條件，則顯示所有文章
        $articles = Article::with('source')->paginate($perPage);

        return view('article', ['articles' => $articles]);
    }


    public function searchArticles(Request $request)
    {
        // 取得條件篩選表單中的輸入數據
        $selectedIndustry = $request->input('selected_industry');
        $selectedWords = $request->input('selected_word', []); // 預設為空陣列
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedClasses = $request->input('selected_class', []); // 預設為空陣列
        $selectedSentiments = $request->input('selected_sentiment', []); // 預設為空陣列

        // 根據條件進行文章查詢
        $query = ArticleKeyword::join('articles as a', 'a.id', '=', 'article_keywords.article_id')
            ->join('keyword_sets as k', 'k.id', '=', 'article_keywords.keyword_set_id')
            ->join('sentiments as s', 's.article_id', '=', 'a.id')
            ->join('sources', 'sources.id', '=', 'a.source_id')
            ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
                return $query->where('sources.industry', $selectedIndustry);
            })
            ->when($selectedWords, function ($query) use ($selectedWords) {
                return $query->whereIn('k.word', $selectedWords);
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('a.date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->where('a.date', '<=', $endDate);
            })
            ->when($selectedClasses, function ($query) use ($selectedClasses) {
                return $query->whereIn('sources.class', $selectedClasses);
            })
            ->when($selectedSentiments, function ($query) use ($selectedSentiments) {
                return $query->whereIn('s.sentiment', $selectedSentiments);
            })
            ->paginate(10);

        // 返回視圖，並將查詢結果傳遞給視圖
        return view('article', compact('query'));
    }
}
