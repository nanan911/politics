<?php

namespace App\Http\Controllers;

use App\Models\TemporaryArticle;
use App\Models\Article;

class ArticleTransferController extends Controller
{
    public function transfer()
    {
        $temporaryArticles = TemporaryArticle::where('is_analyzed', true)->get();

        foreach ($temporaryArticles as $temporaryArticle) {
            Article::updateOrCreate([
                'address' => $temporaryArticle->address
            ], $temporaryArticle->toArray());

            // Optionally delete or mark as transferred
            $temporaryArticle->delete();
        }

        return redirect()->route('articles.index')->with('success', 'Articles transferred successfully.');
    }
    public function index()
    {
        $articles = Article::all();
        return view('articles.templates.index', ['articles' => $articles]);
    }

}
