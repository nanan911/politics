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
        
        // 確保數據按日期排序
        $query = $query->sortBy('date');
    
        $colors = ['#FF69B4', '#FFD700', '#32CD32']; // 亮粉色、金色、绿色
        
        return $query->groupBy('word')->map(function ($grouped) use (&$colors) {
            $color = array_shift($colors); // 从颜色数组中取出一个颜色，并移除它
        
            return [
                'name' => $grouped->first()->word,
                'data' => $grouped->map(function ($item) {
                    return [strtotime($item->date) * 1000, $item->article_count];
                })->toArray(),
                'color' => $color, // 设置颜色属性为指定的颜色
                'lineWidth' => 3, // 设置线条粗细为 3
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
        $colors = ['#2eb9fa', '#FFD700', '#32CD32']; 
        
        $result = $query->groupBy('sentiment')->map(function ($grouped) use (&$colors) {
            $color = array_shift($colors) ?: '#000000'; // 如果顏色用盡，使用預設顏色
            return [
                'name' => $grouped->first()->sentiment,
                'data' => $grouped->groupBy('word')->map(function ($item) {
                    $articleCount = ($item->first()->sentiment === 'Negative')
                        ? -$item->sum('article_count')
                        : $item->sum('article_count');
                    return [$item->first()->word, $articleCount];
                })->sort(function ($a, $b) { 
                    // 正面單字應該排在前面
                    if ($a[1] >= 0 && $b[1] < 0) {
                        return -1; 
                    } elseif ($a[1] < 0 && $b[1] >= 0) {
                        return 1; 
                    } else {
                        return strcmp($a[0], $b[0]); 
                    }
                })->values()->toArray(), 
                'color' => $color,
            ];
        })->values()->toArray();
    
        return $result;
    }
    
public function getBubbleData(
    ?string $selectedIndustry,
    ?array $selectedWord,
    ?string $startDate,
    ?string $endDate,
    ?array $selectedClass,
    ?array $selectedSentiments
): array {
    // 从数据库获取数据
    $query = $this->analyticsRepository->getBubbleData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);
    
    // 检查查询结果是否有数据
    if ($query->isEmpty()) {
        return []; // 如果没有数据，返回空数组
    }

    $totalArticleCount = $query->first()->total_article_count; // 获取总文章数

    // 定义颜色数组
    $colors = ['#0000a9', '#009b01', '#24c8c9']; // 指定颜色
    $colorIndex = 0; // 颜色索引

    $wordData = $query->groupBy('word')->map(function ($grouped) use ($totalArticleCount, &$colors, &$colorIndex) {
        // 从颜色数组中取出一个颜色，并将其分配给当前词语
        $color = $colors[$colorIndex % count($colors)]; // 循环使用颜色
        $colorIndex++;

        return [
            'name' => $grouped->first()->word,
            'data' => $grouped->map(function ($item) use ($totalArticleCount, $color) {
                $percentage = $totalArticleCount > 0 ? ($item->article_count / $totalArticleCount) : 0; // 计算文章数百分比

                // 计算情感比例
                $sentimentSum = $item->sentiment_sum; // 总情感值
                $sentimentCount = $item->article_count; // 文章数量
                $sentimentPercentage = $sentimentCount > 0 ? ($sentimentSum / $sentimentCount) : 0; // 计算情感比例

                // 气泡大小根据文章数量计算
                $z = $item->article_count;

                return [
                    'name' => $item->word, // 名称
                    'color' => $color, // 颜色
                    'x' => $percentage, // X 轴值
                    'y' => $sentimentPercentage, // Y 轴值
                    'z' => $z, // 气泡大小
                    'article_count' => $item->article_count, // 文章数量
                    'sentiment_sum' => $sentimentSum // 总情感值
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

    return $query->map(function ($item) {
        return [
            'name' => $item['word'],
            'value' => $item['word_count'],
        ];
    })->values()->toArray();
}

public function getNetworkData(
    ?string $selectedIndustry,
    ?array $selectedWord,
    ?string $startDate,
    ?string $endDate,
    ?array $selectedClass,
    ?array $selectedSentiments,
    int $centralityThreshold=3,
): array {
    // 獲取查詢數據
    $query = $this->analyticsRepository->getNetworkData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);
    
    // 初始化節點和連接數組
    $nodes = [];
    $links = [];
    $nodeMap = [];
    $nodeId = 0;

    // 初始化節點出現次數
    $nodeOccurrences = [];

    // 生成節點和連接
    foreach ($query as $item) {
        if (!isset($nodeMap[$item->article_author])) {
            $nodeMap[$item->article_author] = $nodeId++;
            $nodes[] = ['id' => $nodeMap[$item->article_author], 'name' => $item->article_author];
            $nodeOccurrences[$nodeMap[$item->article_author]] = 0; // 初始化節點計數
        }
        if (!isset($nodeMap[$item->comment_author])) {
            $nodeMap[$item->comment_author] = $nodeId++;
            $nodes[] = ['id' => $nodeMap[$item->comment_author], 'name' => $item->comment_author];
            $nodeOccurrences[$nodeMap[$item->comment_author]] = 0; // 初始化節點計數
        }

        // 添加連接，避免自連接
        if ($nodeMap[$item->article_author] != $nodeMap[$item->comment_author]) {
            $links[] = [
                'from' => $nodeMap[$item->article_author],
                'to' => $nodeMap[$item->comment_author],
                'value' => $item->interaction_count
            ];
            // 增加節點計數
            $nodeOccurrences[$nodeMap[$item->article_author]]++;
            $nodeOccurrences[$nodeMap[$item->comment_author]]++;
        }
    }

    // 過濾掉中心性低於閾值的節點
    $validNodes = array_filter($nodeOccurrences, function($count) use ($centralityThreshold) {
        return $count >= $centralityThreshold; // 只保留中心性高於閾值的節點
    });
    $validNodeIds = array_keys($validNodes);

    // 過濾掉只有出現過一次的節點
    $nodes = array_filter($nodes, function($node) use ($validNodeIds) {
        return in_array($node['id'], $validNodeIds);
    });

    // 過濾掉無效的邊
    $links = array_filter($links, function($link) use ($validNodeIds) {
        return in_array($link['from'], $validNodeIds) && in_array($link['to'], $validNodeIds);
    });

    // 生成 Highcharts 所需的數據格式
    $series = [
        [
            'type' => 'networkgraph',
            'name' => 'Interactions',
            'data' => $nodes,
            'links' => $links,
            'dataLabels' => [
                'enabled' => true,
                'linkFormat' => '',
                'style' => [
                    'fontSize' => '0.9em',
                    'fontWeight' => 'normal',
                    'textOutline' => 'none'
                ]
            ],
            'id' => 'network'
        ]
    ];

    // 如果只需要 ['author1', 'author2'] 形式的数据
    $formattedLinks = [];
    foreach ($links as $link) {
        $formattedLinks[] = [
            $nodes[$link['from']]['name'],
            $nodes[$link['to']]['name']
        ];
    }

    return $formattedLinks; // 返回你期望的格式
}
public function getRankingData(
    ?string $selectedIndustry,
    ?array $selectedWord,
    ?string $startDate,
    ?string $endDate,
    ?array $selectedClass,
    ?array $selectedSentiments
): array {
    $query = $this->analyticsRepository->getRankingData($selectedIndustry, $selectedWord, $startDate, $endDate, $selectedClass, $selectedSentiments);

    $rankingData = [];
    
    foreach ($query as $item) {
        $rankingData[] = [
            'author_id' => $item->author_id,
            'author_name' => $item->author_name,
            'interaction_count' => $item->interaction_count,
            'latest_comment_date' => $item->latest_comment_date,
            'platform' => $item->source_class,
        ];
    }

    usort($rankingData, function ($a, $b) {
        return $b['interaction_count'] <=> $a['interaction_count'];
    });

    return $rankingData; // 返回 array
}



public function getPoliticianData(
    ?string $selectedIndustry,
    ?array $selectedWord,
    ?string $startDate,
    ?string $endDate,
    ?array $selectedClass,
    ?array $selectedSentiments
): array {
    $data = \DB::table('article_politician as ap')
        ->join('articles as a', 'ap.article_id', '=', 'a.id')
        ->join('politicians as p', 'ap.politician_id', '=', 'p.id')
        ->leftJoin('sentiments as s', 's.article_id', '=', 'a.id')  // 使用 article_id 連接
        ->select(
            'p.name',
            \DB::raw('COUNT(ap.politician_id) AS occurrences'),
            \DB::raw('SUM(CASE WHEN s.sentiments = "Positive" THEN 1 ELSE 0 END) AS positive_articles'),
            \DB::raw('SUM(CASE WHEN s.sentiments = "Negative" THEN 1 ELSE 0 END) AS negative_articles')
        )
        ->groupBy('p.id', 'p.name')
        ->orderBy('occurrences', 'DESC')
        ->limit(10)
        ->get();

    $categories = $data->pluck('name')->toArray();
    $positive_articles = $data->pluck('positive_articles')->toArray();
    $negative_articles = $data->pluck('negative_articles')->toArray();

    return [
        'categories' => $categories,
        'positive_articles' => $positive_articles,
        'negative_articles' => $negative_articles
    ];
}


}



