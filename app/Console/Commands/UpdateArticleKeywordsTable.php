<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\ArticleKeyword;
use App\Models\KeywordSet;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateArticleKeywordsTable extends Command
{
    protected $signature = 'update:article-keywords';
    protected $description = 'Update the article_keywords table from articles and keyword_sets';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Article Keywords table updated start!');
        ArticleKeyword::truncate();

        $keywordSets = KeywordSet::all();

        $keywordSets->each(function (KeywordSet $keywordSet) {
            try {
                $set = $keywordSet->set;

                $article_ids = Article::where(function ($query) use ($set) {
                    foreach ($set as $word) {
                        $query->orWhere('content', 'like', "%{$word}%");
                    }
                })->pluck('id')->toArray();


                $keywordSet->articles()->attach($article_ids, ['created_at' => now(), 'updated_at' => now()]);

                $this->info("{$keywordSet->word} updated");
            } catch (Exception $e) {
                Log::error('error');
            }
        });


        $this->info('Article Keywords table updated successfully!');
    }
}
