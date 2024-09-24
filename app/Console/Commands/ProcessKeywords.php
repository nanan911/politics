<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ArticleService;

class ProcessKeywords extends Command
{
    protected $signature = 'keywords:process {articleId}';
    protected $description = 'Process keywords in the specified article';

    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        parent::__construct();
        $this->articleService = $articleService;
    }

    public function handle()
    {
        $articleId = $this->argument('articleId');
        $this->articleService->processKeywordsInArticle($articleId);
        $this->info('Keywords processed successfully');
    }
}
