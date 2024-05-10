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
        $articles = Article::with('source', 'sentiment')->paginate($perPage);

    
        return view('article', ['articles' => $articles]);
    }
    

    public function show($id)
    {
        // 通过文章 ID 获取文章数据
        $article = Article::find($id);

        // 如果找不到对应的文章，返回 404 错误页面
        if (!$article) {
            abort(404);
        }

        // 将文章数据传递给视图并渲染文章详情页面
        return view('articles.show', compact('article'));
    }
    

    public function searchArticles(Request $request)
    {
        // 获取筛选条件
        $selectedIndustry = $request->input('selected_industry');
        $selectedWords = $request->input('selected_word', []);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedClasses = $request->input('selected_class', []);
        $selectedSentiments = $request->input('selected_sentiment', ['Positive', 'Negative']);

    
        // 根据条件进行文章查询
        $query = Article::with('source', 'sentiment')
    ->join('article_keywords as ak', 'ak.article_id', '=', 'articles.id')
    ->join('keyword_sets as k', 'k.id', '=', 'ak.keyword_set_id')
    ->join('sentiments as s', 's.article_id', '=', 'articles.id')
    ->join('sources', 'sources.id', '=', 'articles.source_id')
    ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
        return $query->where('sources.industry', $selectedIndustry);
    })
    ->when($selectedWords, function ($query) use ($selectedWords) {
        return $query->whereIn('k.word', $selectedWords);
    })
    ->when($startDate, function ($query) use ($startDate) {
        return $query->where('articles.date', '>=', $startDate);
    })
    ->when($endDate, function ($query) use ($endDate) {
        return $query->where('articles.date', '<=', $endDate);
    })
    ->when($selectedClasses, function ($query) use ($selectedClasses) {
        return $query->whereIn('sources.class', $selectedClasses);
    })
    ->when($selectedSentiments, function ($query) use ($selectedSentiments) {
        return $query->whereIn('s.sentiment', $selectedSentiments);
    });

// 执行查询并分页
$articles = $query->paginate(10);

// 返回视图，传递查询结果
return view('article', compact('articles'));
    }
    

    
}
