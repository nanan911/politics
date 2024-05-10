<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\ArticleKeyword;
use App\Models\Category;

use App\Models\Sentiment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ArticleRepositories
{
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
            ->join('sentiments as s', 's.article_id', '=', 'a.id')
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
                return $query->where('sentiment', $selectedSentiments);
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
            ->join('sentiments as s', 's.article_id', '=', 'a.id')
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
                return $query->where('sentiment', $selectedSentiments);
            })
            ->select('a.date', 'k.id', 'k.word', 's.sentiment', \DB::raw('COUNT(a.id) as article_count'))
            ->groupBy('a.date', 'k.id', 'k.word', 's.sentiment')
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
        return Article::from('articles as a')
            ->leftJoin('sentiments as s', 's.article_id', '=', 'a.id')
            ->leftJoin('article_sentiment as as', 'as.article_id', '=', 'a.id')
            ->join('sources', 'sources.id', '=', 'a.source_id')
            ->join('keyword_sets as ks', 'a.content', 'LIKE', \DB::raw("CONCAT('%', ks.word, '%')"))
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
                return $query->where('class', $selectedClass);
            })
            ->when($selectedSentiments, function ($query) use ($selectedSentiments) {
                return $query->where('sentiment', $selectedSentiments);
            })
            ->select('ks.id as keyword_set_id', 'ks.word', \DB::raw('COUNT(DISTINCT a.id) as article_count'))
            ->selectRaw('(SELECT COUNT(DISTINCT id) FROM articles) AS total_article_count')
            ->selectRaw('COUNT(DISTINCT as.sentiment_num) as sentiment_count')
            ->groupBy('ks.id', 'ks.word')
            ->get();
    }

    public function getPackedBubbleData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?array $selectedClass,
        ?array $selectedSentiments
    ): Collection {
        return Article::from('articles as a')
            ->leftJoin('sentiments as s', 's.article_id', '=', 'a.id')
            ->leftJoin('categories as c', 'c.article_id', '=', 'a.id')
            ->leftJoin('article_sentiment as as', 'as.article_id', '=', 'a.id')
            ->join('sources', 'sources.id', '=', 'a.source_id')
            //->join('keyword_sets as ks', 'a.content', 'LIKE', \DB::raw("CONCAT('%', ks.word, '%')"))
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
                return $query->where('sentiment', $selectedSentiments);
            })
            ->select('c.word', 'c.pos', DB::raw('COUNT(*) AS word_count'))
            ->groupBy('c.word', 'c.pos')
            ->orderByDesc('word_count')
            ->take(18) 
            ->get();
    }
    
    // public function getNetworkData(
    //     ?string $selectedIndustry,
    //     ?array $selectedWord,
    //     ?string $startDate,
    //     ?string $endDate,
    //     ?array $selectedClass,
    //     ?array $selectedSentiments
    // ): Collection {
    //     // 只查询需要的字段，减少不必要的数据传输
    //     return Article::from('articles as a')
    //         ->leftJoin('sources', 'sources.id', '=', 'a.source_id')
    //         ->leftJoin('authors', 'authors.article_id', '=', 'a.id')
    //         ->leftJoin('messages', 'messages.article_id', '=', 'a.id')
    //         ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
    //             return $query->where('industry', $selectedIndustry);
    //         })
    //         ->when($selectedWord, function ($query) use ($selectedWord) {
    //             return $query->whereIn('word', $selectedWord);
    //         })
    //         ->when($startDate, function ($query) use ($startDate) {
    //             return $query->where('a.date', '>=', $startDate);
    //         })
    //         ->when($endDate, function ($query) use ($endDate) {
    //             return $query->where('a.date', '<=', $endDate);
    //         })
    //         ->when($selectedClass, function ($query) use ($selectedClass) {
    //             return $query->where('class', $selectedClass);
    //         })
    //         ->when($selectedSentiments, function ($query) use ($selectedSentiments) {
    //             return $query->where('sentiment', $selectedSentiments);
    //         })
    //         ->select('authors.author', 'messages.poster', DB::raw('COUNT(*) AS word_count'))
    //         ->groupBy('authors.author', 'messages.poster')
    //         ->orderByDesc('word_count')
    //         ->take(150) // 限制结果数量为前100名
    //         ->get();
    // }
}