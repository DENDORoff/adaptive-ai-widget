<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $latestNews = News::published()
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();


        $featuredNews = News::published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->take(1)
            ->first();


        $latestBlogPost = BlogPost::published()
            ->orderBy('published_at', 'desc')
            ->first();

        return view('home', compact('latestNews', 'featuredNews', 'latestBlogPost'));
    }
}