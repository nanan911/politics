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
        ?string $selectedClass,
        ?string $selectedSentiments
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

    public function getBarData(
        ?string $selectedIndustry,
        ?array $selectedWord,
        ?string $startDate,
        ?string $endDate,
        ?string $selectedClass,
        ?string $selectedSentiments
    ): array {
        $query = $this->analyticsRepository->getBarData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);

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
}
