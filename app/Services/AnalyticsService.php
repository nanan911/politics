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
    
        $colors = ['#FF69B4', '#FFD700', '#32CD32']; // 亮粉色、金色、绿色
    
        return $query->groupBy('word')->map(function ($grouped) use (&$colors) {
            $color = array_shift($colors); // 从颜色数组中取出一个颜色，并移除它
    
            return [
                'name' => $grouped->first()->word,
                'data' => $grouped->map(function ($item) {
                    return [strtotime($item->date) * 1000, $item->article_count];
                })->toArray(),
                'color' => $color, // 设置颜色属性为指定的颜色
                'lineWidth' => 3, // 设置线条粗细为 2
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
                /* 自己調的#2eb9fa; */

        $colors = ['#2eb9fa', '#FFD700', '#32CD32']; 
        
        return $query->groupBy('sentiment')->map(function ($grouped) use (&$colors) {
            $color = array_shift($colors); // 从颜色数组中取出一个颜色，并移除它
            return [
                'name' => $grouped->first()->sentiment,
                'data' => $grouped->groupBy('word')->map(function ($item) {
                    $articleCount = ($item->first()->sentiment === 'Negative')
                        ? -$item->sum('article_count')
                        : $item->sum('article_count');
                    return [$item->first()->word, $articleCount];
                })->values()->toArray(),
                'color' => $color,
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
    
        $totalArticleCount = $query->first()->total_article_count; // 获取总文章数
    
        // 定义颜色数组
        $colors = [ '#0000a9', '#009b01','#24c8c9']; // 指定顏色
    
        $wordData = $query->groupBy('word')->map(function ($grouped) use ($totalArticleCount, &$colors) {
            // 从颜色数组中取出一个颜色，并将其分配给当前词语
            $color = array_shift($colors);
    
            return [
                'name' => $grouped->first()->word,
                'data' => $grouped->map(function ($item) use ($totalArticleCount, $color) {
                    $percentage = $item->article_count / $totalArticleCount; // 计算文章数百分比
                    $percentage2 = $item->sentiment_count / $totalArticleCount; // 计算情感数百分比
                    
                    // 氣泡大小根據文章數量計算，您可以根據需要修改這裡的邏輯
                    $z = $item->article_count; 
    
                    return [
                        'name' => $item->word, // 名稱
                        'country' => $item->country, // 國家（如果適用）
                        'color' => $color, // 颜色
                        'x' => $percentage, // X 軸值
                        'y' => $percentage2, // Y 軸值
                        'z' => $z, // 氣泡大小
                        'article_count' => $item->article_count, // 文章數量
                        'sentiment_count' => $item->sentiment_count // 情感數量
                    ];
                })->toArray()
            ];
        })->values()->toArray();
    
        return $wordData;
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
                return '政治議題';
            case 'Nb1':
                return '政黨與人物';
            default:
                return '其他';
        }
    }

    // public function getNetworkData(
    //     ?string $selectedIndustry,
    //     ?array $selectedWord,
    //     ?string $startDate,
    //     ?string $endDate,
    //     ?array $selectedClass,
    //     ?array $selectedSentiments
    // ): array {
    //     $query = $this->analyticsRepository->getNetworkData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);
        
    //     // 生成格式化后的数据数组
    //     $formattedData = [];
    //     foreach ($query as $item) {
    //         $formattedData[] = [$item->author, $item->poster];
    //     }
    //     $series = [
    //         [
    //             'accessibility' => ['enabled' => false],
    //             'dataLabels' => [
    //                 'enabled' => true,
    //                 'linkFormat' => '',
    //                 'style' => [
    //                     'fontSize' => '0.9em',
    //                     'fontWeight' => 'normal',
    //                     'textOutline' => 'none'
    //                 ]
    //             ],
    //             'id' => 'lang-tree',
    //             'data' => $formattedData,
    //         ]
    //     ];
    //     return $series;
    // }
    
 
}

