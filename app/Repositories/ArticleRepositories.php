<?php

namespace App\Repositories;

use App\Models\ArticleKeyword;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ArticleRepositories
{
    public function getTrendData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?string $selectedClass,
        ?string $selectedSentiments
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

    public function getBarData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?string $selectedClass,
        ?string $selectedSentiments
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
}
