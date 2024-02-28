<?php

namespace App\Services;

use App\Repositories\ArticleRepositories;

class AnalyticsService
{
    protected $analyticsRepository;

    public function __construct(ArticleRepositories $analyticsRepository)
    {
        $this->analyticsRepository = $analyticsRepository;
    }

    public function getTrendData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?array $selectedClass,
        ?array $selectedSentiments
    ): array {
        $query = $this->analyticsRepository->getTrendData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);

        return $query->groupBy('word')->map(function ($grouped) {
            return [
                'name' => $grouped->first()->word,
                'data' => $grouped->map(function ($item) {
                    return [strtotime($item->date) * 1000, $item->article_count];
                })->toArray(),
            ];
        })->values()->toArray();
        
    }

    public function getColumnData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?array $selectedClass,
        ?array $selectedSentiments
    ): array {
        $query = $this->analyticsRepository->getColumnData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);

        return $query->groupBy('sentiment')->map(function ($grouped) {
            return [
                'name' => $grouped->first()->sentiment,
                'data' => $grouped->groupBy('word')->map(function ($item) {
                    $articleCount = ($item->first()->sentiment === 'Negative')
                        ? -$item->sum('article_count')
                        : $item->sum('article_count');
                    return [$item->first()->word, $articleCount];
                })->values()->toArray(),
            ];
        })->values()->toArray();
    }

    public function getBubbleData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?array $selectedClass,
        ?array $selectedSentiments
    ): array {
        $query = $this->analyticsRepository->getBubbleData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);
    
        $totalArticleCount = $query->first()->total_article_count; // 取得總文章數
    
        $wordData = $query->groupBy('word')->map(function ($grouped) use ($totalArticleCount) {
            return [
                'name' => $grouped->first()->word,
                'data' => $grouped->map(function ($item) use ($totalArticleCount) {
                    $percentage = $item->article_count / $totalArticleCount; // 計算文章數百分比
                    $percentage2 = $item->sentiment_count / $totalArticleCount; // 計算情感數百分比
                    return [$percentage, $percentage2, $item->article_count, $item->sentiment_count];
                })->toArray(),
            ];
        })->values()->toArray();
    
        return array_merge($wordData);
    }
    public function getPackedBubbleData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?array $selectedClass,
        ?array $selectedSentiments
    ): array {
        $query = $this->analyticsRepository->getPackedBubbleData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);
    
        return $query->groupBy('pos')->map(function ($grouped) {
            $pos = $grouped->first()->pos;
            $categoryName = $this->mapPosToCategoryName($pos);
    
            return [
                'name' => $categoryName,
                'data' => $grouped->map(function ($item) {
                    return [
                        'name' => $item->word,
                        'value' => $item->word_count,
                    ];
                })->toArray(),
            ];
        })->values()->toArray();
    }
    
    private function mapPosToCategoryName($pos)
    {
        // 根據不同的 pos 映射到相應的類別名稱
        switch ($pos) {
            case 'A':
                return '形容詞';
            case 'Na':
                return '名詞';
            case 'Nb':
                return '通稱名詞';
            default:
                return '其他';
        }
    }
    
}
    