<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Question;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index(Request $request)
    {

        $posts = BlogPost::published()
            ->latest('published_at')
            ->paginate(5, ['*'], 'page');


        $publishedQuestions = Question::published()
            ->latest()
            ->paginate(3, ['*'], 'faq_page');


        $activeTab = 'greeting'; 
        
        if ($request->has('faq_page') || $request->has('tab') && $request->tab === 'questions') {
            $activeTab = 'questions';
        }

        return view('blog.index', compact('posts', 'publishedQuestions', 'activeTab'));
    }


    public function show(string $slug)
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->firstOrFail();


        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}