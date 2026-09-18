<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::published()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('news.index', compact('news'));
    }

    public function show($slug)
    {
        $newsItem = News::where('slug', $slug)
            ->published()
            ->firstOrFail();


        $relatedNews = News::published()
            ->where('id', '!=', $newsItem->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('news.show', compact('newsItem', 'relatedNews'));
    }
}