<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::published()->latest()->paginate(12);
        return view('pages.articles.index', compact('articles'));
    }

    public function show(Article $article): View
    {
        if (!$article->published) {
            abort(404);
        }

        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->latest()
            ->take(3)
            ->get();

        return view('pages.articles.show', compact('article', 'relatedArticles'));
    }
}
