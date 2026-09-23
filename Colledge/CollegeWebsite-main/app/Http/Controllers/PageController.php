<?php

namespace App\Http\Controllers;

use App\Models\Council;
use App\Models\HistoryTimeline;
use App\Models\YouthEvent; 
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $timelineEvents = HistoryTimeline::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        return view('pages.about', compact('timelineEvents'));
    }
    
    public function applicants()
    {
        return view('pages.applicants');
    }
    
    public function students()
    {
        return view('pages.students');
    }
    
    public function collaborations()
    {
        return view('collaborations.collaborations');
    }

    public function antiCorruption()
    {
        return view('anti-corruption.anti-corruption');
    }

    public function governmentServices()
    {
        return redirect()->route('expertise.index');
    }

    public function sovet()
    {
       
        $councils = Council::with(['documents' => function($query) {
                $query->where('is_visible', true)
                      ->orderBy('order');
            }])
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->each(function ($council) {
                
                $council->documents_count = $council->documents->count();
            });

        return view('sovet.index', compact('councils'));
    }

    public function tradeUnion()
    {
        return view('trade-union.index');
    }

    public function youthMovement()
    {
        
        $featuredEvent = YouthEvent::where('is_featured', true)
            ->where('is_published', true)
            ->orderBy('event_date', 'desc')
            ->first();
        
        return view('youth-movement.index', compact('featuredEvent'));
    }
}