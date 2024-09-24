<?php

namespace App\Services;

use App\Models\Politician;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PoliticianService
{
    public function analyzeArticles(Collection $articles): array
    {
        $politicians = Politician::all();
        $results = [];

        foreach ($articles as $article) {
            foreach ($politicians as $politician) {
                $allNames = array_merge([$politician->name], json_decode($politician->nicknames, true));
                foreach ($allNames as $name) {
                    if (stripos($article->content, $name) !== false) {
                        // 紀錄政治人物討論次數
                        if (!isset($results[$politician->name])) {
                            $results[$politician->name] = 0;
                        }
                        $results[$politician->name]++;
                    }
                }
            }
        }

        return $results;
    }
}
