<?php
namespace App\Services;
use App\Models\Article;
use App\Models\KeywordSet;

class ArticleService
{
    public function processKeywordsInArticle($articleId)
    {
        $article = Article::find($articleId);
        if (!$article) {
            return;
        }

        $content = $article->content;
        $keywords = KeywordSet::all();

        foreach ($keywords as $keyword) {
            if (stripos($content, $keyword->word) !== false) {
                $article->keywords()->syncWithoutDetaching([$keyword->id]);
            }
        }
    }
}
