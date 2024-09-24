<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\ArticleKeyword;
use App\Models\Politician; 
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ArticleRepositories
{
    public function getAll(){
        $articles = Article::all();
        return $articles;
    }
    public function getTrendData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?array $selectedClass,
        ?array $selectedSentiments
    ): Collection {
        return ArticleKeyword::join('articles as a', 'a.id', '=', 'article_keywords.article_id')
            ->join('keyword_sets as k', 'k.id', '=', 'article_keywords.keyword_set_id')
            ->join('sources', 'sources.id', '=', 'a.source_id')
            ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
                return $query->where('industry', $selectedIndustry);
            })
            ->when($selectedWord, function ($query) use ($selectedWord) {
                return $query->whereIn('word', $selectedWord);
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('a.date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->where('a.date', '<=', $endDate);
            })
            ->when($selectedClass, function ($query) use ($selectedClass) {
                return $query->where('class', $selectedClass);
            })
            ->when($selectedSentiments, function ($query) use ($selectedSentiments) {
                // 如果 sentiment 字段存在于其他表中，你需要在查询中调整
                // 目前根据提供的信息，这一行会被忽略
                return $query;
            })
            ->select('a.date', 'k.id', 'k.word', DB::raw('COUNT(a.id) as article_count'))
            ->groupBy('a.date', 'k.id', 'k.word')
            ->get();
    }
    public function getColumnData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?array $selectedClass,
        ?array $selectedSentiments
    ): Collection {
        return ArticleKeyword::join('articles as a', 'a.id', '=', 'article_keywords.article_id')
            ->join('keyword_sets as k', 'k.id', '=', 'article_keywords.keyword_set_id')
            ->join('sources', 'sources.id', '=', 'a.source_id')
            ->join('sentiments as s', 's.article_id', '=', 'a.id') // 根據 sentiment 表中的 article_id 進行連接
            ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
                return $query->where('industry', $selectedIndustry);
            })
            ->when($selectedWord, function ($query) use ($selectedWord) {
                return $query->whereIn('k.word', $selectedWord); // 修正為 'k.word'
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('a.date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->where('a.date', '<=', $endDate);
            })
            ->when($selectedClass, function ($query) use ($selectedClass) {
                return $query->where('class', $selectedClass);
            })
            ->when($selectedSentiments, function ($query) use ($selectedSentiments) {
                // 根據 sentiments 欄位進行過濾
                return $query->whereIn('s.sentiments', $selectedSentiments);
            })
            ->select('a.date', 'k.id', 'k.word', 's.sentiments as sentiment', \DB::raw('COUNT(a.id) as article_count'))
            ->groupBy('a.date', 'k.id', 'k.word', 's.sentiments')
            ->get();
    }
    

    public function getBubbleData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?array $selectedClass,
        ?array $selectedSentiments
    ): Collection {
        return ArticleKeyword::from('article_keywords as ak')
            ->join('articles as a', 'ak.article_id', '=', 'a.id')
            ->leftJoin('sentiments as s', 's.article_id', '=', 'a.id')  // 根據 article_id 連接 sentiments 表
            ->join('sources', 'sources.id', '=', 'a.source_id')
            ->join('keyword_sets as ks', 'ak.keyword_set_id', '=', 'ks.id')
            ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
                return $query->where('industry', $selectedIndustry);
            })
            ->when($selectedWord, function ($query) use ($selectedWord) {
                return $query->whereIn('ks.word', $selectedWord);
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('a.date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->where('a.date', '<=', $endDate);
            })
            ->when($selectedClass, function ($query) use ($selectedClass) {
                return $query->whereIn('a.class', $selectedClass);
            })
            ->when($selectedSentiments, function ($query) use ($selectedSentiments) {
                return $query->whereIn('s.sentiments', $selectedSentiments);  // 使用 sentiments 欄位
            })
            ->select('ks.id as keyword_set_id', 'ks.word', \DB::raw('COUNT(DISTINCT a.id) as article_count'))
            ->selectRaw('(SELECT COUNT(DISTINCT id) FROM articles) AS total_article_count')
            ->selectRaw('SUM(CASE WHEN s.sentiments = "Positive" THEN 1 WHEN s.sentiments = "Negative" THEN -1 ELSE 0 END) as sentiment_sum')  // 根據 sentiments 欄位進行總和計算
            ->groupBy('ks.id', 'ks.word')
            ->get();
    }

    public function getPackedBubbleData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments) {
        // 使用 Common Table Expressions (CTE) 进行查询
        $keywords = DB::table(DB::raw('(
            WITH RankedWords AS (
                SELECT id, article_id, word, tf_idf, ROW_NUMBER() OVER (PARTITION BY article_id ORDER BY tf_idf DESC) AS rn
                FROM tfidf
            ), TopWords AS (
                SELECT word
                FROM RankedWords
                WHERE rn <= 20
            )
            SELECT word, COUNT(*) AS frequency
            FROM TopWords
            GROUP BY word
            ORDER BY frequency DESC
            LIMIT 20
        ) AS keyword_data'))
        ->select('word', 'frequency')
        ->get()
        ->map(function ($item) {
            return [
                'word' => $item->word,
                'word_count' => $item->frequency,
            ];
        });
    
        return $keywords;
    }
    
    

    
    public function getNetworkData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate = '2024-06-05',
        ?string $endDate,
        ?array $selectedClass,
        ?array $selectedSentiments
    ): Collection {
        return Article::from('articles as a')
            ->leftJoin('comments as c', 'c.article_id', '=', 'a.id')  // 连接评论
            ->leftJoin('authors as c_auth', 'c.author_id', '=', 'c_auth.id') // 连接评论的作者
            ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
                return $query->where('a.industry', $selectedIndustry);
            })
            ->when($selectedWord, function ($query) use ($selectedWord) {
                return $query->whereIn('a.title', $selectedWord);  // 假設你希望用 title 進行過濾
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('a.date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->where('a.date', '<=', $endDate);
            })
            ->when($selectedClass, function ($query) use ($selectedClass) {
                return $query->whereIn('a.class', $selectedClass);
            })
            ->when($selectedSentiments, function ($query) use ($selectedSentiments) {
                return $query->whereIn('c.sentiment', $selectedSentiments);
            })
            ->select(
                'a.author as article_author',  // 文章作者
                'c_auth.name as comment_author',  // 评论者
                DB::raw('COUNT(c.id) AS interaction_count')  // 计算评论数量（互动次数）
            )
            ->groupBy('a.author', 'c_auth.name')  // 按文章作者和评论者分组
            ->orderByDesc('interaction_count')  // 按互动次数排序
            ->take(300)  // 限制结果数量为前150
            ->get();
    }
    
    public function getRankingData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?array $selectedClass,
        ?array $selectedSentiments
    ): Collection {
        return Article::from('articles as a')
            ->leftJoin('comments as c', 'c.article_id', '=', 'a.id')
            ->leftJoin('authors as c_auth', 'c.author_id', '=', 'c_auth.id')
            ->leftJoin('sources as s', 'a.source_id', '=', 's.id')
            ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
                return $query->where('a.industry', $selectedIndustry);
            })
            ->when($selectedWord, function ($query) use ($selectedWord) {
                return $query->whereIn('a.title', $selectedWord);
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('a.date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->where('a.date', '<=', $endDate);
            })
            ->when($selectedClass, function ($query) use ($selectedClass) {
                return $query->whereIn('a.class', $selectedClass);
            })
            ->when($selectedSentiments, function ($query) use ($selectedSentiments) {
                return $query->whereIn('c.sentiment', $selectedSentiments);
            })
            ->select(
                'c_auth.name as author_name',
                'c_auth.id as author_id',  // 确保包含 author_id
                DB::raw('COUNT(c.id) AS interaction_count'),
                DB::raw('MAX(a.date) AS latest_comment_date'),
                's.class AS source_class'
            )
            ->groupBy('c_auth.name', 'c_auth.id', 's.class')
            ->orderByDesc('interaction_count')
            ->take(10)
            ->get();
    }

    public function getPoliticianData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?array $selectedClass,
        ?array $selectedSentiments
    ): Collection {
        return Article::query()
            ->leftJoin('article_politician as ap', 'ap.article_id', '=', 'articles.id')
            ->leftJoin('politicians as p', 'p.id', '=', 'ap.politician_id')
            ->leftJoin('sentiments as s', 's.id', '=', 'articles.sentimen_id')  // 连接情绪表
            ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
                return $query->where('industry', $selectedIndustry);
            })
            ->when($selectedWord, function ($query) use ($selectedWord) {
                return $query->whereIn('title', $selectedWord);  // 假设关键词存在于文章标题中
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->where('date', '<=', $endDate);
            })
            ->when($selectedClass, function ($query) use ($selectedClass) {
                return $query->whereIn('class', $selectedClass);
            })
            ->when($selectedSentiments, function ($query) use ($selectedSentiments) {
                return $query->whereIn('s.sentiment', $selectedSentiments);  // 修正情绪条件
            })
            ->select('p.name as politician_name', \DB::raw('COUNT(ap.politician_id) AS occurrences'))
            ->groupBy('p.id', 'p.name')
            ->orderBy('occurrences', 'DESC')
            ->limit(10)
            ->get();
    }
    
    
}

