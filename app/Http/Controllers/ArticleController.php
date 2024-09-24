<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\KeywordSet;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request, int $perPage = 10)
    {
        // 检查是否有过滤条件
        if ($request->hasAny(['selected_industry', 'selected_word', 'start_date', 'end_date', 'selected_class', 'selected_sentiment'])) {
            return $this->searchArticles($request);
        }

        // 查询文章，并关联源和情感
        $articles = Article::with('source', 'sentiment')->paginate($perPage);

        // 返回 JSON 或视图
        return $request->wantsJson()
            ? response()->json($articles)
            : view('article', ['articles' => $articles]);
    }

    public function show($id)
    {
        // 获取单个文章，包括评论
        $article = Article::with(['source', 'comments'])->find($id);
        
        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        // 检查请求是否期望 JSON 响应
        if (request()->is('api/*')) {
            return response()->json([
                'article' => $article,
                'comments' => $article->comments
            ]);
        }
        
        // 如果不是 API 请求，返回视图
        return view('articles.show', [
            'article' => $article,
            'comments' => $article->comments
        ]);
    }



    


    public function searchArticles(Request $request)
    {
        $selectedIndustry = $request->input('selected_industry');
        $selectedWords = $request->input('selected_word');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedClasses = $request->input('selected_class');
        $selectedSentiments = $request->input('selected_sentiment', ['Positive', 'Negative']);
    
        $query = Article::with(['source', 'sentiment', 'author'])
            ->join('article_keywords as ak', 'ak.article_id', '=', 'articles.id')
            ->join('keywords as k', 'k.id', '=', 'ak.keyword_id')
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
                return $query->whereHas('sentiment', function ($q) use ($selectedSentiments) {
                    $q->whereIn('sentiment', $selectedSentiments);
                });
            });
    
        $articles = $query->paginate(10);
    
        return view('article', compact('articles'));
    }
}    
